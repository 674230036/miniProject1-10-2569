<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\RepairTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerPortalController extends Controller
{
    /**
     * หน้าแดชบอร์ดงานซ่อมของลูกค้า (Customer Repair Portal)
     */
    public function myRepairs()
    {
        $user = Auth::user();

        // ค้นหาข้อมูลลูกค้าจากเบอร์โทรศัพท์ หรือ อีเมล
        $customer = Customer::where('phone', $user->phone)
            ->orWhere('email', $user->email)
            ->first();

        $tickets = collect();
        if ($customer) {
            $tickets = RepairTicket::where('customer_id', $customer->id)
                ->with([
                    'phoneModel',
                    'repairService',
                    'technician',
                    'statusLogs' => function ($q) {
                        $q->latest();
                    }
                ])
                ->latest()
                ->get();
        }

        $stats = [
            'total' => $tickets->count(),
            'active' => $tickets->whereIn('status', ['pending', 'inspecting', 'waiting_parts', 'repairing'])->count(),
            'completed' => $tickets->where('status', 'completed')->count(),
            'delivered' => $tickets->where('status', 'delivered')->count(),
        ];

        return view('frontend.customer.my-repairs', compact('user', 'customer', 'tickets', 'stats'));
    }

    /**
     * หน้าดูและแก้ไขข้อมูลส่วนตัวของลูกค้า
     */
    public function profile()
    {
        $user = Auth::user();
        $customer = Customer::where('phone', $user->phone)
            ->orWhere('email', $user->email)
            ->first();

        return view('frontend.customer.profile', compact('user', 'customer'));
    }

    /**
     * บันทึกการแก้ไขข้อมูลส่วนตัวและรหัสผ่าน
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|min:9|max:20',
            'line_id' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'กรุณากรอกชื่อ-นามสกุล',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์ติดต่อ',
            'current_password.required_with' => 'กรุณากรอกรหัสผ่านปัจจุบันหากต้องการเปลี่ยนรหัสผ่านใหม่',
            'new_password.min' => 'รหัสผ่านใหม่ต้องมีความยาวอย่างน้อย 6 ตัวอักษร',
            'new_password.confirmed' => 'การยืนยันรหัสผ่านใหม่ไม่ตรงกัน',
        ]);

        // ตรวจสอบรหัสผ่านปัจจุบันกรณีต้องการเปลี่ยนรหัสผ่าน
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
            }
        }

        DB::transaction(function () use ($request, $user) {
            $user->name = trim($request->name);
            $user->phone = trim($request->phone);

            if ($request->filled('new_password')) {
                $user->password = Hash::make($request->new_password);
            }
            $user->save();

            // ซิงค์ข้อมูลกับตาราง Customer
            $customer = Customer::where('phone', $user->phone)
                ->orWhere('email', $user->email)
                ->first();

            if ($customer) {
                $customer->update([
                    'name' => trim($request->name),
                    'phone' => trim($request->phone),
                    'line_id' => $request->line_id ? trim($request->line_id) : $customer->line_id,
                    'address' => $request->address ? trim($request->address) : $customer->address,
                ]);
            }
        });

        return back()->with('success', 'บันทึกการแก้ไขข้อมูลส่วนตัวเรียบร้อยแล้ว');
    }
}
