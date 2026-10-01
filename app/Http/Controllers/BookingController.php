<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PhoneModel;
use App\Models\RepairService;
use App\Models\RepairStatusLog;
use App\Models\RepairTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * แสดงฟอร์มแจ้งซ่อมออนไลน์ (ลูกค้าทั่วไป)
     */
    public function create()
    {
        $models = PhoneModel::where('is_active', true)->orderBy('series', 'desc')->get();
        $services = RepairService::where('is_active', true)->get();

        return view('frontend.booking.create', compact('models', 'services'));
    }

    /**
     * บันทึกข้อมูลการแจ้งซ่อมและสร้างรหัสติดตาม
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'customer_line' => 'nullable|string|max:50',
            'customer_email' => 'nullable|email|max:100',
            'customer_address' => 'nullable|string|max:255',
            'phone_model_id' => 'required|exists:phone_models,id',
            'repair_service_id' => 'nullable|exists:repair_services,id',
            'device_color' => 'nullable|string|max:50',
            'device_passcode' => 'nullable|string|max:20',
            'imei_serial' => 'nullable|string|max:30',
            'symptom_description' => 'required|string|min:5|max:1000',
            'service_type' => 'required|in:online_booking,walk_in,delivery',
        ], [
            'customer_name.required' => 'กรุณากรอกชื่อ-นามสกุลของท่าน',
            'customer_phone.required' => 'กรุณากรอกเบอร์โทรศัพท์สำหรับติดต่อ',
            'phone_model_id.required' => 'กรุณาเลือกรุ่น iPhone',
            'symptom_description.required' => 'กรุณาระบุอาการเสียหรือปัญหาที่พบ',
            'symptom_description.min' => 'กรุณาระบุอาการเสียอย่างน้อย 5 ตัวอักษร',
        ]);

        return DB::transaction(function () use ($request) {
            // 1. ค้นหาหรือสร้างข้อมูลลูกค้า
            $cleanPhone = trim($request->customer_phone);
            $customer = Customer::where('phone', $cleanPhone)->first();

            if (!$customer) {
                $customer = Customer::create([
                    'name' => $request->customer_name,
                    'phone' => $cleanPhone,
                    'email' => $request->customer_email,
                    'line_id' => $request->customer_line,
                    'address' => $request->customer_address,
                    'notes' => 'แจ้งซ่อมผ่านระบบออนไลน์',
                ]);
            } else {
                // อัปเดตข้อมูลลูกค้า
                $customer->update([
                    'name' => $request->customer_name,
                    'line_id' => $request->customer_line ?? $customer->line_id,
                    'email' => $request->customer_email ?? $customer->email,
                    'address' => $request->customer_address ?? $customer->address,
                ]);
            }

            // 2. สร้างเลขที่ใบรับซ่อม (Ticket Number) Format: REP-YYYYMM-XXX
            $monthPrefix = 'REP-' . date('Ym') . '-';
            $lastTicket = RepairTicket::where('ticket_number', 'LIKE', $monthPrefix . '%')
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = 1;
            if ($lastTicket) {
                $parts = explode('-', $lastTicket->ticket_number);
                $nextNumber = intval(end($parts)) + 1;
            }
            $ticketNumber = $monthPrefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // 3. คำนวณราคาประเมินเบื้องต้น
            $estimatedCost = 0;
            if ($request->repair_service_id) {
                $service = RepairService::find($request->repair_service_id);
                $estimatedCost = $service ? $service->base_price : 0;
            } else {
                $model = PhoneModel::find($request->phone_model_id);
                $estimatedCost = $model ? $model->base_screen_price : 1500;
            }

            // 4. บันทึก Ticket
            $ticket = RepairTicket::create([
                'ticket_number' => $ticketNumber,
                'customer_id' => $customer->id,
                'phone_model_id' => $request->phone_model_id,
                'repair_service_id' => $request->repair_service_id,
                'device_color' => $request->device_color ?? 'ไม่ระบุสี',
                'imei_serial' => $request->imei_serial,
                'device_passcode' => $request->device_passcode,
                'symptom_description' => $request->symptom_description,
                'service_type' => $request->service_type,
                'status' => 'pending',
                'priority' => 'normal',
                'estimated_cost' => $estimatedCost,
            ]);

            // 5. บันทึก Timeline Status Log แรกเริ่ม
            RepairStatusLog::create([
                'repair_ticket_id' => $ticket->id,
                'status' => 'pending',
                'title' => 'ลงทะเบียนแจ้งซ่อมผ่านระบบออนไลน์สำเร็จ',
                'note' => 'ระบบได้รับคำขอแจ้งซ่อมเรียบร้อย รอนำเครื่องเข้าตรวจเช็คหน้าร้าน หรือจัดส่งเครื่อง',
                'performed_by' => 'ระบบอัตโนมัติ (Online Booking)',
            ]);

            return redirect()->route('booking.success', $ticket->ticket_number);
        });
    }

    /**
     * หน้าแจ้งผลการส่งคำขอสำเร็จ พร้อมปุ่มติดตามและพิมพ์ใบรับเครื่อง
     */
    public function success($ticket_number)
    {
        $ticket = RepairTicket::with(['customer', 'phoneModel', 'repairService'])
            ->where('ticket_number', strtoupper($ticket_number))
            ->firstOrFail();

        return view('frontend.booking.success', compact('ticket'));
    }
}
