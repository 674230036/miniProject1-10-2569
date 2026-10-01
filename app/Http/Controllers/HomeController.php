<?php

namespace App\Http\Controllers;

use App\Models\PhoneModel;
use App\Models\RepairService;
use App\Models\RepairTicket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * หน้าแรกของเว็บไซต์ (จัดทำโดย นายภูมิพัฒน์ เกษมสุข รหัส 008)
     */
    public function index()
    {
        $services = RepairService::where('is_active', true)->take(6)->get();
        $models = PhoneModel::where('is_active', true)->orderBy('release_year', 'desc')->take(8)->get();
        $recentRepairs = RepairTicket::with(['customer', 'phoneModel', 'repairService'])
            ->whereIn('status', ['completed', 'delivered', 'repairing'])
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_repaired' => RepairTicket::whereIn('status', ['completed', 'delivered'])->count() + 128, // รวมงานหน้าร้านสะสม
            'active_repairs' => RepairTicket::whereIn('status', ['pending', 'inspecting', 'waiting_parts', 'repairing'])->count(),
            'satisfaction_rate' => '99.4%',
            'warranty_days' => '180 วัน',
        ];

        return view('frontend.home', compact('services', 'models', 'recentRepairs', 'stats'));
    }

    /**
     * หน้ารายการบริการซ่อมและอะไหล่แท้
     */
    public function services()
    {
        $services = RepairService::where('is_active', true)->get()->groupBy('category');
        return view('frontend.services', compact('services'));
    }

    /**
     * หน้าประเมินราคาซ่อมเบื้องต้น
     */
    public function priceEstimator()
    {
        $models = PhoneModel::where('is_active', true)->orderBy('release_year', 'desc')->get();
        $services = RepairService::where('is_active', true)->get();

        return view('frontend.price-estimator', compact('models', 'services'));
    }

    /**
     * หน้าเกี่ยวกับระบบและคณะผู้จัดทำโครงงาน (008 & 036)
     */
    public function about()
    {
        return view('frontend.about');
    }
}
