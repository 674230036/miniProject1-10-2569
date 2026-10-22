@extends('layouts.app')

@section('title', 'เข้าสู่ระบบหลังบ้าน (Admin & Staff Login) - iRepair NPRU')

@section('content')
<div class="py-5" style="background: radial-gradient(circle at 50% 30%, rgba(37,99,235,0.06) 0%, rgba(248,250,252,1) 80%); min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card card-apple p-4 p-md-5 border-0 shadow-lg">
                    <!-- Brand Icon & Heading -->
                    <div class="text-center mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center bg-dark text-white rounded-4 p-3 fs-3 mb-3 shadow-sm">
                            <i class="bi bi-apple"></i>
                        </span>
                        <h3 class="fw-bold text-dark mb-1">เข้าสู่ระบบ iRepair Studio</h3>
                        <p class="text-muted small">ระบบจัดการงานซ่อมไอโฟน (สำหรับลูกค้าสมาชิก และ เจ้าหน้าที่หลังบ้าน)</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger rounded-3 py-2 small d-flex align-items-center mb-3">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark small">อีเมลผู้ใช้งาน (Email Address)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" id="loginEmail" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                       placeholder="กรอกอีเมลของคุณ" value="{{ old('email', '674230036@webmail.npru.ac.th') }}" required autofocus>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark small">รหัสผ่าน (Password)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <input type="password" name="password" id="loginPassword" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" 
                                       placeholder="••••••••" value="674230036" required>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                                <label class="form-check-label text-muted small" for="rememberMe">
                                    จดจำการเข้าสู่ระบบ
                                </label>
                            </div>
                            <a href="{{ route('register') }}" class="text-primary text-xs small text-decoration-none">
                                ยังไม่มีบัญชี? <strong>สมัครสมาชิก</strong>
                            </a>
                        </div>

                        <button type="submit" class="btn btn-apple w-100 py-2 fs-6 mb-3">
                            <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ
                        </button>
                    </form>

                    <!-- Customer Register CTA Banner -->
                    <div class="p-3 bg-primary-subtle text-primary-emphasis rounded-3 border border-primary-subtle mb-3 text-center">
                        <div class="small fw-semibold mb-1">
                            <i class="bi bi-person-plus-fill me-1"></i> สำหรับลูกค้าที่ต้องการเปิดบัญชีใหม่
                        </div>
                        <p class="text-xs small mb-2 text-muted">ติดตามสถานะงานซ่อมแบบเรียลไทม์ และดูประวัติย้อนหลังได้ทุกเครื่อง</p>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill px-4">
                            สมัครสมาชิกสำหรับลูกค้า (ฟรี)
                        </a>
                    </div>

                    <!-- Quick Demo Credentials for Grading / Evaluation -->
                    <div class="p-3 bg-light rounded-3 border mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-dark small"><i class="bi bi-key-fill text-warning me-1"></i> บัญชีทดสอบระบบ (คลิกเพื่อกรอกอัตโนมัติ):</span>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm text-start py-2" onclick="setCredentials('674230036@webmail.npru.ac.th', '674230036')">
                                <strong class="d-block small"><i class="bi bi-shield-lock-fill me-1"></i> แอดมินหลัก (นายศุภนัฐ จันทร์เปรม 036 ห้อง 67/44)</strong>
                                <span class="text-muted text-xs" style="font-size: 0.75rem;">674230036@webmail.npru.ac.th / รหัส: 674230036</span>
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm text-start py-2" onclick="setCredentials('674230008@webmail.npru.ac.th', '674230008')">
                                <strong class="d-block small"><i class="bi bi-person-badge-fill me-1"></i> แอดมิน / Front-end (นายรัชต์พงษ์ ตันติประสพลาภ 008 ห้อง 67/44)</strong>
                                <span class="text-muted text-xs" style="font-size: 0.75rem;">674230008@webmail.npru.ac.th / รหัส: 674230008</span>
                            </button>
                            <button type="button" class="btn btn-outline-dark btn-sm text-start py-2" onclick="setCredentials('kanda.rat@gmail.com', 'password123')">
                                <strong class="d-block small"><i class="bi bi-person-check-fill me-1 text-info"></i> ลูกค้าสมาชิกทดสอบ (คุณกานดา รัตนวิจิตร)</strong>
                                <span class="text-muted text-xs" style="font-size: 0.75rem;">kanda.rat@gmail.com / รหัส: password123 (มีงานซ่อม REP-202610-001)</span>
                            </button>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none small">
                            <i class="bi bi-arrow-left me-1"></i> กลับไปหน้าแรกของเว็บไซต์
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function setCredentials(email, password) {
        document.getElementById('loginEmail').value = email;
        document.getElementById('loginPassword').value = password;
    }
</script>
@endsection
