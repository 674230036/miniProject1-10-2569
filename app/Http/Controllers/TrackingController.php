<?php

namespace App\Http\Controllers;

use App\Models\RepairTicket;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * หน้าค้นหาการติดตามสถานะ
     */
    public function index()
    {
        $sampleTickets = RepairTicket::with(['phoneModel', 'customer'])->latest()->take(4)->get();
        return view('frontend.tracking.index', compact('sampleTickets'));
    }

    /**
     * ประมวลผลการค้นหาตามเลขที่ใบรับซ่อม หรือ เบอร์โทรศัพท์
     */
    public function track(Request $request)
    {
        $query = trim($request->input('keyword', ''));

        if (empty($query)) {
            return redirect()->route('tracking.index')->with('warning', 'กรุณากรอกเลขที่ใบรับซ่อม หรือเบอร์โทรศัพท์ของท่าน');
        }

        // ค้นหาจากเลข Ticket Number ก่อน
        $ticket = RepairTicket::where('ticket_number', strtoupper($query))->first();

        if ($ticket) {
            return redirect()->route('tracking.show', $ticket->ticket_number);
        }

        // หากไม่เจอ ให้ค้นหาจากเบอร์โทรศัพท์ลูกค้า
        $cleanPhone = preg_replace('/[^0-9]/', '', $query);
        $tickets = RepairTicket::with(['phoneModel', 'repairService'])
            ->whereHas('customer', function ($q) use ($query, $cleanPhone) {
                $q->where('phone', 'LIKE', "%{$query}%")
                  ->orWhereRaw("REPLACE(REPLACE(phone, '-', ''), ' ', '') LIKE ?", ["%{$cleanPhone}%"]);
            })
            ->latest()
            ->get();

        if ($tickets->count() === 1) {
            return redirect()->route('tracking.show', $tickets->first()->ticket_number);
        } elseif ($tickets->count() > 1) {
            return view('frontend.tracking.results', [
                'tickets' => $tickets,
                'query' => $query,
            ]);
        }

        return redirect()->route('tracking.index')
            ->withInput()
            ->with('error', "ไม่พบข้อมูลงานซ่อมสำหรับ: \"{$query}\" กรุณาตรวจสอบเลขที่ใบรับซ่อมหรือเบอร์โทรศัพท์อีกครั้ง");
    }

    /**
     * แสดงหน้าข้อมูลสถานะการซ่อม พร้อม Timeline การทำงานของช่าง
     */
    public function show($ticket_number)
    {
        $ticket = RepairTicket::with([
            'customer',
            'phoneModel',
            'repairService',
            'technician',
            'statusLogs' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->where('ticket_number', strtoupper($ticket_number))->firstOrFail();

        return view('frontend.tracking.show', compact('ticket'));
    }

    /**
     * พิมพ์ใบรับเครื่องซ่อมสำหรับลูกค้าทั่วไป (ไม่ต้องล็อกอิน)
     */
    public function printSlip($ticket_number)
    {
        $ticket = RepairTicket::with(['customer', 'phoneModel', 'repairService', 'technician'])
            ->where('ticket_number', strtoupper($ticket_number))
            ->firstOrFail();

        return view('admin.tickets.print', compact('ticket'));
    }
}
