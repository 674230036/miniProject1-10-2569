@extends('layouts.admin')

@section('title', 'จัดการงานซ่อม: ' . $ticket->ticket_number . ' - iRepair NPRU')

@section('content')
<!-- Header & Actions -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <div class="d-flex align-items-center gap-3">
            <h2 class="h3 fw-bold mb-0 text-dark">งานซ่อมรหัส: <span class="text-primary">{{ $ticket->ticket_number }}</span></h2>
            <span class="status-pill badge-{{ $ticket->status }} fs-6">
                {{ $ticket->status_thai }}
            </span>
            @if($ticket->priority === 'urgent')
                <span class="badge bg-danger">งานด่วนพิเศษ</span>
            @endif
        </div>
        <p class="text-muted small mb-0 mt-1">
            รับเครื่องวันที่: {{ $ticket->created_at->format('d/m/Y H:i น.') }} &bull; ช่างผู้ดูแล: <strong>{{ $ticket->technician ? $ticket->technician->name : 'ยังไม่มอบหมาย' }}</strong>
        </p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.tickets.print', $ticket->id) }}" target="_blank" class="btn btn-outline-dark rounded-pill px-3">
            <i class="bi bi-printer me-1"></i> พิมพ์ใบรับเครื่อง
        </a>
        <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> แก้ไขข้อมูล
        </a>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-light border rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> กลับ
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Details -->
    <div class="col-lg-7">
        <!-- Device & Symptom Info -->
        <div class="card card-custom p-4 mb-4">
            <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-phone text-primary"></i> ข้อมูลเครื่อง iPhone
            </h5>
            <div class="row g-3 small">
                <div class="col-sm-6">
                    <span class="text-muted d-block">รุ่นเครื่อง</span>
                    <strong class="text-dark fs-6">{{ $ticket->phoneModel->name }}</strong>
                    <div class="text-muted text-xs">{{ $ticket->phoneModel->series }}</div>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">สีเครื่อง</span>
                    <span class="text-dark fw-medium">{{ $ticket->device_color ?? '-' }}</span>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">IMEI / Serial Number</span>
                    <span class="text-monospace fw-semibold">{{ $ticket->imei_serial ?? 'ไม่ได้ระบุ' }}</span>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">รหัสผ่านหน้าจอ (Passcode)</span>
                    <span class="badge bg-light text-danger border fs-6 font-monospace">{{ $ticket->device_passcode ?? 'ไม่มีรหัส' }}</span>
                </div>
                <div class="col-12">
                    <span class="text-muted d-block">อาการเสียที่ลูกค้าแจ้ง</span>
                    <div class="p-3 bg-light rounded text-dark mt-1">
                        {{ $ticket->symptom_description }}
                    </div>
                </div>
                @if($ticket->device_condition)
                <div class="col-12">
                    <span class="text-muted d-block">สภาพภายนอกก่อนซ่อม</span>
                    <div class="text-secondary">{{ $ticket->device_condition }}</div>
                </div>
                @endif
                @if($ticket->technician_notes)
                <div class="col-12">
                    <span class="text-muted d-block">บันทึกภายในช่าง</span>
                    <div class="p-2 border border-warning rounded bg-warning bg-opacity-10 text-dark">
                        <i class="bi bi-pin-angle-fill text-warning me-1"></i> {{ $ticket->technician_notes }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Customer Info -->
        <div class="card card-custom p-4 mb-4">
            <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-person-circle text-primary"></i> ข้อมูลลูกค้า
            </h5>
            <div class="row g-3 small">
                <div class="col-sm-6">
                    <span class="text-muted d-block">ชื่อลูกค้า</span>
                    <strong class="text-dark fs-6">{{ $ticket->customer->name }}</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">เบอร์โทรศัพท์</span>
                    <strong class="text-dark">{{ $ticket->customer->phone }}</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">LINE ID</span>
                    <span>{{ $ticket->customer->line_id ?? '-' }}</span>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">อีเมล</span>
                    <span>{{ $ticket->customer->email ?? '-' }}</span>
                </div>
                <div class="col-12">
                    <span class="text-muted d-block">ที่อยู่</span>
                    <span>{{ $ticket->customer->address ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Timeline Log History -->
        <div class="card card-custom p-4">
            <h5 class="fw-bold text-dark border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-primary"></i> บันทึกขั้นตอนงานซ่อม (Timeline History)
            </h5>

            <div class="position-relative ps-4" style="border-left: 2px solid #e2e8f0; margin-left: 10px;">
                @foreach($ticket->statusLogs as $log)
                <div class="position-relative mb-4">
                    <div class="position-absolute" style="left: -31px; top: 0;">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" style="width: 22px; height: 22px; font-size: 0.65rem;">
                            <i class="bi bi-check"></i>
                        </span>
                    </div>

                    <div class="card border rounded-3 p-3 bg-white shadow-xs">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-dark small">{{ $log->title }}</strong>
                            <span class="status-pill badge-{{ $log->status }} text-xs">
                                {{ $log->status }}
                            </span>
                        </div>
                        @if($log->note)
                            <p class="text-secondary small mb-2">{{ $log->note }}</p>
                        @endif
                        <div class="d-flex justify-content-between align-items-center text-muted text-xs" style="font-size: 0.75rem;">
                            <span><i class="bi bi-person me-1"></i> {{ $log->performed_by }}</span>
                            <span><i class="bi bi-clock me-1"></i> {{ $log->created_at->format('d/m/Y H:i น.') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Right Column: Status Updater & Billing -->
    <div class="col-lg-5">
        <!-- Quick Status Update Card -->
        <div class="card card-custom p-4 mb-4 border-primary border-2 shadow-sm">
            <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-arrow-repeat text-primary"></i> อัปเดตสถานะงานซ่อม
            </h5>

            <form action="{{ route('admin.tickets.updateStatus', $ticket->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-dark">เปลี่ยนสถานะงาน</label>
                    <select name="status" class="form-select fw-semibold" id="newStatusSelect" required>
                        <option value="pending" {{ $ticket->status === 'pending' ? 'selected' : '' }}>รอรับเครื่อง / รอตรวจเช็ค</option>
                        <option value="inspecting" {{ $ticket->status === 'inspecting' ? 'selected' : '' }}>กำลังตรวจเช็คอาการ</option>
                        <option value="waiting_parts" {{ $ticket->status === 'waiting_parts' ? 'selected' : '' }}>รออะไหล่แท้ตรงรุ่น</option>
                        <option value="repairing" {{ $ticket->status === 'repairing' ? 'selected' : '' }}>กำลังดำเนินการซ่อม</option>
                        <option value="completed" {{ $ticket->status === 'completed' ? 'selected' : '' }}>ซ่อมเสร็จสิ้น (รอรับเครื่อง)</option>
                        <option value="delivered" {{ $ticket->status === 'delivered' ? 'selected' : '' }}>ส่งมอบเครื่องแล้ว (ปิดงาน)</option>
                        <option value="cancelled" {{ $ticket->status === 'cancelled' ? 'selected' : '' }}>ยกเลิกการซ่อม</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-dark">หัวข้อบันทึกขั้นตอน <span class="text-danger">*</span></label>
                    <input type="text" name="log_title" id="logTitleInput" class="form-control" 
                           placeholder="เช่น เปลี่ยนจอแท้เสร็จสิ้นแล้ว กำลังเทสระบบ TrueTone" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-dark">รายละเอียดบันทึกเพิ่มเติม (สำหรับลูกค้าดูในระบบ)</label>
                    <textarea name="log_note" rows="2" class="form-control" 
                              placeholder="ผลการเทส, ข้อมูลอะไหล่ หรือคำแนะนำลูกค้า"></textarea>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold small text-dark">ยอดเงินจริง (บาท)</label>
                        <input type="number" name="final_cost" class="form-control" 
                               value="{{ $ticket->final_cost ?: $ticket->estimated_cost }}" step="50" min="0">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold small text-dark">รับประกัน (วัน)</label>
                        <input type="number" name="warranty_days" class="form-control" value="90" min="0">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    <i class="bi bi-save me-1"></i> บันทึกและแจ้งอัปเดตสถานะ
                </button>
            </form>
        </div>

        <!-- Cost & Payment Summary Card -->
        <div class="card card-custom p-4 mb-4">
            <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-receipt text-success"></i> สรุปค่าบริการและสถานะการเงิน
            </h5>

            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">บริการหลัก:</span>
                <strong>{{ $ticket->repairService ? $ticket->repairService->name : 'ตรวจเช็คตามอาการ' }}</strong>
            </div>

            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">ราคาประเมินแรกเริ่ม:</span>
                <span>฿{{ number_format($ticket->estimated_cost, 2) }}</span>
            </div>

            <div class="d-flex justify-content-between align-items-center py-2 border-top border-bottom my-2">
                <strong class="fs-6 text-dark">ยอดชำระสุทธิ:</strong>
                <strong class="fs-4 text-primary">
                    ฿{{ number_format($ticket->final_cost ?: $ticket->estimated_cost, 2) }}
                </strong>
            </div>

            @if($ticket->warranty_until)
            <div class="p-2 bg-success bg-opacity-10 text-success rounded small mt-2">
                <i class="bi bi-shield-check me-1"></i>
                รับประกันงานซ่อมถึง: <strong>{{ $ticket->warranty_until->format('d/m/Y') }}</strong>
            </div>
            @endif

            @if($ticket->completed_at)
            <div class="text-muted small mt-2">
                <i class="bi bi-check2-circle text-success me-1"></i> เวลาซ่อมเสร็จ: {{ $ticket->completed_at->format('d/m/Y H:i') }}
            </div>
            @endif

            @if($ticket->delivered_at)
            <div class="text-muted small mt-1">
                <i class="bi bi-box-arrow-right text-dark me-1"></i> เวลาส่งมอบ: {{ $ticket->delivered_at->format('d/m/Y H:i') }}
            </div>
            @endif
        </div>

        <!-- Danger Zone (Delete) -->
        <div class="card card-custom p-4 border-danger border-opacity-25">
            <h6 class="fw-bold text-danger mb-2"><i class="bi bi-trash3 me-1"></i> จัดการขั้นสูง</h6>
            <p class="text-muted small mb-3">การลบใบแจ้งซ่อมจะลบประวัติและข้อมูลที่เกี่ยวข้องทั้งหมด</p>
            <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('ยืนยันที่จะลบใบแจ้งซ่อมรหัส {{ $ticket->ticket_number }} หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-pill">
                    ลบใบแจ้งซ่อมนี้
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelect = document.getElementById('newStatusSelect');
        const titleInput = document.getElementById('logTitleInput');

        const defaultTitles = {
            'pending': 'รับเครื่องเข้าระบบและรอตรวจเช็ค',
            'inspecting': 'ช่างเริ่มตรวจเช็คระบบไฟและเมนบอร์ด',
            'waiting_parts': 'สั่งเบิกอะไหล่แท้ตรงรุ่น รอส่งมอบ',
            'repairing': 'กำลังลงมือเปลี่ยนอะไหล่และแก้ไขวงจร',
            'completed': 'การซ่อมเสร็จสิ้น ทดสอบฟังก์ชันผ่าน 100%',
            'delivered': 'ลูกค้าตรวจสอบเครื่องและรับเครื่องเรียบร้อย',
            'cancelled': 'ยกเลิกการซ่อม ส่งคืนเครื่องลูกค้า'
        };

        statusSelect.addEventListener('change', function () {
            if (defaultTitles[statusSelect.value]) {
                titleInput.value = defaultTitles[statusSelect.value];
            }
        });
    });
</script>
@endsection
