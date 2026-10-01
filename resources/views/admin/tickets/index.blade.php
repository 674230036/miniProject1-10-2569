@extends('layouts.admin')

@section('title', 'รายการใบแจ้งซ่อมทั้งหมด - iRepair NPRU')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="h3 fw-bold mb-1 text-dark">รายการใบแจ้งซ่อม iPhone</h2>
        <p class="text-muted small mb-0">ค้นหา ติดตาม และอัปเดตสถานะงานซ่อมทั้งหมดในระบบ</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary rounded-pill px-3">
            <i class="bi bi-plus-lg me-1"></i> เปิดใบรับซ่อมใหม่
        </a>
    </div>
</div>

<!-- Status Filter Tabs -->
<div class="card card-custom mb-4">
    <div class="p-3">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.tickets.index') }}" 
               class="btn btn-sm rounded-pill {{ !request('status') ? 'btn-primary' : 'btn-light border' }}">
                ทั้งหมด ({{ $statusCounts['all'] }})
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'pending']) }}" 
               class="btn btn-sm rounded-pill {{ request('status') === 'pending' ? 'btn-warning text-dark' : 'btn-light border' }}">
                รอตรวจเช็ค ({{ $statusCounts['pending'] }})
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'inspecting']) }}" 
               class="btn btn-sm rounded-pill {{ request('status') === 'inspecting' ? 'btn-info text-white' : 'btn-light border' }}">
                กำลังตรวจเช็ค ({{ $statusCounts['inspecting'] }})
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'waiting_parts']) }}" 
               class="btn btn-sm rounded-pill {{ request('status') === 'waiting_parts' ? 'btn-secondary text-white' : 'btn-light border' }}">
                รออะไหล่ ({{ $statusCounts['waiting_parts'] }})
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'repairing']) }}" 
               class="btn btn-sm rounded-pill {{ request('status') === 'repairing' ? 'btn-dark' : 'btn-light border' }}">
                กำลังซ่อม ({{ $statusCounts['repairing'] }})
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'completed']) }}" 
               class="btn btn-sm rounded-pill {{ request('status') === 'completed' ? 'btn-success' : 'btn-light border' }}">
                ซ่อมเสร็จแล้ว ({{ $statusCounts['completed'] }})
            </a>
            <a href="{{ route('admin.tickets.index', ['status' => 'delivered']) }}" 
               class="btn btn-sm rounded-pill {{ request('status') === 'delivered' ? 'btn-dark' : 'btn-light border' }}">
                ส่งมอบแล้ว ({{ $statusCounts['delivered'] }})
            </a>
        </div>
    </div>
</div>

<!-- Search Form -->
<div class="card card-custom mb-4">
    <div class="p-3">
        <form action="{{ route('admin.tickets.index') }}" method="GET" class="row g-2 align-items-center">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="col-md-9 col-12">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" 
                           placeholder="ค้นหาด้วย เลขที่ใบรับซ่อม, ชื่อลูกค้า, เบอร์โทรศัพท์, หรือ IMEI..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3 col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 rounded-pill">ค้นหา</button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-light border rounded-pill">ล้างค่า</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Tickets Table -->
<div class="card card-custom">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-uppercase text-secondary">
                <tr>
                    <th class="ps-4">เลขที่ใบรับซ่อม</th>
                    <th>วันที่รับเครื่อง</th>
                    <th>ลูกค้า</th>
                    <th>รุ่น / สี</th>
                    <th>อาการเสีย</th>
                    <th>สถานะ</th>
                    <th>ราคา</th>
                    <th>ช่างผู้รับผิดชอบ</th>
                    <th class="text-end pe-4">จัดการ</th>
                </tr>
            </thead>
            <tbody class="small">
                @forelse($tickets as $ticket)
                <tr>
                    <td class="ps-4">
                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="fw-bold text-primary text-decoration-none">
                            {{ $ticket->ticket_number }}
                        </a>
                        @if($ticket->priority === 'urgent')
                            <span class="badge bg-danger ms-1 text-xs">ด่วน</span>
                        @endif
                    </td>
                    <td>
                        <span class="text-dark">{{ $ticket->created_at->format('d/m/Y') }}</span>
                        <div class="text-muted text-xs">{{ $ticket->created_at->format('H:i น.') }}</div>
                    </td>
                    <td>
                        <strong class="text-dark">{{ $ticket->customer->name }}</strong>
                        <div class="text-muted text-xs"><i class="bi bi-telephone me-1"></i>{{ $ticket->customer->phone }}</div>
                    </td>
                    <td>
                        <strong>{{ $ticket->phoneModel->name }}</strong>
                        <div class="text-muted text-xs">{{ $ticket->device_color ?? '-' }}</div>
                    </td>
                    <td class="text-truncate" style="max-width: 180px;" title="{{ $ticket->symptom_description }}">
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
                    <td>
                        <span class="small text-secondary">{{ $ticket->technician ? $ticket->technician->name : 'ยังไม่มอบหมาย' }}</span>
                    </td>
                    <td class="text-end pe-4">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-outline-primary" title="ดูรายละเอียด/อัปเดต">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.tickets.print', $ticket->id) }}" target="_blank" class="btn btn-outline-dark" title="พิมพ์ใบรับเครื่อง">
                                <i class="bi bi-printer"></i>
                            </a>
                            <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-outline-secondary" title="แก้ไข">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                        ไม่พบข้อมูลใบแจ้งซ่อมตามเงื่อนไขที่ค้นหา
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($tickets->hasPages())
    <div class="p-3 border-top">
        {{ $tickets->links() }}
    </div>
    @endif
</div>
@endsection
