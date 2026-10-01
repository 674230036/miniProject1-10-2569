@extends('layouts.app')

@section('title', 'แจ้งซ่อมสำเร็จ - รหัส: ' . $ticket->ticket_number . ' - iRepair NPRU')

@section('content')
<div class="py-5 bg-light">
    <div class="container py-lg-4">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <!-- Success Icon -->
                <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle shadow-lg mb-4" style="width: 80px; height: 80px;">
                    <i class="bi bi-check-lg display-5"></i>
                </div>

                <h1 class="display-6 fw-bold text-dark mb-2">ลงทะเบียนแจ้งซ่อมสำเร็จ!</h1>
                <p class="lead text-secondary mb-4">
                    ระบบได้รับข้อมูลการแจ้งซ่อมของท่านเรียบร้อยแล้ว ช่างกำลังเตรียมพร้อมรองรับเครื่องของท่าน
                </p>

                <!-- Ticket Card -->
                <div class="card card-apple p-4 p-md-5 text-start shadow-sm mb-4">
                    <div class="text-center pb-3 border-bottom mb-4">
                        <span class="text-muted small d-block mb-1">รหัสติดตามงานซ่อมของคุณ (Tracking Number)</span>
                        <div class="display-5 fw-bold text-primary brand-font" id="ticketNumberText">
                            {{ $ticket->ticket_number }}
                        </div>
                        <span class="badge bg-warning-subtle text-warning border px-3 py-1 rounded-pill mt-2">
                            สถานะ: รอรับเครื่องเข้าศูนย์บริการ
                        </span>
                    </div>

                    <div class="row g-3 small">
                        <div class="col-sm-6">
                            <span class="text-muted d-block">ชื่อลูกค้า</span>
                            <strong class="text-dark">{{ $ticket->customer->name }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">เบอร์โทรศัพท์</span>
                            <strong class="text-dark">{{ $ticket->customer->phone }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">รุ่น iPhone</span>
                            <strong class="text-dark">{{ $ticket->phoneModel->name }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block">ราคาประเมินเบื้องต้น</span>
                            <strong class="text-primary">฿{{ number_format($ticket->estimated_cost, 2) }}</strong>
                        </div>
                        <div class="col-12">
                            <span class="text-muted d-block">อาการเสีย</span>
                            <span class="text-secondary">{{ $ticket->symptom_description }}</span>
                        </div>
                    </div>

                    <div class="alert alert-info rounded-3 mt-4 mb-0 small">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                        <strong>ขั้นตอนต่อไป:</strong> ท่านสามารถนำเครื่องมาส่งได้ที่ <strong>ศูนย์บริการ iRepair ม.ราชภัฏนครปฐม</strong> หรือส่งพัสดุมาตามที่อยู่ของร้าน โดยแนบเลขรหัส <strong>{{ $ticket->ticket_number }}</strong> มาพร้อมตัวเครื่อง
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('tracking.show', $ticket->ticket_number) }}" class="btn btn-apple px-4 py-2">
                        <i class="bi bi-clock-history me-1"></i> ติดตามสถานะงานซ่อมตอนนี้
                    </a>
                    <a href="{{ route('admin.tickets.print', $ticket->id) }}" target="_blank" class="btn btn-outline-dark rounded-pill px-4 py-2">
                        <i class="bi bi-printer me-1"></i> พิมพ์ใบรับซ่อม
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-link text-muted text-decoration-none">
                        กลับสู่หน้าแรก
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
