@extends('layouts.app')

@section('title', 'แจ้งซ่อมไอโฟนออนไลน์ - iRepair NPRU')

@section('content')
<div class="py-5 bg-light">
    <div class="container py-lg-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Page Header -->
                <div class="text-center mb-4">
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 mb-2">
                        <i class="bi bi-pencil-square me-1"></i> Online Booking Service
                    </span>
                    <h1 class="display-6 fw-bold">แบบฟอร์มแจ้งซ่อม iPhone ออนไลน์</h1>
                    <p class="text-muted">
                        กรอกข้อมูลอาการเสียและข้อมูลตัวเครื่องเพื่อจองคิวตรวจเช็คฟรี ไม่มีค่าเปิดเครื่อง ช่างจะเตรียมอะไหล่ไว้ล่วงหน้า
                    </p>
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

                <div class="card card-apple p-4 p-md-5">
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf

                        <!-- Section 1: ข้อมูลอุปกรณ์ -->
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-4 d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-circle">1</span> ข้อมูลตัวเครื่อง iPhone
                        </h5>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">รุ่น iPhone ที่ต้องการซ่อม <span class="text-danger">*</span></label>
                                <select name="phone_model_id" class="form-select @error('phone_model_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- เลือกรุ่น iPhone ของท่าน --</option>
                                    @foreach($models as $model)
                                        <option value="{{ $model->id }}" {{ old('phone_model_id') == $model->id ? 'selected' : '' }}>
                                            {{ $model->name }} ({{ $model->series }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">อาการเสียหลัก / บริการที่ต้องการ</label>
                                <select name="repair_service_id" class="form-select">
                                    <option value="">-- ไม่แน่ใจ / ตรวจเช็คตามอาการ --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('repair_service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }} (เริ่ม ฿{{ number_format($service->base_price) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-dark">สีตัวเครื่อง</label>
                                <input type="text" name="device_color" class="form-control" 
                                       placeholder="เช่น สเปซเกรย์, ม่วง, ไทเทเนียม" value="{{ old('device_color') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-dark">หมายเลข IMEI / Serial (ถ้ามี)</label>
                                <input type="text" name="imei_serial" class="form-control" 
                                       placeholder="ตรวจสอบใน การตั้งค่า > ทั่วไป" value="{{ old('imei_serial') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-dark">รหัสปลดล็อคหน้าจอ (ถ้าสะดวก)</label>
                                <input type="text" name="device_passcode" class="form-control" 
                                       placeholder="สำหรับให้ช่างเทสฟังก์ชันหลังซ่อม" value="{{ old('device_passcode') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">รายละเอียดอาการเสีย หรือสาเหตุที่พบ <span class="text-danger">*</span></label>
                                <textarea name="symptom_description" rows="3" class="form-control @error('symptom_description') is-invalid @enderror" 
                                          placeholder="ระบุอาการให้ละเอียด เช่น หน้าจอสัมผัสไม่ได้บางจุด, แบตหมดเร็วชาร์จไม่เข้า, ตกน้ำเปิดไม่ติด..." required>{{ old('symptom_description') }}</textarea>
                            </div>
                        </div>

                        <!-- Section 2: ข้อมูลติดต่อลูกค้า -->
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-4 d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-circle">2</span> ข้อมูลเจ้าของเครื่อง (ลูกค้า)
                        </h5>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" 
                                       placeholder="เช่น คุณสมชาย ใจดี" value="{{ old('customer_name') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">เบอร์โทรศัพท์ติดต่อ <span class="text-danger">*</span></label>
                                <input type="tel" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" 
                                       placeholder="เช่น 081-234-5678" value="{{ old('customer_phone') }}" required>
                                <div class="form-text small">จะใช้สำหรับตรวจสอบสถานะงานซ่อมในระบบ</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">LINE ID (สะดวกรับแจ้งเตือน)</label>
                                <input type="text" name="customer_line" class="form-control" 
                                       placeholder="เช่น somchai_npru" value="{{ old('customer_line') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">อีเมล</label>
                                <input type="email" name="customer_email" class="form-control" 
                                       placeholder="เช่น somchai@gmail.com" value="{{ old('customer_email') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">ช่องทางการส่งเครื่องตรวจเช็ค <span class="text-danger">*</span></label>
                                <select name="service_type" class="form-select" required>
                                    <option value="online_booking" {{ old('service_type') == 'online_booking' ? 'selected' : '' }}>นำเครื่องมาส่งหน้าร้านด้วยตนเอง (ม.ราชภัฏนครปฐม)</option>
                                    <option value="delivery" {{ old('service_type') == 'delivery' ? 'selected' : '' }}>จัดส่งพัสดุ (Flash, Kerry, EMS)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">ที่อยู่สำหรับส่งเครื่องกลับ (กรณีส่งพัสดุ)</label>
                                <input type="text" name="customer_address" class="form-control" 
                                       placeholder="บ้านเลขที่ ตำบล อำเภอ จังหวัด" value="{{ old('customer_address') }}">
                            </div>
                        </div>

                        <!-- Notice & Submit Button -->
                        <div class="p-3 bg-light rounded-3 mb-4 small text-muted">
                            <i class="bi bi-shield-check text-success me-1"></i>
                            <strong>การรับประกันความเป็นส่วนตัว:</strong> ข้อมูลรูปภาพและเอกสารสำคัญในเครื่องของท่านจะไม่ถูกเข้าถึง ช่างจะติดต่อแจ้งราคาก่อนเริ่มการซ่อมทุกครั้ง
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-apple py-3 fs-6">
                                <i class="bi bi-check2-circle me-1"></i> ยืนยันการแจ้งซ่อมและรับรหัสติดตามงาน
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-link text-secondary text-decoration-none">
                                <i class="bi bi-x-circle me-1"></i> ยกเลิกและกลับหน้าแรก
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
