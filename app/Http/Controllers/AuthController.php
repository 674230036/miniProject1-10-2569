<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * แสดงหน้าเข้าสู่ระบบ (Login)
     */
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->isCustomer()) {
                return redirect()->route('customer.repairs');
            }
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * ประมวลผลการเข้าสู่ระบบ
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'กรุณากรอกอีเมลผู้ใช้งาน',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->isCustomer()) {
                return redirect()->intended(route('customer.repairs'))
                    ->with('success', "ยินดีต้อนรับคุณ {$user->name} เข้าสู่ระบบสมาชิก iRepair Studio!");
            }

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', "ยินดีต้อนรับเข้าสู่ระบบ, {$user->name}!");
        }

        return back()->withInput($request->only('email', 'remember'))
            ->with('error', 'อีเมลหรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง');
    }

    /**
     * แสดงหน้าสมัครสมาชิกสำหรับลูกค้า (Customer Register)
     */
    public function showRegister()
    {
        if (Auth::check()) {
            if (Auth::user()->isCustomer()) {
                return redirect()->route('customer.repairs');
            }
            return redirect()->route('admin.dashboard');
        }

        return view('auth.register');
    }

    /**
     * ประมวลผลการสมัครสมาชิกสำหรับลูกค้า
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|min:9|max:20',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'line_id' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ], [
            'name.required' => 'กรุณากรอกชื่อ-นามสกุลของท่าน',
            'phone.required' => 'กรุณากรอกเบอร์โทรศัพท์มือถือ',
            'phone.min' => 'เบอร์โทรศัพท์ต้องมีความยาวอย่างน้อย 9 หลัก',
            'email.required' => 'กรุณากรอกอีเมลสำหรับใช้งานระบบ',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique' => 'อีเมลนี้ถูกใช้งานในระบบแล้ว กรุณาใช้อีเมลอื่นหรือเข้าสู่ระบบ',
            'password.required' => 'กรุณากำหนดรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร',
            'password.confirmed' => 'การยืนยันรหัสผ่านไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง',
        ]);

        return DB::transaction(function () use ($request) {
            $cleanPhone = trim($request->phone);

            // 1. สร้างบัญชีผู้ใช้งาน User
            $user = User::create([
                'name' => trim($request->name),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'role' => 'customer',
                'phone' => $cleanPhone,
            ]);

            // 2. เชื่อมโยงหรือสร้างข้อมูลลูกค้าในตาราง customers ด้วยเบอร์โทรศัพท์
            $customer = Customer::where('phone', $cleanPhone)->first();
            if (!$customer) {
                Customer::create([
                    'name' => trim($request->name),
                    'phone' => $cleanPhone,
                    'email' => strtolower(trim($request->email)),
                    'line_id' => $request->line_id ? trim($request->line_id) : null,
                    'address' => $request->address ? trim($request->address) : null,
                    'notes' => 'สมัครสมาชิกออนไลน์ผ่านเว็บไซต์',
                ]);
            } else {
                // อัปเดตข้อมูลลูกค้าเดิมหากมีประวัติแจ้งซ่อมอยู่แล้ว
                $customer->update([
                    'email' => strtolower(trim($request->email)),
                    'line_id' => $request->line_id ? trim($request->line_id) : $customer->line_id,
                    'address' => $request->address ? trim($request->address) : $customer->address,
                ]);
            }

            // 3. เข้าสู่ระบบอัตโนมัติ
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('customer.repairs')
                ->with('success', "สมัครสมาชิกสำเร็จ! ยินดีต้อนรับคุณ {$user->name} สู่ครอบครัว iRepair Studio");
        });
    }

    /**
     * ออกจากระบบ
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'ออกจากระบบเรียบร้อยแล้ว');
    }
}
