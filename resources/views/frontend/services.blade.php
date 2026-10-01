@extends('layouts.app')

@section('title', 'บริการซ่อมและอัตราค่าบริการ iPhone - iRepair NPRU')

@section('content')
<div class="py-5 bg-light">
    <div class="container py-lg-3">
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-5">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 mb-2">อัตราค่าบริการมาตรฐาน</span>
            <h1 class="display-6 fw-bold">บริการซ่อม iPhone และอะไหล่แท้</h1>
            <p class="text-muted">
                ราคากลางโปร่งใส ตรวจเช็คฟรี ประกันสูงสุด 180 วัน ดำเนินการโดยทีมช่างผู้ชำนาญการ
            </p>
        </div>

        <!-- Grouped Services -->
        @foreach($services as $category => $items)
        <div class="mb-5">
            <h3 class="fw-bold text-dark border-start border-primary border-4 ps-3 mb-4">
                หมวดหมู่: {{ $category }}
            </h3>

            <div class="row g-4">
                @foreach($items as $service)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-apple h-100 p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 fs-3">
                                    <i class="bi {{ $service->icon }}"></i>
                                </span>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                    <i class="bi bi-shield-check me-1"></i> ประกัน {{ $service->warranty_period }}
                                </span>
                            </div>

                            <h4 class="h5 fw-bold text-dark mb-2">{{ $service->name }}</h4>
                            <p class="text-muted small mb-3">{{ $service->description }}</p>

                            <div class="small text-secondary mb-3">
                                <div><i class="bi bi-clock me-1 text-primary"></i> ระยะเวลาซ่อม: <strong>{{ $service->estimated_duration }}</strong></div>
                            </div>
                        </div>

                        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block">ราคาเริ่มต้น</span>
                                <strong class="fs-4 text-primary">฿{{ number_format($service->base_price) }}</strong>
                            </div>
                            <a href="{{ route('booking.create') }}" class="btn btn-apple btn-sm">
                                จองคิวซ่อม <i class="bi bi-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <!-- Warranty Guarantee Banner -->
        <div class="card card-apple p-4 p-md-5 bg-white border-0 shadow-sm mt-5">
            <div class="row align-items-center g-4">
                <div class="col-md-2 text-center text-md-start">
                    <i class="bi bi-patch-check-fill text-primary" style="font-size: 4rem;"></i>
                </div>
                <div class="col-md-7">
                    <h4 class="fw-bold mb-2">เงื่อนไขการรับประกันงานซ่อม (Warranty Terms)</h4>
                    <p class="text-muted small mb-0">
                        เรารับประกันการทำงานของอะไหล่แท้ที่เปลี่ยน หากพบปัญหาเดิมในการใช้งานปกติ สามารถนำเครื่องเข้ามาตรวจเช็คแก้ไขได้ทันทีโดยไม่มีค่าใช้จ่าย (ยกเว้นกรณีเครื่องตกกระแทก ตกน้ำซ้ำ หรือมีการแกะเครื่องจากที่อื่น)
                    </p>
                </div>
                <div class="col-md-3 text-md-end text-center">
                    <a href="{{ route('booking.create') }}" class="btn btn-apple px-4 py-2">
                        แจ้งซ่อมทันที
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
