@extends('layouts.app')

@section('title', 'ผลการค้นหางานซ่อม - iRepair NPRU')

@section('content')
<div class="py-5 bg-light">
    <div class="container py-lg-3">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <span class="badge bg-primary rounded-pill px-3 py-1 mb-2">ผลการค้นหา</span>
                        <h2 class="fw-bold mb-1">พบรายการซ่อมสำหรับเบอร์: {{ $query }}</h2>
                        <p class="text-muted small mb-0">พบทั้งหมด {{ $tickets->count() }} รายการ กรุณาเลือกรายการที่ต้องการดูข้อมูล</p>
                    </div>
                    <a href="{{ route('tracking.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i> ค้นหาใหม่
                    </a>
                </div>

                <div class="row g-3">
                    @foreach($tickets as $ticket)
                    <div class="col-12">
                        <div class="card card-apple p-4">
                            <div class="row align-items-center g-3">
                                <div class="col-md-3">
                                    <span class="badge bg-dark fs-6 mb-1">{{ $ticket->ticket_number }}</span>
                                    <div class="small text-muted">
                                        วันที่ส่ง: {{ $ticket->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="fw-bold mb-1 text-dark">{{ $ticket->phoneModel->name }}</h5>
                                    <p class="text-muted small mb-0 text-truncate">
                                        <i class="bi bi-wrench me-1"></i> {{ $ticket->symptom_description }}
                                    </p>
                                </div>
                                <div class="col-md-3 text-md-center">
                                    <span class="status-pill badge-{{ $ticket->status }}">
                                        {{ $ticket->status_thai }}
                                    </span>
                                </div>
                                <div class="col-md-2 text-md-end">
                                    <a href="{{ route('tracking.show', $ticket->ticket_number) }}" class="btn btn-apple btn-sm">
                                        ดูไทม์ไลน์ <i class="bi bi-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
