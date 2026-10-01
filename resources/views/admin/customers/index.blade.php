@extends('layouts.admin')

@section('title', 'ฐานข้อมูลลูกค้า - iRepair NPRU')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="h3 fw-bold mb-1 text-dark">ฐานข้อมูลลูกค้าและประวัติการซ่อม</h2>
        <p class="text-muted small mb-0">ค้นหาข้อมูลลูกค้า เบอร์โทรศัพท์ และติดตามประวัติการซ่อมสะสม</p>
    </div>
</div>

<!-- Search Card -->
<div class="card card-custom mb-4">
    <div class="p-3">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-9 col-12">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" 
                           placeholder="ค้นหาตาม ชื่อลูกค้า, เบอร์โทรศัพท์, หรือ LINE ID..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3 col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 rounded-pill">ค้นหา</button>
                @if(request('search'))
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-light border rounded-pill">ล้างค่า</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Customers Table -->
<div class="card card-custom">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-uppercase text-secondary">
                <tr>
                    <th class="ps-4">ชื่อ - นามสกุลลูกค้า</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>LINE ID</th>
                    <th>อีเมล</th>
                    <th>ที่อยู่</th>
                    <th>จำนวนงานส่งซ่อม</th>
                    <th class="text-end pe-4">ประวัติ</th>
                </tr>
            </thead>
            <tbody class="small">
                @forelse($customers as $c)
                <tr>
                    <td class="ps-4">
                        <strong class="text-dark">{{ $c->name }}</strong>
                    </td>
                    <td>
                        <a href="tel:{{ $c->phone }}" class="text-primary text-decoration-none">
                            <i class="bi bi-telephone me-1"></i>{{ $c->phone }}
                        </a>
                    </td>
                    <td>{{ $c->line_id ?? '-' }}</td>
                    <td>{{ $c->email ?? '-' }}</td>
                    <td class="text-truncate" style="max-width: 200px;">{{ $c->address ?? '-' }}</td>
                    <td>
                        <span class="badge bg-primary rounded-pill px-3">{{ $c->repair_tickets_count }} รายการ</span>
                    </td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.customers.show', $c->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="bi bi-clock-history me-1"></i> ดูประวัติซ่อม
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        ไม่พบข้อมูลลูกค้า
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
    <div class="p-3 border-top">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection
