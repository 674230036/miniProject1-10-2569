@extends('layouts.admin')

@section('title', 'แดชบอร์ดสรุปภาพรวมงานซ่อม (Dashboard) - iRepair NPRU')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="h3 fw-bold mb-1 text-dark">แดชบอร์ดภาพรวมระบบงานซ่อม</h2>
        <p class="text-muted small mb-0">
            ระบบจัดการหลังบ้าน &bull; ผู้ดูแลระบบ: <strong>{{ Auth::user()->name }} (รหัส {{ Auth::user()->student_id ?? '036' }})</strong>
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary rounded-pill px-3">
            <i class="bi bi-plus-lg me-1"></i> เปิดใบรับซ่อมใหม่ (หน้าร้าน)
        </a>
    </div>
</div>

<!-- KPI Metric Cards -->
<div class="row g-3 mb-4">
    <!-- Card 1: งานทั้งหมด -->
    <div class="col-xl-3 col-sm-6">
        <div class="card card-custom p-3 border-start border-primary border-4 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted text-xs text-uppercase fw-semibold" style="font-size: 0.78rem;">งานซ่อมทั้งหมด</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_tickets'] }}</h3>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle fs-4">
                    <i class="bi bi-tools"></i>
                </div>
            </div>
            <div class="mt-2 pt-2 border-top small text-muted">
                <span>ลูกค้าในระบบ: <strong>{{ $stats['total_customers'] }}</strong> ท่าน</span>
            </div>
        </div>
    </div>

    <!-- Card 2: รอตรวจเช็ค -->
    <div class="col-xl-3 col-sm-6">
        <div class="card card-custom p-3 border-start border-warning border-4 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted text-xs text-uppercase fw-semibold" style="font-size: 0.78rem;">รอรับเครื่อง / ตรวจเช็ค</span>
                    <h3 class="fw-bold mb-0 text-warning">{{ $stats['pending'] + $stats['inspecting'] }}</h3>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle fs-4">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
            <div class="mt-2 pt-2 border-top small text-muted">
                <span>รอรับเครื่อง {{ $stats['pending'] }} &bull; กำลังตรวจ {{ $stats['inspecting'] }}</span>
            </div>
        </div>
    </div>

    <!-- Card 3: กำลังดำเนินการซ่อม -->
    <div class="col-xl-3 col-sm-6">
        <div class="card card-custom p-3 border-start border-info border-4 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted text-xs text-uppercase fw-semibold" style="font-size: 0.78rem;">กำลังดำเนินการซ่อม</span>
                    <h3 class="fw-bold mb-0 text-info">{{ $stats['in_progress'] }}</h3>
                </div>
                <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle fs-4">
                    <i class="bi bi-gear-wide-connected"></i>
                </div>
            </div>
            <div class="mt-2 pt-2 border-top small text-muted">
                <span>ช่างกำลังลงมือปฏิบัติงาน</span>
            </div>
        </div>
    </div>

    <!-- Card 4: ซ่อมเสร็จ / พร้อมส่งมอบ -->
    <div class="col-xl-3 col-sm-6">
        <div class="card card-custom p-3 border-start border-success border-4 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted text-xs text-uppercase fw-semibold" style="font-size: 0.78rem;">ซ่อมเสร็จรอรับเครื่อง</span>
                    <h3 class="fw-bold mb-0 text-success">{{ $stats['completed'] }}</h3>
                </div>
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle fs-4">
                    <i class="bi bi-check2-circle"></i>
                </div>
            </div>
            <div class="mt-2 pt-2 border-top small text-muted">
                <span>ส่งมอบปิดงานแล้ว: <strong>{{ $stats['delivered'] }}</strong> เครื่อง</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Revenue & Quick Summary Card -->
    <div class="col-lg-4">
        <div class="card card-custom h-100">
            <div class="card-custom-header">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-cash-stack text-success me-2"></i>สรุปยอดค่าบริการ</h5>
            </div>
            <div class="p-4">
                <div class="p-3 bg-light rounded-4 text-center mb-4">
                    <span class="text-muted small d-block">ยอดเงินรวมงานที่ซ่อมเสร็จและส่งมอบ</span>
                    <div class="display-6 fw-bold text-success brand-font">
                        ฿{{ number_format($stats['total_revenue'], 2) }}
                    </div>
                    <span class="badge bg-success-subtle text-success small mt-1">
                        คำนวณจากงาน Completed & Delivered
                    </span>
                </div>

                <h6 class="fw-bold text-dark small mb-3">หมวดหมู่บริการที่มีการส่งซ่อมมากที่สุด:</h6>
                <div class="list-group list-group-flush small">
                    @foreach($serviceStats as $srv)
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <span class="text-truncate me-2">
                            <i class="bi bi-dot text-primary fs-5"></i> {{ $srv->name }}
                        </span>
                        <span class="badge bg-secondary rounded-pill">{{ $srv->repair_tickets_count }} งาน</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Active Technicians in Shop -->
    <div class="col-lg-8">
        <div class="card card-custom h-100">
            <div class="card-custom-header">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-people-fill text-primary me-2"></i>ทีมช่างและผู้ดูแลระบบ (NPRU Project)</h5>
                <span class="badge bg-light text-dark border">งานที่ค้างในมือ</span>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    @foreach($technicians as $tech)
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-5 shadow-xs" style="width: 50px; height: 50px;">
                                {{ $tech->student_id ? substr($tech->student_id, -3) : 'ช่าง' }}
                            </div>
                            <div class="overflow-hidden">
                                <strong class="d-block text-dark text-truncate">{{ $tech->name }}</strong>
                                <span class="badge bg-primary-subtle text-primary small">{{ $tech->role === 'admin' ? 'ผู้ดูแลระบบ (036)' : 'ช่างประจำร้าน (008)' }}</span>
                                <div class="small text-muted mt-1">
                                    <i class="bi bi-wrench me-1"></i> กำลังซ่อม: <strong>{{ $tech->assigned_tickets_count }}</strong> เครื่อง
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="alert alert-light border rounded-3 mt-4 mb-0 small text-secondary">
                    <i class="bi bi-info-circle text-primary me-1"></i>
                    <strong>โครงสร้างโครงงาน:</strong> รหัส 036 (นายธีรเดช) รับผิดชอบฐานข้อมูลและระบบควบคุมงานซ่อมหลังบ้าน, รหัส 008 (นายภูมิพัฒน์) รับผิดชอบส่วนติดต่อลูกค้าหน้าบ้าน
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Repair Tickets Table -->
<div class="card card-custom">
    <div class="card-custom-header">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history text-primary me-2"></i>รายการใบแจ้งซ่อมล่าสุด</h5>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-primary btn-sm rounded-pill">
            ดูทั้งหมด <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-uppercase text-secondary">
                <tr>
                    <th class="ps-4">เลขที่ใบรับซ่อม</th>
                    <th>ลูกค้า</th>
                    <th>รุ่น iPhone</th>
                    <th>อาการเสีย</th>
                    <th>สถานะงาน</th>
                    <th>ราคา</th>
                    <th class="text-end pe-4">การจัดการ</th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($recentTickets as $ticket)
                <tr>
                    <td class="ps-4">
                        <strong class="text-primary">{{ $ticket->ticket_number }}</strong>
                        <div class="text-muted text-xs" style="font-size: 0.75rem;">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </div>
                    </td>
                    <td>
                        <strong class="text-dark">{{ $ticket->customer->name }}</strong>
                        <div class="text-muted text-xs">{{ $ticket->customer->phone }}</div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ $ticket->phoneModel->name }}</span>
                        <div class="text-muted text-xs">{{ $ticket->device_color }}</div>
                    </td>
                    <td class="text-truncate" style="max-width: 200px;" title="{{ $ticket->symptom_description }}">
                        {{ $ticket->symptom_description }}
                    </td>
                    <td>
                        <span class="status-pill badge-{{ $ticket->status }}">
                            {{ $ticket->status_thai }}
                        </span>
                    </td>
                    <td>
                        <strong class="text-dark">฿{{ number_format($ticket->final_cost ?: $ticket->estimated_cost) }}</strong>
                    </td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            จัดการงานซ่อม
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
