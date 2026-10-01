@extends('layouts.admin')

@section('title', 'แก้ไขใบแจ้งซ่อม: ' . $ticket->ticket_number . ' - iRepair NPRU')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 fw-bold mb-1 text-dark">แก้ไขข้อมูลใบแจ้งซ่อม: <span class="text-primary">{{ $ticket->ticket_number }}</span></h2>
        <p class="text-muted small mb-0">ปรับปรุงข้อมูลเครื่อง ข้อมูลลูกค้า และราคา</p>
    </div>
    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> ย้อนกลับ
    </a>
</div>

<form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Customer -->
            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">1. ข้อมูลลูกค้า</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">ชื่อลูกค้า</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $ticket->customer->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">เบอร์โทรศัพท์</label>
                        <input type="tel" name="customer_phone" class="form-control" value="{{ old('customer_phone', $ticket->customer->phone) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">LINE ID</label>
                        <input type="text" name="customer_line" class="form-control" value="{{ old('customer_line', $ticket->customer->line_id) }}">
                    </div>
                </div>
            </div>

            <!-- Device -->
            <div class="card card-custom p-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">2. ข้อมูลเครื่อง iPhone</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">รุ่น iPhone</label>
                        <select name="phone_model_id" class="form-select" required>
                            @foreach($models as $m)
                                <option value="{{ $m->id }}" {{ $ticket->phone_model_id == $m->id ? 'selected' : '' }}>
                                    {{ $m->name }} ({{ $m->series }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">บริการหลัก</label>
                        <select name="repair_service_id" class="form-select">
                            <option value="">-- ไม่ระบุ / ตรวจเช็คตามอาการ --</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}" {{ $ticket->repair_service_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">สีตัวเครื่อง</label>
                        <input type="text" name="device_color" class="form-control" value="{{ old('device_color', $ticket->device_color) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">IMEI / Serial</label>
                        <input type="text" name="imei_serial" class="form-control" value="{{ old('imei_serial', $ticket->imei_serial) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Passcode ปลดล็อค</label>
                        <input type="text" name="device_passcode" class="form-control" value="{{ old('device_passcode', $ticket->device_passcode) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small">อาการเสีย</label>
                        <textarea name="symptom_description" rows="3" class="form-control" required>{{ old('symptom_description', $ticket->symptom_description) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small">สภาพภายนอกตัวเครื่อง</label>
                        <input type="text" name="device_condition" class="form-control" value="{{ old('device_condition', $ticket->device_condition) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-custom p-4 mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">3. การตั้งค่าและราคา</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">ระดับความสำคัญ</label>
                    <select name="priority" class="form-select">
                        <option value="normal" {{ $ticket->priority === 'normal' ? 'selected' : '' }}>ปกติ</option>
                        <option value="urgent" {{ $ticket->priority === 'urgent' ? 'selected' : '' }}>ด่วนพิเศษ (Urgent)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">ช่างผู้รับผิดชอบ</label>
                    <select name="assigned_to" class="form-select">
                        <option value="">-- ยังไม่มอบหมาย --</option>
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ $ticket->assigned_to == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }} ({{ $tech->student_id ? 'รหัส ' . $tech->student_id : 'Staff' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">ราคาประเมินเบื้องต้น (บาท)</label>
                    <input type="number" name="estimated_cost" class="form-control" value="{{ old('estimated_cost', $ticket->estimated_cost) }}" step="50" min="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">ราคาค่าซ่อมจริง (บาท)</label>
                    <input type="number" name="final_cost" class="form-control" value="{{ old('final_cost', $ticket->final_cost) }}" step="50" min="0">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">รับประกันถึงวันที่</label>
                    <input type="date" name="warranty_until" class="form-control" value="{{ old('warranty_until', $ticket->warranty_until ? $ticket->warranty_until->format('Y-m-d') : '') }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small">บันทึกช่าง</label>
                    <textarea name="technician_notes" rows="2" class="form-control">{{ old('technician_notes', $ticket->technician_notes) }}</textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2 fw-semibold">
                        <i class="bi bi-save me-1"></i> บันทึกการแก้ไข
                    </button>
                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-light border py-2">
                        ยกเลิก
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
