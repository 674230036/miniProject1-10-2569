@extends('layouts.app')

@section('title', 'iRepair NPRU - ศูนย์ซ่อมและบริการตรวจเช็ค iPhone มาตรฐาน ม.ราชภัฏนครปฐม')

@section('content')
<!-- Hero Section -->
<section class="position-relative overflow-hidden pt-5 pb-5" style="background: radial-gradient(circle at 80% 20%, rgba(37,99,235,0.08) 0%, rgba(248,250,252,1) 70%);">
    <div class="container py-lg-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white border shadow-sm mb-3">
                    <span class="badge bg-danger rounded-pill px-2">ด่วน</span>
                    <span class="small fw-semibold text-secondary">รับซ่อมไอโฟนทุกอาการ ตรวจเช็คฟรีไม่มีค่าเปิดเครื่อง</span>
                </div>
                
                <h1 class="display-4 fw-bold text-dark mb-3" style="line-height: 1.15; letter-spacing: -0.02em;">
                    ศูนย์ซ่อมและฟื้นฟู <span class="text-primary">iPhone</span> มืออาชีพ มาตรฐานงานแท้
                </h1>
                
                <p class="lead text-secondary mb-4" style="font-size: 1.15rem; line-height: 1.6;">
                    บริการเปลี่ยนจอแท้ OLED, เปลี่ยนแบตเตอรี่ มอก., ซ่อมเมนบอร์ดดับเปิดไม่ติด, แก้ไข Face ID และล้างเครื่องตกน้ำ พร้อมระบบติดตามงานซ่อมแบบเรียลไทม์ ประกันสูงสุด 180 วัน
                </p>

                <!-- Quick Tracking Search Box -->
                <div class="card p-2 p-md-3 border-0 shadow-lg rounded-4 mb-4 bg-white">
                    <form action="{{ route('tracking.search') }}" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-8 col-12">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                    <i class="bi bi-search fs-5"></i>
                                </span>
                                <input type="text" name="keyword" class="form-control border-0 shadow-none ps-2" 
                                       placeholder="กรอกเลขที่ใบรับซ่อม (เช่น REP-202610-001) หรือ เบอร์โทรศัพท์" 
                                       required style="font-size: 0.98rem;">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <button type="submit" class="btn btn-apple w-100 py-2">
                                <i class="bi bi-crosshair me-1"></i> ติดตามงานซ่อม
                            </button>
                        </div>
                    </form>
                    <div class="mt-2 px-3 d-flex flex-wrap align-items-center gap-2 small text-muted">
                        <span><i class="bi bi-lightning-fill text-warning"></i> ลองค้นหาตัวอย่าง:</span>
                        <a href="{{ route('tracking.show', 'REP-202610-001') }}" class="badge bg-light text-dark text-decoration-none border">REP-202610-001</a>
                        <a href="{{ route('tracking.show', 'REP-202610-002') }}" class="badge bg-light text-dark text-decoration-none border">REP-202610-002</a>
                        <a href="{{ route('tracking.search', ['keyword' => '081-234-5678']) }}" class="badge bg-light text-dark text-decoration-none border">081-234-5678</a>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('booking.create') }}" class="btn btn-dark rounded-pill px-4 py-2">
                        <i class="bi bi-calendar2-check me-1"></i> นัดหมายแจ้งซ่อมล่วงหน้า
                    </a>
                    <a href="{{ route('price.estimator') }}" class="btn btn-apple-outline px-4 py-2">
                        <i class="bi bi-calculator me-1"></i> ประเมินราคาออนไลน์
                    </a>
                </div>
            </div>

            <div class="col-lg-5 text-center">
                <div class="position-relative d-inline-block">
                    <!-- Real iPhone Showcase Image -->
                    <div class="card-apple p-2 shadow-2-strong" style="max-width: 440px; margin: 0 auto; background: #ffffff;">
                        <img src="{{ asset('images/iphone-showcase.jpg') }}" alt="iPhone Repair Showcase" class="img-fluid rounded-4">
                        <div class="p-3 text-start bg-light rounded-3 mt-2 border">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="text-dark small"><i class="bi bi-shield-check text-success me-1"></i> มาตรฐานงานซ่อม NPRU</strong>
                                <span class="badge bg-success-subtle text-success small">พร้อมรับประกัน</span>
                            </div>
                            <p class="text-muted small mb-0">
                                ใช้เครื่องมือตรวจเช็ควิเคราะห์ระดับบอร์ด และเครื่องเลเซอร์ลอกฝาหลังมาตรฐานโรงงาน
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Counters -->
<section class="py-4 bg-white border-top border-bottom">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6">
                <div class="p-2">
                    <h3 class="fw-bold text-primary mb-1">{{ number_format($stats['total_repaired']) }}+</h3>
                    <p class="text-muted small mb-0">เครื่องที่ซ่อมสำเร็จและส่งมอบ</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2">
                    <h3 class="fw-bold text-success mb-1">{{ $stats['warranty_days'] }}</h3>
                    <p class="text-muted small mb-0">การรับประกันงานซ่อมสูงสุด</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2">
                    <h3 class="fw-bold text-warning mb-1">0 บาท</h3>
                    <p class="text-muted small mb-0">ค่าตรวจเช็คและประเมินราคาฟรี</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-2">
                    <h3 class="fw-bold text-dark mb-1">{{ $stats['satisfaction_rate'] }}</h3>
                    <p class="text-muted small mb-0">คะแนนความพึงพอใจของลูกค้า</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Services Section -->
