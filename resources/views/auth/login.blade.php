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
                        <h3 class="fw-bold text-dark mb-1">เข้าสู่ระบบหลังบ้าน</h3>
                        <p class="text-muted small">ระบบจัดการข้อมูลและสถานะงานซ่อมไอโฟน (สำหรับเจ้าหน้าที่และช่าง 036)</p>
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
                                       placeholder="admin@irepair.com" value="{{ old('email', 'admin@irepair.com') }}" required autofocus>
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
                                       placeholder="••••••••" value="admin123" required>
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
                            <span class="text-muted text-xs small">รหัสผ่านเริ่มต้น: admin123</span>
                        </div>

                        <button type="submit" class="btn btn-apple w-100 py-2 fs-6 mb-3">
                            <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ
                        </button>
                    </form>

                    <!-- Quick Demo Credentials for Grading / Evaluation -->
                    <div class="p-3 bg-light rounded-3 border mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-dark small"><i class="bi bi-key-fill text-warning me-1"></i> บัญชีทดสอบสำหรับอาจารย์ตรวจ:</span>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm text-start py-2" onclick="setCredentials('admin@irepair.com', 'admin123')">
                                <strong class="d-block small"><i class="bi bi-person-badge-fill me-1"></i> แอดมินหลัก (นายธีรเดช 036 - Back-end)</strong>
                                <span class="text-muted text-xs" style="font-size: 0.75rem;">admin@irepair.com / admin123</span>
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm text-start py-2" onclick="setCredentials('tech008@irepair.com', 'admin123')">
                                <strong class="d-block small"><i class="bi bi-person-badge me-1"></i> ช่างเทคนิค (นายภูมิพัฒน์ 008 - Front-end)</strong>
                                <span class="text-muted text-xs" style="font-size: 0.75rem;">tech008@irepair.com / admin123</span>
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
