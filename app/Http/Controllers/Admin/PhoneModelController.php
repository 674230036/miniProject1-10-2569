<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhoneModel;
use Illuminate\Http\Request;

class PhoneModelController extends Controller
{
    public function index()
    {
        $models = PhoneModel::withCount('repairTickets')
            ->orderBy('release_year', 'desc')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.models.index', compact('models'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'series' => 'required|string|max:100',
            'release_year' => 'nullable|integer|min:2010|max:2030',
            'screen_size' => 'nullable|string|max:100',
            'base_screen_price' => 'required|numeric|min:0',
            'base_battery_price' => 'required|numeric|min:0',
        ]);

        PhoneModel::create([
            'name' => $request->name,
            'series' => $request->series,
            'release_year' => $request->release_year,
            'screen_size' => $request->screen_size,
            'base_screen_price' => $request->base_screen_price,
            'base_battery_price' => $request->base_battery_price,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.models.index')->with('success', "เพิ่มรุ่น {$request->name} เรียบร้อยแล้ว");
    }

    public function update(Request $request, $id)
    {
        $model = PhoneModel::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'series' => 'required|string|max:100',
            'release_year' => 'nullable|integer',
            'screen_size' => 'nullable|string|max:100',
            'base_screen_price' => 'required|numeric|min:0',
            'base_battery_price' => 'required|numeric|min:0',
        ]);

        $model->update([
            'name' => $request->name,
            'series' => $request->series,
            'release_year' => $request->release_year,
            'screen_size' => $request->screen_size,
            'base_screen_price' => $request->base_screen_price,
            'base_battery_price' => $request->base_battery_price,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.models.index')->with('success', "อัปเดตข้อมูลรุ่น {$model->name} เรียบร้อยแล้ว");
    }

    public function destroy($id)
    {
        $model = PhoneModel::findOrFail($id);
        $name = $model->name;
        $model->delete();

        return redirect()->route('admin.models.index')->with('success', "ลบรุ่น {$name} เรียบร้อยแล้ว");
    }
}