<section class="py-5 bg-light">
    <div class="container py-3">
        <div class="text-center max-w-2xl mx-auto mb-5">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 mb-2">บริการมาตรฐานระดับสากล</span>
            <h2 class="display-6 fw-bold">อาการเสียยอดนิยมที่เราเชี่ยวชาญ</h2>
            <p class="text-muted">ใช้อะไหล่เกรดแท้ตรงรุ่น ช่างมีประสบการณ์ ตรวจเช็คเครื่องก่อนและหลังซ่อมอย่างละเอียด</p>
        </div>

        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-lg-4 col-md-6">
                <div class="card card-apple h-100 p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-4 p-3 fs-3">
                                <i class="bi {{ $service->icon }}"></i>
                            </span>
                            <span class="badge bg-light text-dark border rounded-pill px-3 py-1">
                                <i class="bi bi-clock me-1 text-primary"></i> {{ $service->estimated_duration }}
                            </span>
                        </div>
                        <h4 class="h5 fw-bold mb-2 text-dark">{{ $service->name }}</h4>
                        <p class="text-muted small mb-3">{{ $service->description }}</p>
                    </div>

                    <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-xs d-block" style="font-size: 0.78rem;">เริ่มต้นที่</span>
                            <strong class="fs-5 text-primary">฿{{ number_format($service->base_price) }}</strong>
                        </div>
                        <a href="{{ route('booking.create') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            แจ้งซ่อมอาการนี้
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('services') }}" class="btn btn-outline-dark rounded-pill px-4">
                ดูบริการและอะไหล่ทั้งหมด <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- Workshop / Technician Banner -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="card border-0 rounded-4 overflow-hidden shadow-sm" style="background: #0f172a; color: #ffffff;">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6 p-4 p-md-5">
                    <span class="badge bg-primary px-3 py-1 rounded-pill mb-3">ห้องปฏิบัติการมาตรฐาน</span>
                    <h2 class="display-6 fw-bold mb-3 text-white">เครื่องมือช่างระดับ Micro-Soldering วิเคราะห์ตรงจุด</h2>
                    <p class="text-slate-300 mb-4" style="color: #cbd5e1; line-height: 1.7;">
                        เราใช้กล้องส่องความร้อนอินฟราเรดตรวจหาจุดช็อตบนบอร์ดไอโฟน และเครื่องมือโปรแกรมชิปแท้ TrueTone & Face ID ทำให้ข้อมูลในเครื่องไม่สูญหาย มั่นใจในความปลอดภัย 100%
                    </p>
                    <div class="row g-3 text-start mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                <span class="small">ย้ายขั้วแบตเดิม ไม่ฟ้องเตือน</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                <span class="small">ระบบลอกกระจกแท้ OCA สูญญากาศ</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                <span class="small">ยิงเลเซอร์เปลี่ยนฝาหลัง ไม่แกะเครื่อง</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                <span class="small">ออกใบรับประกันงานซ่อมทุกรายการ</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('booking.create') }}" class="btn btn-primary rounded-pill px-4 py-2">
                        ส่งเครื่องให้ช่างตรวจเช็ค <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/hero-repair.jpg') }}" alt="ช่างซ่อมไอโฟนมืออาชีพ" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 380px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Supported iPhone Models Grid -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-dark rounded-pill px-3 py-1 mb-2">รองรับทุกรุ่นยอดนิยม</span>
                <h3 class="fw-bold mb-1">รุ่น iPhone ที่พร้อมให้บริการและมีอะไหล่ทันที</h3>
                <p class="text-muted small mb-0">มีอะไหล่พร้อมเปลี่ยนหน้าร้าน ไม่ต้องรอนาน</p>
            </div>
            <a href="{{ route('price.estimator') }}" class="btn btn-link text-primary text-decoration-none fw-semibold">
                ดูราคาทุกรุ่น <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <div class="row g-3">
            @foreach($models as $model)
            <div class="col-lg-3 col-md-4 col-6">
                <div class="card card-apple p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-light text-dark border">{{ $model->series }}</span>
                        <span class="small text-muted">{{ $model->release_year }}</span>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $model->name }}</h5>
                    <p class="text-muted text-xs mb-2" style="font-size: 0.8rem;">{{ $model->screen_size }}</p>
                    <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center small">
                        <span class="text-muted">จอแท้เริ่ม</span>
                        <strong class="text-primary">฿{{ number_format($model->base_screen_price) }}</strong>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Live Completed Repairs Ticker -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-4">
            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 mb-2">
                <i class="bi bi-broadcast me-1"></i> อัปเดตงานซ่อมสด
            </span>
            <h3 class="fw-bold">งานซ่อมล่าสุดที่ดำเนินการโดยช่างผู้เชี่ยวชาญ</h3>
        </div>

        <div class="row g-3">
            @foreach($recentRepairs as $recent)
            <div class="col-md-6 col-lg-4">
                <div class="card p-3 border rounded-3 bg-light h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-dark">{{ $recent->ticket_number }}</span>
                        <span class="status-pill badge-{{ $recent->status }}">
                            {{ $recent->status_thai }}
                        </span>
                    </div>
                    <div class="fw-bold text-dark mb-1">{{ $recent->phoneModel->name }} ({{ $recent->device_color }})</div>
                    <p class="text-muted small mb-2 text-truncate">{{ $recent->symptom_description }}</p>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top small text-muted">
                        <span><i class="bi bi-clock me-1"></i> {{ $recent->updated_at->diffForHumans() }}</span>
                        <a href="{{ route('tracking.show', $recent->ticket_number) }}" class="text-primary text-decoration-none">
                            ดูรายละเอียด <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Student Project Banner -->
<section class="py-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #ffffff;">
    <div class="container text-center py-2">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-info text-dark">โครงงาน Final Project ภาคเรียนที่ 1</span>
                    <span class="text-slate-300 small">สาขาวิชาเทคโนโลยีสารสนเทศ มหาวิทยาลัยราชภัฏนครปฐม</span>
                </div>
                <h4 class="fw-bold mb-2">พัฒนาโดยทีมนักศึกษา เพื่อการใช้งานในศูนย์บริการจริง</h4>
                <p class="text-slate-400 small mb-3" style="color: #94a3b8;">
                    <strong>นายภูมิพัฒน์ เกษมสุข (รหัสนักศึกษา 654230008)</strong> รับผิดชอบระบบหน้าบ้าน (Front-end & UI/UX)<br>
                    <strong>นายธีรเดช วงศ์สว่าง (รหัสนักศึกษา 654230036)</strong> รับผิดชอบระบบหลังบ้าน (Back-end & Database)
                </p>
                <a href="{{ route('about') }}" class="btn btn-outline-light btn-sm rounded-pill px-4">
                    อ่านข้อมูลโครงงานและสมาชิกผู้จัดทำ <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
