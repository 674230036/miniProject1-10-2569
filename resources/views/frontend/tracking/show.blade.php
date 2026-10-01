@extends('layouts.app')

@section('title', 'สถานะงานซ่อม: ' . $ticket->ticket_number . ' - iRepair NPRU')

@section('content')
<div class="py-5 bg-light">
    <div class="container py-lg-3">
        <!-- Top Navigation -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <div>
                <a href="{{ route('tracking.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill mb-2">
                    <i class="bi bi-arrow-left me-1"></i> ค้นหารายการอื่น
                </a>
                <div class="d-flex align-items-center gap-3">
                    <h2 class="h3 fw-bold mb-0 text-dark">ใบรับซ่อมเลขที่: <span class="text-primary">{{ $ticket->ticket_number }}</span></h2>
                    <span class="status-pill badge-{{ $ticket->status }} fs-6">
                        {{ $ticket->status_thai }}
                    </span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('tracking.print', $ticket->ticket_number) }}" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    <i class="bi bi-printer me-1"></i> พิมพ์ใบรับเครื่อง
                </a>
            </div>
        </div>

        <!-- 5-Step Visual Progress Bar -->
        <div class="card card-apple p-4 p-md-5 mb-4">
            <h5 class="fw-bold text-dark mb-4 text-center">ความคืบหน้าการซ่อมบำรุง</h5>
            
            <div class="progress-steps">
                <!-- Step 1: รับเครื่อง -->
                <div class="progress-step-item {{ $ticket->progress_step >= 1 ? ($ticket->progress_step == 1 ? 'step-active' : 'step-done') : '' }}">
                    <div class="step-circle">
                        @if($ticket->progress_step > 1) <i class="bi bi-check-lg"></i> @else 1 @endif
                    </div>
                    <div class="step-title">1. รับเครื่องเข้าระบบ</div>
                </div>

                <!-- Step 2: ตรวจเช็ค -->
                <div class="progress-step-item {{ $ticket->progress_step >= 2 ? ($ticket->progress_step == 2 ? 'step-active' : 'step-done') : '' }}">
                    <div class="step-circle">
                        @if($ticket->progress_step > 2) <i class="bi bi-check-lg"></i> @else 2 @endif
                    </div>
                    <div class="step-title">2. ตรวจเช็คอาการ</div>
                </div>

                <!-- Step 3: ดำเนินการซ่อม -->
                <div class="progress-step-item {{ $ticket->progress_step >= 3 ? ($ticket->progress_step == 3 ? 'step-active' : 'step-done') : '' }}">
                    <div class="step-circle">
                        @if($ticket->progress_step > 3) <i class="bi bi-check-lg"></i> @else 3 @endif
                    </div>
                    <div class="step-title">3. ดำเนินการซ่อม</div>
                </div>

                <!-- Step 4: ซ่อมเสร็จแล้ว -->
                <div class="progress-step-item {{ $ticket->progress_step >= 4 ? ($ticket->progress_step == 4 ? 'step-active' : 'step-done') : '' }}">
                    <div class="step-circle">
                        @if($ticket->progress_step > 4) <i class="bi bi-check-lg"></i> @else 4 @endif
                    </div>
                    <div class="step-title">4. ซ่อมเสร็จสมบูรณ์</div>
                </div>

                <!-- Step 5: ส่งมอบ -->
                <div class="progress-step-item {{ $ticket->progress_step == 5 ? 'step-done' : '' }}">
                    <div class="step-circle">
                        @if($ticket->progress_step == 5) <i class="bi bi-check-lg"></i> @else 5 @endif
                    </div>
                    <div class="step-title">5. ส่งมอบเครื่อง</div>
                </div>
            </div>

            <!-- Current Status Notice Alert -->
            @if($ticket->status === 'completed')
                <div class="alert alert-success d-flex align-items-center rounded-3 mb-0" role="alert">
                    <i class="bi bi-bell-fill fs-4 me-3 text-success"></i>
                    <div>
                        <strong>เครื่องของท่านซ่อมเสร็จเรียบร้อยแล้ว!</strong><br>
                        <span class="small">ท่านสามารถเข้ามารับเครื่องได้ที่ศูนย์บริการ iRepair NPRU พร้อมแสดงใบรับซ่อมหรือบัตรประชาชน</span>
                    </div>
                </div>
            @elseif($ticket->status === 'repairing')
                <div class="alert alert-primary d-flex align-items-center rounded-3 mb-0" role="alert">
                    <i class="bi bi-gear-wide-connected fs-4 me-3 text-primary"></i>
                    <div>
                        <strong>ช่างกำลังดำเนินการซ่อมแซมอย่างประณีต</strong><br>
                        <span class="small">กำลังอยู่ระหว่างการซ่อมเปลี่ยนอะไหล่และทดสอบระบบการทำงาน จะแจ้งเตือนทันทีเมื่องานเสร็จ</span>
                    </div>
                </div>
            @elseif($ticket->status === 'waiting_parts')
                <div class="alert alert-warning d-flex align-items-center rounded-3 mb-0" role="alert">
                    <i class="bi bi-box-seam fs-4 me-3 text-warning"></i>
                    <div>
                        <strong>กำลังรอจัดส่งอะไหล่แท้ตรงรุ่น</strong><br>
                        <span class="small">ศูนย์บริการกำลังรออะไหล่จากคลังหลัก คาดว่าจะเริ่มดำเนินการซ่อมในไม่ช้า</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="row g-4">
            <!-- Left Column: Details -->
            <div class="col-lg-6">
                <!-- Device Info Card -->
                <div class="card card-apple p-4 mb-4">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-phone text-primary"></i> ข้อมูลตัวเครื่องที่ส่งซ่อม
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">ชื่อลูกค้าผู้ส่งซ่อม</span>
                            <strong class="text-dark fs-6">{{ $ticket->customer->name }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">เบอร์โทรศัพท์</span>
                            <span class="text-dark">{{ $ticket->customer->phone }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">รุ่น iPhone</span>
                            <strong class="text-dark fs-6">{{ $ticket->phoneModel->name }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">สีตัวเครื่อง</span>
                            <span class="text-dark fw-medium">{{ $ticket->device_color ?? '-' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">หมายเลข IMEI / Serial</span>
                            <span class="text-monospace small">{{ $ticket->imei_serial ?? 'ไม่ได้ระบุ' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">ช่องทางการส่งเครื่อง</span>
                            <span class="badge bg-light text-dark border">
                                {{ $ticket->service_type === 'walk_in' ? 'นำเครื่องมาเองหน้าร้าน' : ($ticket->service_type === 'online_booking' ? 'นัดหมายแจ้งซ่อมออนไลน์' : 'ส่งพัสดุ') }}
                            </span>
                        </div>
                        <div class="col-12">
                            <span class="text-muted small d-block">อาการเสียที่ลูกค้าแจ้ง</span>
                            <div class="p-2 bg-light rounded text-dark small mt-1">
                                {{ $ticket->symptom_description }}
                            </div>
                        </div>
                        @if($ticket->device_condition)
                        <div class="col-12">
                            <span class="text-muted small d-block">สภาพภายนอกก่อนซ่อม</span>
                            <span class="small text-secondary">{{ $ticket->device_condition }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Cost & Warranty Card -->
                <div class="card card-apple p-4 mb-4">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-receipt text-success"></i> ค่าบริการและการรับประกัน
                    </h5>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">บริการหลัก:</span>
                        <strong>{{ $ticket->repairService ? $ticket->repairService->name : 'ตรวจเช็คตามอาการ' }}</strong>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">ราคาประเมินเบื้องต้น:</span>
                        <span>฿{{ number_format($ticket->estimated_cost, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2 border-top border-bottom my-2">
                        <strong class="fs-5 text-dark">ยอดชำระสุทธิ:</strong>
                        <strong class="fs-4 text-primary">
                            ฿{{ number_format($ticket->final_cost ?: $ticket->estimated_cost, 2) }}
                        </strong>
                    </div>

                    @if($ticket->warranty_until)
                    <div class="p-2 bg-success bg-opacity-10 text-success rounded-3 small mt-2">
                        <i class="bi bi-shield-check me-1"></i>
                        รับประกันงานซ่อมถึงวันที่: <strong>{{ $ticket->warranty_until->format('d/m/Y') }}</strong>
                    </div>
                    @endif

                    @if($ticket->technician)
                    <div class="mt-3 pt-2 text-muted small">
                        <i class="bi bi-person-gear me-1"></i> ช่างผู้รับผิดชอบ: <strong>{{ $ticket->technician->name }}</strong>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Timeline Logs -->
            <div class="col-lg-6">
                <div class="card card-apple p-4">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-primary"></i> บันทึกขั้นตอนการทำงานของช่าง
                    </h5>

                    @if($ticket->statusLogs->isEmpty())
                        <p class="text-muted small text-center py-4">ยังไม่มีบันทึกสถานะ</p>
                    @else
                        <div class="position-relative ps-4" style="border-left: 2px solid #e2e8f0; margin-left: 10px;">
                            @foreach($ticket->statusLogs as $log)
                            <div class="position-relative mb-4">
                                <!-- Dot -->
                                <div class="position-absolute" style="left: -31px; top: 0;">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" style="width: 22px; height: 22px; font-size: 0.65rem;">
                                        <i class="bi bi-check"></i>
                                    </span>
                                </div>

                                <div class="card border rounded-3 p-3 bg-white shadow-xs">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="text-dark small">{{ $log->title }}</strong>
                                        <span class="badge badge-{{ $log->status }} status-pill text-xs">
                                            {{ match($log->status) {
                                                'pending' => 'รอรับเครื่อง',
                                                'inspecting' => 'ตรวจเช็ค',
                                                'waiting_parts' => 'รออะไหล่',
                                                'repairing' => 'กำลังซ่อม',
                                                'completed' => 'ซ่อมเสร็จ',
                                                'delivered' => 'ส่งมอบแล้ว',
                                                default => $log->status
                                            } }}
                                        </span>
                                    </div>
                                    @if($log->note)
                                        <p class="text-secondary small mb-2">{{ $log->note }}</p>
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.75rem;">
                                        <span><i class="bi bi-person me-1"></i> {{ $log->performed_by }}</span>
                                        <span><i class="bi bi-clock me-1"></i> {{ $log->created_at->format('d/m/Y H:i น.') }} ({{ $log->created_at->diffForHumans() }})</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
