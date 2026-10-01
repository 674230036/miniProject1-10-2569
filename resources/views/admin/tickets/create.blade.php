@extends('layouts.admin')

@section('title', 'เปิดใบรับซ่อมใหม่ (หน้าร้าน) - iRepair NPRU')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 fw-bold mb-1 text-dark">เปิดใบรับซ่อม iPhone (งานหน้าร้าน)</h2>
        <p class="text-muted small mb-0">บันทึกรับเครื่องจากลูกค้า ตรวจสอบสภาพภายนอก และเปิด Ticket</p>
    </div>
    <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> กลับหน้ารายการ
    </a>
</div>

<form action="{{ route('admin.tickets.store') }}" method="POST">
    @csrf

    <div class="row g-4">
        <!-- Left: Customer & Device -->
        <div class="col-lg-8">
            <!-- Customer Card -->
            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-person-fill text-primary"></i> 1. ข้อมูลลูกค้า
                </h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">ชื่อ - นามสกุลลูกค้า <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" 
                               placeholder="เช่น คุณกานดา รัตนวิจิตร" value="{{ old('customer_name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                        <input type="tel" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" 
                               placeholder="เช่น 081-234-5678" value="{{ old('customer_phone') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">LINE ID</label>
                        <input type="text" name="customer_line" class="form-control" 
                               placeholder="เช่น kanda_line" value="{{ old('customer_line') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">อีเมล (ถ้ามี)</label>
                        <input type="email" name="customer_email" class="form-control" 
                               placeholder="เช่น kanda@example.com" value="{{ old('customer_email') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold small">ที่อยู่</label>
                        <input type="text" name="customer_address" class="form-control" 
                               placeholder="อำเภอ จังหวัด (สำหรับจัดส่งเครื่องคืน)" value="{{ old('customer_address') }}">
                    </div>
                </div>
            </div>

            <!-- Device Card -->
            <div class="card card-custom p-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-phone text-primary"></i> 2. ข้อมูลตัวเครื่องและอาการเสีย
                </h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">รุ่น iPhone <span class="text-danger">*</span></label>
                        <select name="phone_model_id" id="phoneModelSelect" class="form-select @error('phone_model_id') is-invalid @enderror" required>
                            <option value="" disabled selected>-- เลือกรุ่น iPhone --</option>
                            @foreach($models as $m)
                                <option value="{{ $m->id }}" 
                                        data-screen="{{ $m->base_screen_price }}"
                                        data-battery="{{ $m->base_battery_price }}"
                                        {{ old('phone_model_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->name }} ({{ $m->series }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">บริการหลักที่เลือก</label>
                        <select name="repair_service_id" id="repairServiceSelect" class="form-select">
                            <option value="">-- ตรวจเช็คตามอาการ --</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}" data-price="{{ $s->base_price }}" {{ old('repair_service_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }} (฿{{ number_format($s->base_price) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">สีตัวเครื่อง</label>
                        <input type="text" name="device_color" class="form-control" 
                               placeholder="เช่น Sierra Blue, ดำ, ขาว" value="{{ old('device_color') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">หมายเลข IMEI / Serial</label>
                        <input type="text" name="imei_serial" class="form-control" 
                               placeholder="15 หลัก (ถ้ามี)" value="{{ old('imei_serial') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">รหัสผ่านหน้าจอ (Passcode)</label>
                        <input type="text" name="device_passcode" class="form-control" 
                               placeholder="สำหรับช่างเทสเครื่อง" value="{{ old('device_passcode') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold small">อาการเสียที่ลูกค้าแจ้ง <span class="text-danger">*</span></label>
                        <textarea name="symptom_description" rows="2" class="form-control @error('symptom_description') is-invalid @enderror" 
                                  placeholder="ระบุอาการเสียโดยละเอียด เช่น จอในแตกมีเส้น, แบตบวม, เปิดไม่ติด..." required>{{ old('symptom_description') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold small">สภาพตัวเครื่องภายนอก (ก่อนแกะซ่อม)</label>
                        <input type="text" name="device_condition" class="form-control" 
                               placeholder="เช่น ขอบมีรอยเคสกัด, ฟิล์มกระจกมีรอยร้าว, กล้องไม่มีรอย" value="{{ old('device_condition') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Repair Order Settings -->
        <div class="col-lg-4">
            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-gear-fill text-primary"></i> 3. ข้อมูลการเปิดงาน
                </h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">ช่องทางการรับเครื่อง</label>
                    <select name="service_type" class="form-select">
                        <option value="walk_in" selected>ลูกค้านำเครื่องมาเองหน้าร้าน</option>
                        <option value="online_booking">นัดหมายออนไลน์</option>
                        <option value="delivery">รับทางพัสดุไปรษณีย์</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">ความเร่งด่วน</label>
                    <select name="priority" class="form-select">
                        <option value="normal" selected>ปกติ (ตามคิว)</option>
                        <option value="urgent">ด่วนพิเศษ (Urgent)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">ราคาประเมินเบื้องต้น (บาท) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">฿</span>
                        <input type="number" name="estimated_cost" id="estimatedCostInput" class="form-control @error('estimated_cost') is-invalid @enderror" 
                               value="{{ old('estimated_cost', 1500) }}" step="50" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">มอบหมายช่างผู้รับผิดชอบ</label>
                    <select name="assigned_to" class="form-select">
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ Auth::id() == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }} ({{ $tech->role === 'admin' ? '036 Admin' : '008 ช่าง' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small">บันทึกเพิ่มเติมของช่าง</label>
                    <textarea name="technician_notes" rows="2" class="form-control" 
                              placeholder="หมายเหตุภายในร้าน">{{ old('technician_notes') }}</textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> บันทึกและเปิดใบรับซ่อม
                    </button>
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-light border py-2">
                        ยกเลิก
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const serviceSelect = document.getElementById('repairServiceSelect');
        const costInput = document.getElementById('estimatedCostInput');

        serviceSelect.addEventListener('change', function () {
            const opt = serviceSelect.options[serviceSelect.selectedIndex];
            const price = opt.getAttribute('data-price');
            if (price) {
                costInput.value = price;
            }
        });
    });
</script>
@endsection
