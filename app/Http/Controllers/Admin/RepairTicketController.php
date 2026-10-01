<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PhoneModel;
use App\Models\RepairService;
use App\Models\RepairStatusLog;
use App\Models\RepairTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RepairTicketController extends Controller
{
    /**
     * รายการใบแจ้งซ่อมทั้งหมด มีระบบค้นหาและตัวกรองสถานะ
     */
    public function index(Request $request)
    {
        $query = RepairTicket::with(['customer', 'phoneModel', 'repairService', 'technician']);

        // กรองตามสถานะ
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ค้นหาตามคำสำคัญ (Ticket Number, ชื่อลูกค้า, เบอร์โทรศัพท์, IMEI)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'LIKE', "%{$search}%")
                  ->orWhere('imei_serial', 'LIKE', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('phone', 'LIKE', "%{$search}%");
                  });
            });
        }

        $tickets = $query->latest()->paginate(12)->withQueryString();

        $statusCounts = [
            'all' => RepairTicket::count(),
            'pending' => RepairTicket::where('status', 'pending')->count(),
            'inspecting' => RepairTicket::where('status', 'inspecting')->count(),
            'waiting_parts' => RepairTicket::where('status', 'waiting_parts')->count(),
            'repairing' => RepairTicket::where('status', 'repairing')->count(),
            'completed' => RepairTicket::where('status', 'completed')->count(),
            'delivered' => RepairTicket::where('status', 'delivered')->count(),
        ];

        return view('admin.tickets.index', compact('tickets', 'statusCounts'));
    }

    /**
     * ฟอร์มเปิดงานซ่อมใหม่จากหน้าร้าน (Walk-in Repair)
     */
    public function create()
    {
        $models = PhoneModel::where('is_active', true)->orderBy('series', 'desc')->get();
        $services = RepairService::where('is_active', true)->get();
        $technicians = User::whereIn('role', ['admin', 'technician'])->get();
        $customers = Customer::orderBy('name')->get();

        return view('admin.tickets.create', compact('models', 'services', 'technicians', 'customers'));
    }

    /**
     * บันทึกข้อมูลงานซ่อมใหม่
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'phone_model_id' => 'required|exists:phone_models,id',
            'repair_service_id' => 'nullable|exists:repair_services,id',
            'symptom_description' => 'required|string|min:3',
            'estimated_cost' => 'required|numeric|min:0',
        ], [
            'customer_name.required' => 'กรุณากรอกชื่อลูกค้า',
            'customer_phone.required' => 'กรุณากรอกเบอร์โทรศัพท์ลูกค้า',
            'phone_model_id.required' => 'กรุณาเลือกรุ่น iPhone',
            'symptom_description.required' => 'กรุณาระบุอาการเสีย',
            'estimated_cost.required' => 'กรุณาระบุราคาประเมิน',
        ]);

        return DB::transaction(function () use ($request) {
            // ค้นหาหรือบันทึกลูกค้า
            $customer = Customer::firstOrCreate(
                ['phone' => trim($request->customer_phone)],
                [
                    'name' => $request->customer_name,
                    'line_id' => $request->customer_line,
                    'email' => $request->customer_email,
                    'address' => $request->customer_address,
                ]
            );

            // สร้าง Ticket Number
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

            $ticket = RepairTicket::create([
                'ticket_number' => $ticketNumber,
                'customer_id' => $customer->id,
                'phone_model_id' => $request->phone_model_id,
                'repair_service_id' => $request->repair_service_id,
                'device_color' => $request->device_color ?? 'ไม่ระบุ',
                'imei_serial' => $request->imei_serial,
                'device_passcode' => $request->device_passcode,
                'symptom_description' => $request->symptom_description,
                'device_condition' => $request->device_condition,
                'service_type' => $request->service_type ?? 'walk_in',
                'status' => 'pending',
                'priority' => $request->priority ?? 'normal',
                'estimated_cost' => $request->estimated_cost,
                'assigned_to' => $request->assigned_to ?? Auth::id(),
                'technician_notes' => $request->technician_notes,
            ]);

            RepairStatusLog::create([
                'repair_ticket_id' => $ticket->id,
                'status' => 'pending',
                'title' => 'รับเครื่องและเปิดใบแจ้งซ่อมหน้าร้าน',
                'note' => 'เจ้าหน้าที่เปิดใบแจ้งซ่อม ตรวจสอบภายนอกและส่งต่อแผนกช่าง',
                'performed_by' => Auth::user()->name,
            ]);

            return redirect()->route('admin.tickets.show', $ticket->id)
                ->with('success', "เปิดใบรับซ่อมรหัส {$ticket->ticket_number} เรียบร้อยแล้ว");
        });
    }

    /**
     * ดูรายละเอียดใบแจ้งซ่อม พร้อมกล่องอัปเดตสถานะและไทม์ไลน์
     */
    public function show($id)
    {
        $ticket = RepairTicket::with([
            'customer',
            'phoneModel',
            'repairService',
            'technician',
            'statusLogs' => function ($q) {
                $q->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        $technicians = User::whereIn('role', ['admin', 'technician'])->get();

        return view('admin.tickets.show', compact('ticket', 'technicians'));
    }

    /**
     * แก้ไขข้อมูลใบแจ้งซ่อม
     */
    public function edit($id)
    {
        $ticket = RepairTicket::with(['customer'])->findOrFail($id);
        $models = PhoneModel::where('is_active', true)->get();
        $services = RepairService::where('is_active', true)->get();
        $technicians = User::whereIn('role', ['admin', 'technician'])->get();

        return view('admin.tickets.edit', compact('ticket', 'models', 'services', 'technicians'));
    }

    /**
     * อัปเดตข้อมูลทั่วไปของใบแจ้งซ่อม
     */
    public function update(Request $request, $id)
    {
        $ticket = RepairTicket::findOrFail($id);

        $request->validate([
            'phone_model_id' => 'required|exists:phone_models,id',
            'symptom_description' => 'required|string',
            'estimated_cost' => 'required|numeric|min:0',
            'final_cost' => 'nullable|numeric|min:0',
        ]);

        $ticket->update([
            'phone_model_id' => $request->phone_model_id,
            'repair_service_id' => $request->repair_service_id,
            'device_color' => $request->device_color,
            'imei_serial' => $request->imei_serial,
            'device_passcode' => $request->device_passcode,
            'symptom_description' => $request->symptom_description,
            'device_condition' => $request->device_condition,
            'priority' => $request->priority,
            'estimated_cost' => $request->estimated_cost,
            'final_cost' => $request->final_cost,
            'technician_notes' => $request->technician_notes,
            'assigned_to' => $request->assigned_to,
            'warranty_until' => $request->warranty_until,
        ]);

        // อัปเดตข้อมูลลูกค้าด้วย
        if ($ticket->customer) {
            $ticket->customer->update([
                'name' => $request->customer_name ?? $ticket->customer->name,
                'phone' => $request->customer_phone ?? $ticket->customer->phone,
                'line_id' => $request->customer_line ?? $ticket->customer->line_id,
            ]);
        }

        return redirect()->route('admin.tickets.show', $ticket->id)
            ->with('success', 'อัปเดตข้อมูลงานซ่อมเรียบร้อยแล้ว');
    }

    /**
     * อัปเดตสถานะงานซ่อม พร้อมเพิ่มบันทึกไทม์ไลน์
     */
    public function updateStatus(Request $request, $id)
    {
        $ticket = RepairTicket::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,inspecting,waiting_parts,repairing,completed,delivered,cancelled',
            'log_title' => 'required|string|max:150',
            'log_note' => 'nullable|string|max:1000',
            'final_cost' => 'nullable|numeric|min:0',
            'warranty_days' => 'nullable|integer|min:0',
        ]);

        $oldStatus = $ticket->status;
        $newStatus = $request->status;

        $updateData = [
            'status' => $newStatus,
        ];

        if ($request->filled('final_cost')) {
            $updateData['final_cost'] = $request->final_cost;
        }

        // หากสถานะเป็น completed ให้บันทึก completed_at และกำหนดวันหมดประกัน
        if ($newStatus === 'completed' && !$ticket->completed_at) {
            $updateData['completed_at'] = Carbon::now();
            $warrantyDays = $request->input('warranty_days', 90);
            $updateData['warranty_until'] = Carbon::now()->addDays($warrantyDays);
            if (!isset($updateData['final_cost']) && !$ticket->final_cost && $ticket->estimated_cost) {
                $updateData['final_cost'] = $ticket->estimated_cost;
            }
        }

        // หากสถานะเป็น delivered ให้บันทึกเวลาส่งมอบ
        if ($newStatus === 'delivered' && !$ticket->delivered_at) {
            $updateData['delivered_at'] = Carbon::now();
        }

        $ticket->update($updateData);

        // บันทึกลงตารางไทม์ไลน์
        RepairStatusLog::create([
            'repair_ticket_id' => $ticket->id,
            'status' => $newStatus,
            'title' => $request->log_title,
            'note' => $request->log_note,
            'performed_by' => Auth::user()->name,
        ]);

        return redirect()->route('admin.tickets.show', $ticket->id)
            ->with('success', "อัปเดตสถานะเป็น \"{$ticket->status_thai}\" เรียบร้อยแล้ว");
    }

    /**
     * ลบใบแจ้งซ่อม
     */
    public function destroy($id)
    {
        $ticket = RepairTicket::findOrFail($id);
        $number = $ticket->ticket_number;
        $ticket->delete();

        return redirect()->route('admin.tickets.index')
            ->with('success', "ลบใบแจ้งซ่อมรหัส {$number} เรียบร้อยแล้ว");
    }

    /**
     * พิมพ์ใบรับเครื่องซ่อม / ใบเสร็จรับเงิน (Print Slip)
     */
    public function printSlip($id)
    {
        $ticket = RepairTicket::with(['customer', 'phoneModel', 'repairService', 'technician'])
            ->findOrFail($id);

        return view('admin.tickets.print', compact('ticket'));
    }
}
