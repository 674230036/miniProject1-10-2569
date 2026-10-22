@extends('layouts.app')

@section('title', 'ข้อมูลส่วนตัวของฉัน - iRepair NPRU')

@section('content')
<div class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h3 class="fw-bold text-dark mb-1 brand-font">ข้อมูลส่วนตัวและบัญชีสมาชิก</h3>
                        <p class="text-muted small mb-0">แก้ไขข้อมูลติดต่อและเปลี่ยนรหัสผ่านสำหรับเข้าสู่ระบบ</p>
                    </div>
                    <a href="{{ route('customer.repairs') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="bi bi-arrow-left me-1"></i> กลับไปหน้ารายการซ่อม
                    </a>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-4 p-3 mb-4 shadow-sm">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> กรุณาตรวจสอบข้อมูล:</div>
                        <ul class="mb-0 ps-3 small">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card card-apple p-4 p-md-5 border-0 shadow-sm">
                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Section: ข้อมูลติดต่อ -->
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-4 d-flex align-items-center gap-2">
                            <i class="bi bi-person-circle text-primary"></i> ข้อมูลติดต่อพื้นฐาน
                        </h5>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">อีเมลเข้าสู่ระบบ (ไม่สามารถเปลี่ยนได้)</label>
                                <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled readonly>
                                <div class="form-text text-xs text-muted">อีเมลใช้สำหรับระบุตัวตนในระบบ</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">เบอร์โทรศัพท์ติดต่อ <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? ($customer->phone ?? '')) }}" required>
                                <div class="form-text text-xs text-muted">ใช้สำหรับเชื่อมโยงและค้นหาประวัติงานซ่อม</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">LINE ID</label>
                                <input type="text" name="line_id" class="form-control" value="{{ old('line_id', $customer->line_id ?? '') }}" placeholder="เช่น id_line">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark small">ที่อยู่สำหรับจัดส่งเครื่องซ่อมกลับ</label>
                                <textarea name="address" rows="3" class="form-control" placeholder="บ้านเลขที่ ถนน ตำบล อำเภอ จังหวัด">{{ old('address', $customer->address ?? '') }}</textarea>
                            </div>
                        </div>

                        <!-- Section: เปลี่ยนรหัสผ่าน -->
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3 mt-4 d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock text-primary"></i> เปลี่ยนรหัสผ่านใหม่ <span class="text-muted fw-normal small">(เว้นว่างไว้หากไม่ต้องการเปลี่ยน)</span>
                        </h5>

                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark small">รหัสผ่านปัจจุบัน</label>
                                <input type="password" name="current_password" class="form-control" placeholder="กรอกรหัสผ่านเดิมเฉพาะกรณีต้องการเปลี่ยนรหัสผ่าน">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">รหัสผ่านใหม่</label>
                                <input type="password" name="new_password" class="form-control" placeholder="ขั้นต่ำ 6 ตัวอักษร">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">ยืนยันรหัสผ่านใหม่</label>
                                <input type="password" name="new_password_confirmation" class="form-control" placeholder="กรอกรหัสผ่านใหม่อีกครั้ง">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('customer.repairs') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                ยกเลิก
                            </a>
                            <button type="submit" class="btn btn-apple px-4">
                                <i class="bi bi-check-lg me-1"></i> บันทึกการเปลี่ยนแปลง
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
