@extends('layouts.admin')

@section('title', 'ประวัติลูกค้า: ' . $customer->name . ' - iRepair NPRU')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 fw-bold mb-1 text-dark">ประวัติลูกค้า: <span class="text-primary">{{ $customer->name }}</span></h2>
        <p class="text-muted small mb-0">ข้อมูลติดต่อและประวัติเครื่องที่เคยนำมาส่งซ่อม</p>
    </div>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> ย้อนกลับ
    </a>
</div>

<div class="row g-4">
    <!-- Customer Info Card -->
    <div class="col-lg-4">
        <div class="card card-custom p-4">
            <div class="text-center pb-3 border-bottom mb-3">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center fs-2 mb-2" style="width: 70px; height: 70px;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h5 class="fw-bold text-dark mb-0">{{ $customer->name }}</h5>
                <span class="badge bg-light text-dark border mt-1">ลูกค้าศูนย์บริการ</span>
            </div>

            <div class="small">
                <div class="mb-2">
                    <span class="text-muted d-block">เบอร์โทรศัพท์:</span>
                    <strong class="text-dark">{{ $customer->phone }}</strong>
                </div>
                <div class="mb-2">
                    <span class="text-muted d-block">LINE ID:</span>
                    <span>{{ $customer->line_id ?? '-' }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-muted d-block">อีเมล:</span>
                    <span>{{ $customer->email ?? '-' }}</span>
                </div>
                <div class="mb-3">
                    <span class="text-muted d-block">ที่อยู่:</span>
                    <span>{{ $customer->address ?? '-' }}</span>
                </div>
                @if($customer->notes)
                <div class="p-2 bg-light rounded text-muted">
                    <i class="bi bi-sticky me-1"></i> {{ $customer->notes }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Customer Repairs History Table -->
    <div class="col-lg-8">
        <div class="card card-custom">
            <div class="card-custom-header">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-phone text-primary me-2"></i>ประวัติเครื่องที่ส่งซ่อม ({{ $customer->repairTickets->count() }} เครื่อง)</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light text-uppercase text-secondary">
                        <tr>
                            <th class="ps-4">เลขที่ใบรับซ่อม</th>
                            <th>รุ่น iPhone</th>
                            <th>อาการเสีย</th>
                            <th>สถานะ</th>
                            <th>ค่าใช้จ่าย</th>
                            <th class="text-end pe-4">ดูข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer->repairTickets as $ticket)
                        <tr>
                            <td class="ps-4">
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="fw-bold text-primary text-decoration-none">
                                    {{ $ticket->ticket_number }}
                                </a>
                                <div class="text-muted text-xs">{{ $ticket->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td>
                                <strong>{{ $ticket->phoneModel->name }}</strong>
                                <div class="text-muted text-xs">{{ $ticket->device_color }}</div>
                            </td>
                            <td class="text-truncate" style="max-width: 180px;">{{ $ticket->symptom_description }}</td>
                            <td>
                                <span class="status-pill badge-{{ $ticket->status }}">
                                    {{ $ticket->status_thai }}
                                </span>
                            </td>
                            <td>
                                <strong>฿{{ number_format($ticket->final_cost ?: $ticket->estimated_cost) }}</strong>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                    เปิดดู
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                ยังไม่มีประวัติงานซ่อม
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
