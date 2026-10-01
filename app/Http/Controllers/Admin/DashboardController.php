<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PhoneModel;
use App\Models\RepairService;
use App\Models\RepairTicket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * หน้าสรุปภาพรวมระบบหลังบ้าน (จัดทำโดย นายธีรเดช วงศ์สว่าง รหัส 036)
     */
    public function index()
    {
        $stats = [
            'total_tickets' => RepairTicket::count(),
            'pending' => RepairTicket::where('status', 'pending')->count(),
            'inspecting' => RepairTicket::where('status', 'inspecting')->count(),
            'in_progress' => RepairTicket::whereIn('status', ['waiting_parts', 'repairing'])->count(),
            'completed' => RepairTicket::where('status', 'completed')->count(),
            'delivered' => RepairTicket::where('status', 'delivered')->count(),
            'total_customers' => Customer::count(),
            'total_models' => PhoneModel::count(),
            'total_services' => RepairService::count(),
            'total_revenue' => RepairTicket::whereIn('status', ['completed', 'delivered'])->sum('final_cost') 
                ?: RepairTicket::whereIn('status', ['completed', 'delivered'])->sum('estimated_cost'),
        ];

        // รายการแจ้งซ่อมล่าสุด 7 รายการ
        $recentTickets = RepairTicket::with(['customer', 'phoneModel', 'repairService', 'technician'])
            ->latest()
            ->take(7)
            ->get();

        // สรุปยอดแยกตามกลุ่มบริการยอดนิยม
        $serviceStats = RepairService::withCount('repairTickets')
            ->orderBy('repair_tickets_count', 'desc')
            ->take(5)
            ->get();

        // ช่างซ่อมในระบบ
        $technicians = User::withCount(['assignedTickets' => function ($q) {
            $q->whereIn('status', ['repairing', 'inspecting', 'waiting_parts']);
        }])->get();

        return view('admin.dashboard', compact('stats', 'recentTickets', 'serviceStats', 'technicians'));
    }
}
