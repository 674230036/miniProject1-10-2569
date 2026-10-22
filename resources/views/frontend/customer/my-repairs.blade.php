@extends('layouts.app')

@section('title', 'งานซ่อมของฉัน (My Repairs) - iRepair NPRU')

@section('content')
<div class="py-5 bg-light" style="min-height: 85vh;">
    <div class="container">
        
        <!-- Welcome Member Banner -->
        <div class="card card-apple p-4 p-md-4 mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff;">
            <div class="row align-items-center g-3">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow" style="width: 60px; height: 60px; font-size: 1.6rem;">
                            {{ mb_substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h3 class="fw-bold mb-0 text-white brand-font">{{ $user->name }}</h3>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1">
                                    <i class="bi bi-shield-check me-1"></i> สมาชิก iRepair Studio
                                </span>
                            </div>
                            <div class="text-white-50 small mt-1 d-flex flex-wrap gap-3">
                                <span><i class="bi bi-telephone text-info me-1"></i> {{ $user->phone ?? ($customer->phone ?? '-') }}</span>
                                <span><i class="bi bi-envelope text-info me-1"></i> {{ $user->email }}</span>
                                @if(!empty($customer->line_id))
                                    <span><i class="bi bi-chat-dots text-success me-1"></i> LINE: {{ $customer->line_id }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end d-flex flex-wrap gap-2 justify-content-md-end">
                    <a href="{{ route('booking.create') }}" class="btn btn-primary rounded-pill px-3 py-2 shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> แจ้งซ่อมเครื่องใหม่
                    </a>
                    <a href="{{ route('customer.profile') }}" class="btn btn-outline-light rounded-pill px-3 py-2">
                        <i class="bi bi-gear me-1"></i> แก้ไขข้อมูล
                    </a>
                </div>
            </div>
        </div>

        <!-- Overview Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card card-apple p-3 border-0 shadow-sm text-center">
                    <div class="text-muted small mb-1 fw-semibold">งานซ่อมทั้งหมด</div>
                    <div class="display-6 fw-bold text-dark">{{ $stats['total'] }}</div>
                    <div class="text-muted text-xs small">รายการที่บันทึก</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-apple p-3 border-0 shadow-sm text-center">
                    <div class="text-primary small mb-1 fw-semibold">กำลังดำเนินการ</div>
                    <div class="display-6 fw-bold text-primary">{{ $stats['active'] }}</div>
                    <div class="text-muted text-xs small">ตรวจเช็ค / รออะไหล่ / กำลังซ่อม</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-apple p-3 border-0 shadow-sm text-center">
                    <div class="text-success small mb-1 fw-semibold">ซ่อมเสร็จแล้ว</div>
                    <div class="display-6 fw-bold text-success">{{ $stats['completed'] }}</div>
                    <div class="text-muted text-xs small">พร้อมรับเครื่องได้ทันที</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-apple p-3 border-0 shadow-sm text-center">
                    <div class="text-secondary small mb-1 fw-semibold">ส่งมอบแล้ว</div>
                    <div class="display-6 fw-bold text-secondary">{{ $stats['delivered'] }}</div>
                    <div class="text-muted text-xs small">ปิดงานสมบูรณ์</div>
                </div>
            </div>
        </div>

        <!-- Section Title & Filter -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2 brand-font">
                <i class="bi bi-phone-fill text-primary"></i> รายการเครื่องซ่อมของฉัน
            </h4>
            <span class="text-muted small">พบ {{ $tickets->count() }} รายการ</span>
        </div>

        @if($tickets->isEmpty())
            <!-- Empty State -->
            <div class="card card-apple p-5 text-center border-0 shadow-sm my-4">
                <div class="py-4">
                    <span class="d-inline-flex align-items-center justify-content-center bg-light text-muted rounded-circle p-4 fs-1 mb-3">
                        <i class="bi bi-tools"></i>
                    </span>
                    <h4 class="fw-bold text-dark mb-2">ยังไม่มีประวัติการแจ้งซ่อมในระบบ</h4>
                    <p class="text-muted mx-auto" style="max-width: 480px;">
                        ท่านสามารถส่งคำขอแจ้งซ่อม iPhone ออนไลน์ได้ง่ายๆ โดยระบบจะดึงข้อมูลติดต่อของท่านไปกรอกให้อัตโนมัติ พร้อมตรวจเช็คฟรีไม่มีค่าเปิดเครื่อง
                    </p>
                    <a href="{{ route('booking.create') }}" class="btn btn-apple px-4 py-2 mt-2">
                        <i class="bi bi-plus-circle me-1"></i> แจ้งซ่อมเครื่องแรกของคุณ
                    </a>
                </div>
            </div>
        @else
            <!-- Tickets List -->
            <div class="d-grid gap-4">
                @foreach($tickets as $ticket)
                    <div class="card card-apple border-0 shadow-sm overflow-hidden">
                        <!-- Ticket Header -->
                        <div class="p-3 px-4 bg-light border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-dark rounded-pill px-3 py-2 font-monospace fs-6">
                                    <i class="bi bi-ticket-perforated me-1 text-warning"></i> {{ $ticket->ticket_number }}
                                </span>
                                <span class="text-muted small">
                                    <i class="bi bi-calendar3 me-1"></i> แจ้งเมื่อ {{ $ticket->created_at->format('d/m/Y H:i') }} น.
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge badge-{{ $ticket->status }} status-pill">
                                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> {{ $ticket->status_thai }}
                                </span>
                            </div>
                        </div>

                        <!-- Ticket Body -->
                        <div class="p-4">
                            <div class="row g-4 align-items-center">
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="bg-primary-subtle text-primary rounded-3 p-3 fs-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="bi bi-apple"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold text-dark mb-1">{{ $ticket->phoneModel->name ?? 'iPhone ไม่ระบุรุ่น' }}</h5>
                                            <div class="text-muted small mb-2">
                                                <span><i class="bi bi-palette me-1"></i> สี: <strong>{{ $ticket->device_color ?? 'ไม่ระบุ' }}</strong></span>
                                                @if($ticket->imei_serial)
                                                    <span class="ms-2"><i class="bi bi-upc-scan me-1"></i> IMEI: {{ $ticket->imei_serial }}</span>
                                                @endif
                                            </div>
                                            <div class="p-2 bg-light rounded-3 small">
                                                <div class="fw-semibold text-dark"><i class="bi bi-wrench me-1 text-primary"></i> บริการ / อาการเสีย:</div>
                                                <div class="text-muted">{{ $ticket->repairService->name ?? 'ตรวจเช็คตามอาการ' }} - {{ $ticket->symptom_description }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row g-2 text-center text-md-start">
                                        <div class="col-sm-6">
                                            <div class="p-3 bg-light rounded-3 h-100">
                                                <div class="text-muted text-xs small">ราคาประเมินเบื้องต้น</div>
                                                <div class="fs-5 fw-bold text-dark">
                                                    ฿{{ number_format($ticket->estimated_cost, 0) }}
                                                </div>
                                                <div class="text-muted text-xs" style="font-size: 0.75rem;">
                                                    {{ $ticket->final_cost ? 'ราคาจริงสุทธิ: ฿' . number_format($ticket->final_cost, 0) : 'ราคาก่อนเริ่มงานซ่อม' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="p-3 bg-light rounded-3 h-100">
                                                <div class="text-muted text-xs small">ช่างผู้รับผิดชอบ</div>
                                                <div class="fs-6 fw-bold text-dark text-truncate">
                                                    {{ $ticket->technician->name ?? 'เจ้าหน้าที่ศูนย์ซ่อม' }}
                                                </div>
                                                <div class="text-muted text-xs" style="font-size: 0.75rem;">
                                                    <i class="bi bi-check-circle-fill text-success me-1"></i> ผ่านการรับรอง NPRU
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Step Bar -->
                            <div class="mt-4 pt-3 border-top">
                                <div class="progress-steps my-2">
                                    <div class="progress-step-item {{ $ticket->progress_step >= 1 ? 'step-done' : '' }}">
                                        <div class="step-circle"><i class="bi bi-receipt"></i></div>
                                        <div class="step-title">1. รับเครื่อง</div>
                                    </div>
                                    <div class="progress-step-item {{ $ticket->progress_step > 2 ? 'step-done' : ($ticket->progress_step == 2 ? 'step-active' : '') }}">
                                        <div class="step-circle"><i class="bi bi-search"></i></div>
                                        <div class="step-title">2. ตรวจเช็ค</div>
                                    </div>
                                    <div class="progress-step-item {{ $ticket->progress_step > 3 ? 'step-done' : ($ticket->progress_step == 3 ? 'step-active' : '') }}">
                                        <div class="step-circle"><i class="bi bi-tools"></i></div>
                                        <div class="step-title">3. ซ่อมบำรุง</div>
                                    </div>
                                    <div class="progress-step-item {{ $ticket->progress_step > 4 ? 'step-done' : ($ticket->progress_step == 4 ? 'step-active' : '') }}">
                                        <div class="step-circle"><i class="bi bi-check2-all"></i></div>
                                        <div class="step-title">4. ซ่อมเสร็จ</div>
                                    </div>
                                    <div class="progress-step-item {{ $ticket->progress_step == 5 ? 'step-done' : '' }}">
                                        <div class="step-circle"><i class="bi bi-box-seam"></i></div>
                                        <div class="step-title">5. ส่งมอบ</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Latest Note -->
                            @if($ticket->statusLogs->isNotEmpty())
                                <div class="p-3 bg-primary-subtle text-primary-emphasis rounded-3 small d-flex flex-wrap align-items-center justify-content-between gap-2 mt-3 border border-primary-subtle">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-info-circle-fill text-primary fs-5"></i>
                                        <div>
                                            <strong>สถานะล่าสุด:</strong> {{ $ticket->statusLogs->first()->title }} - {{ $ticket->statusLogs->first()->note }}
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-white text-primary border border-primary-subtle px-2 py-1 shadow-sm">
                                            <i class="bi bi-calendar3 me-1"></i>{{ $ticket->statusLogs->first()->created_at->format('d/m/Y H:i น.') }}
                                        </span>
                                        <span class="badge bg-primary text-white px-2 py-1">
                                            {{ $ticket->statusLogs->first()->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Ticket Footer -->
                        <div class="p-3 px-4 bg-light border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div class="small text-muted">
                                @if($ticket->warranty_until)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                        <i class="bi bi-shield-check me-1"></i> ประกันถึง: {{ $ticket->warranty_until->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1">
                                        <i class="bi bi-shield me-1"></i> รับประกันงานซ่อมมาตรฐาน
                                    </span>
                                @endif
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('tracking.print', $ticket->ticket_number) }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                    <i class="bi bi-printer me-1"></i> พิมพ์ใบรับเครื่อง
                                </a>
                                <a href="{{ route('tracking.show', $ticket->ticket_number) }}" class="btn btn-apple btn-sm px-3">
                                    <i class="bi bi-clock-history me-1"></i> ดูไทม์ไลน์ละเอียด
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mb-5"></div>
    </div>
</div>
@endsection
