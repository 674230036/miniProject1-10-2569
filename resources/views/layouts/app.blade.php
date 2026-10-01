<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'iRepair NPRU - ศูนย์ซ่อมและบริการตรวจเช็คไอโฟนมาตรฐาน')</title>
    
    <!-- Google Fonts: Prompt & Kanit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --apple-dark: #1d1d1f;
            --apple-gray: #f5f5f7;
            --apple-blue: #0071e3;
            --apple-blue-hover: #0077ed;
            --apple-card-border: rgba(0, 0, 0, 0.08);
            --font-main: 'Prompt', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-head: 'Kanit', sans-serif;
        }

        body {
            font-family: var(--font-main);
            background-color: #fbfbfd;
            color: #1d1d1f;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: var(--font-head);
            font-weight: 600;
        }

        /* Top Student Info Banner */
        .project-badge-bar {
            background: linear-gradient(90deg, #1e293b 0%, #0f172a 100%);
            color: #94a3b8;
            font-size: 0.82rem;
            padding: 6px 0;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .project-badge-bar a {
            color: #38bdf8;
            text-decoration: none;
            transition: all 0.2s;
        }

        .project-badge-bar a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        /* Navbar */
        .navbar-apple {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 1040;
            transition: all 0.3s ease;
        }

        .navbar-apple .navbar-brand {
            font-weight: 700;
            font-size: 1.35rem;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-apple .nav-link {
            font-size: 0.95rem;
            font-weight: 500;
            color: #475569;
            padding: 0.6rem 0.9rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .navbar-apple .nav-link:hover,
        .navbar-apple .nav-link.active {
            color: var(--apple-blue);
            background-color: rgba(0, 113, 227, 0.06);
        }

        /* Buttons */
        .btn-apple {
            background-color: var(--apple-blue);
            color: #ffffff;
            font-weight: 500;
            border-radius: 980px;
            padding: 0.55rem 1.4rem;
            border: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-apple:hover {
            background-color: var(--apple-blue-hover);
            color: #ffffff;
            transform: scale(1.02);
            box-shadow: 0 4px 14px rgba(0, 113, 227, 0.3);
        }

        .btn-apple-outline {
            background-color: transparent;
            color: var(--apple-blue);
            border: 1px solid var(--apple-blue);
            font-weight: 500;
            border-radius: 980px;
            padding: 0.55rem 1.4rem;
            transition: all 0.25s ease;
        }

        .btn-apple-outline:hover {
            background-color: var(--apple-blue);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 113, 227, 0.2);
        }

        /* Cards & Containers */
        .card-apple {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid var(--apple-card-border);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card-apple:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            transform: translateY(-3px);
        }

        /* Footer */
        .footer-apple {
            background: #141b25;
            color: #94a3b8;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 50px 0 24px 0;
            font-size: 0.92rem;
        }

        .footer-apple h5 {
            color: #f8fafc;
            font-size: 1.05rem;
            margin-bottom: 18px;
        }

        .footer-apple a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-apple a:hover {
            color: #38bdf8;
        }

        /* Status Badges */
        .badge-pending { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-inspecting { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .badge-waiting_parts { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        .badge-repairing { background-color: #ede9fe; color: #6d28d9; border: 1px solid #ddd6fe; }
        .badge-completed { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-delivered { background-color: #f3f4f6; color: #111827; border: 1px solid #d1d5db; }
        .badge-cancelled { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

        .status-pill {
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Step Progress Bar */
        .progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 2rem;
        }

        .progress-steps::before {
            content: '';
            position: absolute;
            top: 24px;
            left: 5%;
            right: 5%;
            height: 4px;
            background: #e2e8f0;
            z-index: 1;
        }

        .progress-step-item {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
        }

        .step-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #ffffff;
            border: 3px solid #cbd5e1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            color: #64748b;
            transition: all 0.3s ease;
        }

        .step-active .step-circle {
            border-color: var(--apple-blue);
            background: var(--apple-blue);
            color: #ffffff;
            box-shadow: 0 0 0 5px rgba(0, 113, 227, 0.2);
        }

        .step-done .step-circle {
            border-color: #10b981;
            background: #10b981;
            color: #ffffff;
        }

        .step-title {
            font-size: 0.85rem;
            margin-top: 8px;
            color: #64748b;
            font-weight: 500;
        }

        .step-active .step-title,
        .step-done .step-title {
            color: #0f172a;
            font-weight: 600;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Student & Course Banner -->
    <div class="project-badge-bar">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <span class="badge bg-primary me-2 px-2">โครงงานไอที</span>
                <strong>ระบบจัดการและติดตามงานแจ้งซ่อมไอโฟน (iRepair Studio)</strong>
                <span class="d-none d-md-inline ms-2">| มหาวิทยาลัยราชภัฏนครปฐม (NPRU)</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-person-fill text-info"></i> หน้าบ้าน: <strong>008</strong></span>
                <span><i class="bi bi-gear-fill text-warning"></i> หลังบ้าน: <strong>036</strong></span>
                <a href="{{ route('about') }}" class="ms-1"><i class="bi bi-info-circle"></i> ดูผู้จัดทำ</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-apple">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="d-inline-flex align-items-center justify-content-center bg-dark text-white rounded-3 p-1 px-2" style="font-size: 1.15rem;">
                    <i class="bi bi-apple"></i>
                </span>
                <span>iRepair<span class="text-primary">.NPRU</span></span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i> หน้าแรก
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tracking.*') ? 'active' : '' }}" href="{{ route('tracking.index') }}">
                            <i class="bi bi-search me-1"></i> เช็คสถานะงานซ่อม
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">
                            <i class="bi bi-tools me-1"></i> บริการซ่อมและราคา
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('price.estimator') ? 'active' : '' }}" href="{{ route('price.estimator') }}">
                            <i class="bi bi-calculator me-1"></i> ประเมินราคาซ่อม
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                            <i class="bi bi-people me-1"></i> คณะผู้จัดทำ
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('booking.create') }}" class="btn btn-apple">
                        <i class="bi bi-plus-circle me-1"></i> แจ้งซ่อมออนไลน์
                    </a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                            <i class="bi bi-speedometer2 me-1"></i> หลังบ้าน ({{ Auth::user()->student_id ? 'รหัส ' . Auth::user()->student_id : 'Staff' }})
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3" title="สำหรับผู้ดูแลระบบและช่าง">
                            <i class="bi bi-lock-fill me-1"></i> เข้าระบบ (036)
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle-fill fs-5 me-2 text-warning"></i>
                <div>{{ session('warning') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-apple">
        <div class="container">
            <div class="row g-4 pb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="bg-primary text-white rounded p-1 px-2"><i class="bi bi-apple fs-5"></i></span>
                        <h4 class="text-white mb-0">iRepair Store NPRU</h4>
                    </div>
                    <p class="text-muted small">
                        ศูนย์ซ่อมและฟื้นฟูสมรรถนะ iPhone ครบวงจร อะไหล่แท้มาตรฐาน มีใบรับประกันงานซ่อมสูงสุด 180 วัน เครื่องมือวิเคราะห์ข้อผิดพลาดระดับชิปเซ็ตทันสมัย
                    </p>
                    <div class="text-muted small">
                        <p class="mb-1"><i class="bi bi-geo-alt-fill text-danger me-2"></i> ศูนย์บริการหน้าร้าน ม.ราชภัฏนครปฐม ถ.มาลัยแมน ต.นครปฐม จ.นครปฐม</p>
                        <p class="mb-1"><i class="bi bi-telephone-fill text-success me-2"></i> Hotline: 089-123-4567, 081-987-6543</p>
                        <p class="mb-0"><i class="bi bi-clock-fill text-info me-2"></i> เปิดบริการทุกวัน: 09:00 - 20:00 น.</p>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <h5>เมนูด่วน</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}"><i class="bi bi-chevron-right me-1"></i> หน้าแรก</a></li>
                        <li class="mb-2"><a href="{{ route('tracking.index') }}"><i class="bi bi-chevron-right me-1"></i> เช็คสถานะซ่อม</a></li>
                        <li class="mb-2"><a href="{{ route('services') }}"><i class="bi bi-chevron-right me-1"></i> บริการและราคา</a></li>
                        <li class="mb-2"><a href="{{ route('price.estimator') }}"><i class="bi bi-chevron-right me-1"></i> คำนวณค่าซ่อม</a></li>
                        <li class="mb-2"><a href="{{ route('booking.create') }}"><i class="bi bi-chevron-right me-1"></i> แจ้งซ่อมออนไลน์</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-3 col-6">
                    <h5>บริการยอดนิยม</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('services') }}"><i class="bi bi-dot"></i> เปลี่ยนจอแท้ iPhone OLED</a></li>
                        <li class="mb-2"><a href="{{ route('services') }}"><i class="bi bi-dot"></i> เปลี่ยนแบตแท้ มอก. 100%</a></li>
                        <li class="mb-2"><a href="{{ route('services') }}"><i class="bi bi-dot"></i> ซ่อมเมนบอร์ด เปิดไม่ติด</a></li>
                        <li class="mb-2"><a href="{{ route('services') }}"><i class="bi bi-dot"></i> ซ่อม Face ID / กล้องหน้า</a></li>
                        <li class="mb-2"><a href="{{ route('services') }}"><i class="bi bi-dot"></i> เปลี่ยนฝาหลังเลเซอร์</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12">
                    <h5>โครงงานนักศึกษา</h5>
                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <p class="small text-light mb-2"><strong>วิชาโครงงานเทคโนโลยีสารสนเทศ</strong></p>
                        <p class="small text-muted mb-1">
                            <span class="badge bg-secondary me-1">008</span> นายภูมิพัฒน์ เกษมสุข (Front-end)
                        </p>
                        <p class="small text-muted mb-2">
                            <span class="badge bg-secondary me-1">036</span> นายธีรเดช วงศ์สว่าง (Back-end)
                        </p>
                        <p class="small text-info mb-0">มหาวิทยาลัยราชภัฏนครปฐม</p>
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.1);">

            <div class="d-flex flex-wrap justify-content-between align-items-center small text-muted py-2">
                <div>
                    &copy; 2026 iRepair NPRU. พัฒนาขึ้นเพื่อการศึกษาและการบริการจริง | Laravel 12 & Bootstrap 5
                </div>
                <div>
                    <a href="{{ route('login') }}" class="text-muted"><i class="bi bi-shield-lock"></i> เข้าสู่ระบบเจ้าหน้าที่ (036)</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
