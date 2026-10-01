@extends('layouts.admin')

@section('title', 'จัดการรุ่น iPhone และราคาอะไหล่ - iRepair NPRU')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="h3 fw-bold mb-1 text-dark">รุ่น iPhone และราคาประเมิน</h2>
        <p class="text-muted small mb-0">จัดการรายชื่อรุ่น iPhone หน้าจอ แบตเตอรี่ และสถานะการเปิดรับซ่อม</p>
    </div>
    <button type="button" class="btn btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addModelModal">
        <i class="bi bi-plus-lg me-1"></i> เพิ่มรุ่น iPhone ใหม่
    </button>
</div>

<div class="card card-custom">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-uppercase text-secondary">
                <tr>
                    <th class="ps-4">รุ่น iPhone</th>
                    <th>ซีรีส์ (Series)</th>
                    <th>ปีเปิดตัว</th>
                    <th>ขนาดหน้าจอ</th>
                    <th>ราคาจอแท้</th>
                    <th>ราคาแบตเตอรี่แท้</th>
                    <th>งานซ่อมสะสม</th>
                    <th class="text-end pe-4">การจัดการ</th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($models as $m)
                <tr>
                    <td class="ps-4">
                        <strong class="text-dark">{{ $m->name }}</strong>
                    </td>
                    <td><span class="badge bg-light text-dark border">{{ $m->series }}</span></td>
                    <td>{{ $m->release_year ?? '-' }}</td>
                    <td class="text-muted">{{ $m->screen_size ?? '-' }}</td>
                    <td><strong class="text-primary">฿{{ number_format($m->base_screen_price) }}</strong></td>
                    <td><strong class="text-success">฿{{ number_format($m->base_battery_price) }}</strong></td>
                    <td><span class="badge bg-secondary rounded-pill">{{ $m->repair_tickets_count }} เครื่อง</span></td>
                    <td class="text-end pe-4">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editModelModal{{ $m->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('admin.models.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันลบรุ่น {{ $m->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModelModal{{ $m->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.models.update', $m->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">แก้ไขรุ่น {{ $m->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">ชื่อรุ่น</label>
                                        <input type="text" name="name" class="form-control" value="{{ $m->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">ซีรีส์</label>
                                        <input type="text" name="series" class="form-control" value="{{ $m->series }}" required>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">ปีเปิดตัว</label>
                                            <input type="number" name="release_year" class="form-control" value="{{ $m->release_year }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">ขนาดหน้าจอ</label>
                                            <input type="text" name="screen_size" class="form-control" value="{{ $m->screen_size }}">
                                        </div>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">ราคาจอแท้ (บาท)</label>
                                            <input type="number" name="base_screen_price" class="form-control" value="{{ $m->base_screen_price }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">ราคาแบตแท้ (บาท)</label>
                                            <input type="number" name="base_battery_price" class="form-control" value="{{ $m->base_battery_price }}" required>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="active{{ $m->id }}" {{ $m->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="active{{ $m->id }}">
                                            เปิดรับซ่อมรุ่นนี้
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($models->hasPages())
    <div class="p-3 border-top">
        {{ $models->links() }}
    </div>
    @endif
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.models.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">เพิ่มรุ่น iPhone ใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">ชื่อรุ่น (เช่น iPhone 16 Plus)</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">ซีรีส์ (เช่น iPhone 16 Series)</label>
                        <input type="text" name="series" class="form-control" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">ปีเปิดตัว</label>
                            <input type="number" name="release_year" class="form-control" value="2024">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">ขนาดหน้าจอ</label>
                            <input type="text" name="screen_size" class="form-control" placeholder="เช่น 6.7 นิ้ว OLED">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">ราคาจอแท้ (บาท)</label>
                            <input type="number" name="base_screen_price" class="form-control" value="3500" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">ราคาแบตแท้ (บาท)</label>
                            <input type="number" name="base_battery_price" class="form-control" value="1500" required>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="newActive" checked>
                        <label class="form-check-label small" for="newActive">
                            เปิดรับซ่อมทันที
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">เพิ่มรุ่น</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
