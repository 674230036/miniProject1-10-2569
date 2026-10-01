@extends('layouts.app')

@section('title', 'คณะผู้จัดทำโครงงาน - iRepair NPRU')

@section('content')
<div class="py-5 bg-light">
    <div class="container py-lg-4">
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-5">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 mb-2">
                <i class="bi bi-mortarboard-fill me-1"></i> Final Project โครงงานเทคโนโลยีสารสนเทศ
            </span>
            <h1 class="display-6 fw-bold">ข้อมูลโครงงานและคณะผู้จัดทำ</h1>
            <p class="text-secondary lead" style="font-size: 1.1rem;">
                ระบบสารสนเทศเพื่อการบริหารจัดการและติดตามงานแจ้งซ่อมโทรศัพท์เคลื่อนที่ไอโฟน (iRepair NPRU)
            </p>
            <p class="text-muted small">
                สาขาวิชาเทคโนโลยีสารสนเทศ &bull; คณะวิทยาศาสตร์และเทคโนโลยี &bull; มหาวิทยาลัยราชภัฏนครปฐม
            </p>
        </div>

        <!-- Student Profiles -->
        <div class="row g-4 justify-content-center mb-5">
            <!-- Student 008 (Front-end) -->
            <div class="col-lg-5 col-md-6">
                <div class="card card-apple p-4 h-100 text-center border-0 shadow-sm">
                    <div class="position-relative d-inline-block mx-auto mb-3">
                        <img src="{{ asset('images/students/student-008.jpg') }}" alt="นายภูมิพัฒน์ เกษมสุข" 
                             class="rounded-circle shadow" style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #ffffff;">
                        <span class="badge bg-primary position-absolute bottom-0 end-0 px-2 py-1 rounded-pill shadow-sm">
                            รหัส 008
                        </span>
                    </div>

                    <h4 class="fw-bold text-dark mb-1">นายภูมิพัฒน์ เกษมสุข</h4>
                    <p class="text-muted small mb-2">รหัสนักศึกษา: <strong>654230008</strong></p>
                    <div class="d-inline-block px-3 py-1 bg-primary bg-opacity-10 text-primary rounded-pill small fw-semibold mb-3">
                        หน้าที่: Front-end Developer & UI/UX Design (หน้าบ้าน)
                    </div>

                    <div class="text-start p-3 bg-light rounded-3 small">
                        <strong class="d-block text-dark mb-2"><i class="bi bi-code-slash text-primary me-1"></i> ขอบเขตงานที่รับผิดชอบ:</strong>
                        <ul class="mb-0 ps-3 text-secondary">
                            <li>ออกแบบหน้าแรก (Home UI) และแบนเนอร์แสดงโปรโมชั่นซ่อมไอโฟน</li>
                            <li>พัฒนาระบบเช็คสถานะงานซ่อมแบบเรียลไทม์ (Live Tracking Timeline)</li>
                            <li>พัฒนาแบบฟอร์มลงทะเบียนแจ้งซ่อมออนไลน์ (Online Booking)</li>
                            <li>พัฒนาระบบคำนวณและประเมินราคาซ่อมเบื้องต้น (Price Calculator)</li>
                            <li>จัดวางเลย์เอาต์แบบ Responsive รองรับสมาร์ตโฟนและแท็บเล็ต</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Student 036 (Back-end) -->
            <div class="col-lg-5 col-md-6">
                <div class="card card-apple p-4 h-100 text-center border-0 shadow-sm">
                    <div class="position-relative d-inline-block mx-auto mb-3">
                        <img src="{{ asset('images/students/student-036.jpg') }}" alt="นายธีรเดช วงศ์สว่าง" 
                             class="rounded-circle shadow" style="width: 140px; height: 140px; object-fit: cover; border: 4px solid #ffffff;">
                        <span class="badge bg-warning text-dark position-absolute bottom-0 end-0 px-2 py-1 rounded-pill shadow-sm">
                            รหัส 036
                        </span>
                    </div>

                    <h4 class="fw-bold text-dark mb-1">นายธีรเดช วงศ์สว่าง</h4>
                    <p class="text-muted small mb-2">รหัสนักศึกษา: <strong>654230036</strong></p>
                    <div class="d-inline-block px-3 py-1 bg-warning bg-opacity-10 text-dark rounded-pill small fw-semibold mb-3">
                        หน้าที่: Back-end Developer & Database (หลังบ้าน)
                    </div>

                    <div class="text-start p-3 bg-light rounded-3 small">
                        <strong class="d-block text-dark mb-2"><i class="bi bi-database-check text-warning me-1"></i> ขอบเขตงานที่รับผิดชอบ:</strong>
                        <ul class="mb-0 ps-3 text-secondary">
                            <li>ออกแบบฐานข้อมูลเชิงสัมพันธ์ (Database Schema & Seeders)</li>
                            <li>พัฒนาระบบจัดการใบแจ้งซ่อมหลังบ้าน (Admin CRUD Repair Tickets)</li>
                            <li>พัฒนาระบบอัปเดตสถานะและบันทึกประวัติช่าง (Status Logs Timeline)</li>
                            <li>พัฒนาระบบเข้าสู่ระบบและรักษาความปลอดภัย (Authentication Guard)</li>
                            <li>พัฒนาระบบพิมพ์ใบรับเครื่องซ่อมและใบเสร็จ (Printable Repair Slip)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Objectives & Tech Stack -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card card-apple p-4 h-100">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-bullseye text-danger me-2"></i>วัตถุประสงค์ของโครงงาน
                    </h5>
                    <ol class="small text-secondary ps-3 mb-0" style="line-height: 1.8;">
                        <li class="mb-2">เพื่อพัฒนาระบบสารสนเทศที่ช่วยลดข้อผิดพลาดในการรับเครื่องและติดตามงานซ่อมไอโฟนของศูนย์บริการ</li>
                        <li class="mb-2">เพื่ออำนวยความสะดวกให้ลูกค้าสามารถตรวจสอบสถานะการซ่อมได้ด้วยตนเองตลอด 24 ชั่วโมง โดยไม่ต้องโทรสอบถาม</li>
                        <li class="mb-2">เพื่อจัดเก็บประวัติการซ่อม ข้อมูลช่างผู้รับผิดชอบ และเงื่อนไขการรับประกันสินค้าอย่างเป็นระบบ</li>
                        <li class="mb-0">เพื่อประยุกต์ใช้ความรู้ด้านการพัฒนาเว็บแอปพลิเคชันด้วย Framework สมัยใหม่ (Laravel) และการบริหารจัดการฐานข้อมูล</li>
                    </ol>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-apple p-4 h-100">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-cpu text-primary me-2"></i>เทคโนโลยีที่เลือกใช้ในการพัฒนา
                    </h5>
                    <div class="row g-2 small">
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light">
                                <strong class="d-block text-dark"><i class="bi bi-layers-fill text-danger me-1"></i> Backend</strong>
                                <span class="text-muted">Laravel 12 / PHP 8.2</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light">
                                <strong class="d-block text-dark"><i class="bi bi-database text-info me-1"></i> Database</strong>
                                <span class="text-muted">SQLite / MySQL Support</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light">
                                <strong class="d-block text-dark"><i class="bi bi-bootstrap-fill text-primary me-1"></i> UI & Styling</strong>
                                <span class="text-muted">Bootstrap 5.3 / Apple CSS</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light">
                                <strong class="d-block text-dark"><i class="bi bi-palette-fill text-warning me-1"></i> Icons & Font</strong>
                                <span class="text-muted">Bootstrap Icons / Prompt Font</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                        <span class="small text-muted">เข้าสู่ระบบจัดการหลังบ้าน:</span>
                        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                            <i class="bi bi-shield-lock me-1"></i> ล็อกอินหลังบ้าน (036)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
