@extends('layouts.admin')

@section('title', 'จัดการบริการซ่อมและอัตราค่าบริการ - iRepair NPRU')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="h3 fw-bold mb-1 text-dark">ประเภทบริการซ่อมและอัตราค่าบริการ</h2>
        <p class="text-muted small mb-0">กำหนดรายการซ่อม ค่าแรงเริ่มต้น ระยะเวลา และเงื่อนไขการรับประกัน</p>
    </div>
    <button type="button" class="btn btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addServiceModal">
        <i class="bi bi-plus-lg me-1"></i> เพิ่มบริการซ่อมใหม่
    </button>
</div>

<div class="card card-custom">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-uppercase text-secondary">
                <tr>
                    <th class="ps-4">ชื่อบริการ</th>
                    <th>หมวดหมู่</th>
                    <th>เวลาที่ใช้</th>
                    <th>ระยะเวลารับประกัน</th>
                    <th>ราคาเริ่มต้น</th>
                    <th>จำนวนงานที่ซ่อม</th>
                    <th class="text-end pe-4">การจัดการ</th>
                </tr>
            </thead>
            <tbody class="small">
                @foreach($services as $s)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 fs-5">
                                <i class="bi {{ $s->icon }}"></i>
                            </span>
                            <div>
                                <strong class="text-dark d-block">{{ $s->name }}</strong>
                                <span class="text-muted text-xs">{{ Str::limit($s->description, 50) }}</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border">{{ $s->category }}</span></td>
                    <td><i class="bi bi-clock me-1 text-primary"></i>{{ $s->estimated_duration }}</td>
                    <td><span class="badge bg-success-subtle text-success">{{ $s->warranty_period }}</span></td>
                    <td><strong class="text-primary fs-6">฿{{ number_format($s->base_price) }}</strong></td>
                    <td><span class="badge bg-secondary rounded-pill">{{ $s->repair_tickets_count }} งาน</span></td>
                    <td class="text-end pe-4">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $s->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('admin.services.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันลบบริการ {{ $s->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Service Modal -->
                <div class="modal fade" id="editServiceModal{{ $s->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.services.update', $s->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">แก้ไขบริการ {{ $s->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">ชื่อบริการ</label>
                                        <input type="text" name="name" class="form-control" value="{{ $s->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">หมวดหมู่</label>
                                        <input type="text" name="category" class="form-control" value="{{ $s->category }}" required>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">ราคาเริ่มต้น (บาท)</label>
                                            <input type="number" name="base_price" class="form-control" value="{{ $s->base_price }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">ระยะเวลาที่ใช้</label>
                                            <input type="text" name="estimated_duration" class="form-control" value="{{ $s->estimated_duration }}" required>
                                        </div>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">ระยะเวลารับประกัน</label>
                                            <input type="text" name="warranty_period" class="form-control" value="{{ $s->warranty_period }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-semibold">Icon (Bootstrap Icon)</label>
                                            <input type="text" name="icon" class="form-control" value="{{ $s->icon }}">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">คำอธิบาย</label>
                                        <textarea name="description" rows="2" class="form-control">{{ $s->description }}</textarea>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="srvActive{{ $s->id }}" {{ $s->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="srvActive{{ $s->id }}">เปิดให้บริการ</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($services->hasPages())
    <div class="p-3 border-top">
        {{ $services->links() }}
    </div>
    @endif
</div>

<!-- Add Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">เพิ่มบริการซ่อมใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">ชื่อบริการ</label>
                        <input type="text" name="name" class="form-control" placeholder="เช่น เปลี่ยนปุ่ม Power และสวิตช์เพิ่มเสียง" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">หมวดหมู่</label>
                        <input type="text" name="category" class="form-control" placeholder="เช่น บอดี้ / ปุ่มกด" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">ราคาเริ่มต้น (บาท)</label>
                            <input type="number" name="base_price" class="form-control" value="1200" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">ระยะเวลาที่ใช้</label>
                            <input type="text" name="estimated_duration" class="form-control" value="1 - 2 ชั่วโมง" required>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">ระยะเวลารับประกัน</label>
                            <input type="text" name="warranty_period" class="form-control" value="90 วัน" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Icon</label>
                            <input type="text" name="icon" class="form-control" value="bi-tools">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">คำอธิบาย</label>
                        <textarea name="description" rows="2" class="form-control" placeholder="รายละเอียดบริการ"></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="newSrvActive" checked>
                        <label class="form-check-label small" for="newSrvActive">เปิดให้บริการทันที</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">เพิ่มบริการ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
