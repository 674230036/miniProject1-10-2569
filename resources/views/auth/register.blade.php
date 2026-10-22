@extends('layouts.app')

@section('title', 'สมัครสมาชิกสำหรับลูกค้า (Customer Registration) - iRepair NPRU')

@section('content')
<div class="py-5" style="background: radial-gradient(circle at 50% 25%, rgba(0,113,227,0.06) 0%, rgba(248,250,252,1) 85%); min-height: 85vh; display: flex; align-items: center;">
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card card-apple p-4 p-md-5 border-0 shadow-lg">
                    <!-- Brand Icon & Heading -->
                    <div class="text-center mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-4 p-3 fs-3 mb-3 shadow-sm">
                            <i class="bi bi-person-plus-fill"></i>
                        </span>
                        <h2 class="fw-bold text-dark mb-1 brand-font">สมัครสมาชิกสำหรับลูกค้า</h2>
                        <p class="text-muted small">
                            ลงทะเบียนเพื่อติดตามสถานะงานซ่อมแบบเรียลไทม์ ตรวจสอบประวัติ และจองคิวซ่อมสะดวกรวดเร็ว
                        </p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger rounded-4 py-2 px-3 small mb-4">
                            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> กรุณาตรวจสอบข้อมูล:</div>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST" id="registerForm">
                        @csrf

                        <!-- ข้อมูลส่วนตัว -->
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark small">
                                    ชื่อ - นามสกุล <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" 
                                           placeholder="เช่น คุณกานดา รัตนวิจิตร" value="{{ old('name') }}" required autofocus>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">
                                    เบอร์โทรศัพท์มือถือ <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="tel" name="phone" class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror" 
                                           placeholder="เช่น 081-234-5678" value="{{ old('phone') }}" required>
                                </div>
                                <div class="form-text text-xs text-muted" style="font-size: 0.78rem;">
                                    <i class="bi bi-info-circle text-primary"></i> ใช้เชื่อมโยงใบแจ้งซ่อมทั้งหมดโดยอัตโนมัติ
                                </div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">
                                    LINE ID <span class="text-muted fw-normal">(ถ้ามี)</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-chat-dots"></i>
                                    </span>
                                    <input type="text" name="line_id" class="form-control border-start-0 ps-0 @error('line_id') is-invalid @enderror" 
                                           placeholder="เช่น kanda_line" value="{{ old('line_id') }}">
                                </div>
                                @error('line_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark small">
                                    อีเมลสำหรับเข้าสู่ระบบ <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                           placeholder="เช่น customer@example.com" value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">
                                    รหัสผ่าน <span class="text-danger">*</span> <span class="text-muted fw-normal">(ขั้นต่ำ 6 ตัวอักษร)</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="regPassword" class="form-control border-start-0 border-end-0 ps-0 @error('password') is-invalid @enderror" 
                                           placeholder="••••••••" required>
                                    <button class="btn btn-outline-light border text-muted" type="button" onclick="togglePasswordVisibility('regPassword', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">
                                    ยืนยันรหัสผ่าน <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-shield-check"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" id="regConfirmPassword" class="form-control border-start-0 border-end-0 ps-0" 
                                           placeholder="••••••••" required>
                                    <button class="btn btn-outline-light border text-muted" type="button" onclick="togglePasswordVisibility('regConfirmPassword', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark small">
                                    ที่อยู่สำหรับจัดส่งเครื่องซ่อม <span class="text-muted fw-normal">(ตัวเลือก)</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted align-items-start pt-2">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <textarea name="address" rows="2" class="form-control border-start-0 ps-0" 
                                              placeholder="บ้านเลขที่ ถนน ตำบล อำเภอ จังหวัด รหัสไปรษณีย์">{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Agreement -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required checked>
                            <label class="form-check-label text-muted small" for="agreeTerms">
                                ข้าพเจ้ายินยอมให้จัดเก็บข้อมูลเพื่อใช้ในการติดต่อและให้บริการงานซ่อม iPhone ตามมาตรฐาน
                            </label>
                        </div>

                        <button type="submit" class="btn btn-apple w-100 py-2 fs-6 mb-3">
                            <i class="bi bi-person-check-fill me-1"></i> สมัครสมาชิกและเข้าสู่ระบบทันที
                        </button>
                    </form>

                    <!-- Benefits Card -->
                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <div class="fw-bold text-dark small mb-2">
                            <i class="bi bi-stars text-warning me-1"></i> สิทธิประโยชน์สำหรับลูกค้าสมาชิก:
                        </div>
                        <ul class="list-unstyled mb-0 small text-muted d-grid gap-1">
                            <li><i class="bi bi-check-circle-fill text-success me-1"></i> ติดตามขั้นตอนการซ่อมแบบเรียลไทม์ พร้อมโน้ตจากช่าง</li>
                            <li><i class="bi bi-check-circle-fill text-success me-1"></i> ดูประวัติการซ่อมทั้งหมดและพิมพ์ใบรับเครื่องซ่อมย้อนหลัง</li>
                            <li><i class="bi bi-check-circle-fill text-success me-1"></i> แจ้งซ่อมออนไลน์สะดวกรวดเร็ว ไม่ต้องกรอกข้อมูลซ้ำ</li>
                        </ul>
                    </div>

                    <!-- Existing account switch -->
                    <div class="text-center pt-2 border-top">
                        <p class="small text-muted mb-2">มีบัญชีผู้ใช้งานอยู่แล้ว?</p>
                        <a href="{{ route('login') }}" class="btn btn-apple-outline btn-sm px-4">
                            <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบที่นี่
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
    function togglePasswordVisibility(fieldId, button) {
        const input = document.getElementById(fieldId);
        const icon = button.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
@endsection
