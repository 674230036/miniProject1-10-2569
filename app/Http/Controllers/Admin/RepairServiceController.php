<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairService;
use Illuminate\Http\Request;

class RepairServiceController extends Controller
{
    public function index()
    {
        $services = RepairService::withCount('repairTickets')
            ->orderBy('category')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'base_price' => 'required|numeric|min:0',
            'estimated_duration' => 'required|string|max:50',
            'warranty_period' => 'required|string|max:50',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        RepairService::create([
            'name' => $request->name,
            'category' => $request->category,
            'base_price' => $request->base_price,
            'estimated_duration' => $request->estimated_duration,
            'warranty_period' => $request->warranty_period,
            'icon' => $request->icon ?: 'bi-tools',
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.services.index')->with('success', "เพิ่มบริการ {$request->name} เรียบร้อยแล้ว");
    }

    public function update(Request $request, $id)
    {
        $service = RepairService::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'base_price' => 'required|numeric|min:0',
            'estimated_duration' => 'required|string|max:50',
            'warranty_period' => 'required|string|max:50',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $service->update([
            'name' => $request->name,
            'category' => $request->category,
            'base_price' => $request->base_price,
            'estimated_duration' => $request->estimated_duration,
            'warranty_period' => $request->warranty_period,
            'icon' => $request->icon ?: 'bi-tools',
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.services.index')->with('success', "อัปเดตบริการ {$service->name} เรียบร้อยแล้ว");
    }

    public function destroy($id)
    {
        $service = RepairService::findOrFail($id);
        $name = $service->name;
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', "ลบบริการ {$name} เรียบร้อยแล้ว");
    }
}
