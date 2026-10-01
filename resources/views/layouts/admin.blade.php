<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ระบบจัดการงานซ่อมหลังบ้าน (Back-end) - iRepair NPRU')</title>
    
    <!-- Google Fonts: Prompt & Kanit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --admin-dark: #0f172a;
            --admin-blue: #2563eb;
            --font-main: 'Prompt', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-head: 'Kanit', sans-serif;
        }

        body {
            font-family: var(--font-main);
            background-color: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: var(--font-head);
            font-weight: 600;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: #0f172a;
            color: #e2e8f0;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: all 0.3s;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            text-decoration: none;
        }

        .sidebar-nav {
            list-style: none;
            padding: 1rem 0.75rem;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            padding: 0.75rem 0.75rem 0.25rem;
            font-weight: 600;
        }

        .nav-item-admin {
            margin-bottom: 4px;
        }

        .nav-link-admin {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.65rem 0.85rem;
            color: #94a3b8;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link-admin i {
            font-size: 1.15rem;
        }

        .nav-link-admin:hover {
            color: #ffffff;
            background: rgba(255,255,255,0.06);
        }

        .nav-link-admin.active {
            color: #ffffff;
            background: var(--admin-blue);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        /* Main Content Layout */
        .admin-main {
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Topbar */
        .admin-topbar {
            background: #ffffff;
            height: 68px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            position: sticky;
            top: 0;
            z-index: 990;
        }

        .admin-content {
            padding: 1.75rem;
            flex-grow: 1;
        }

        /* Cards */
        .card-custom {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-custom-header {
            padding: 1.1rem 1.4rem;
            border-bottom: 1px solid #f1f5f9;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            font-size: 0.82rem;
            font-weight: 500;
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            .sidebar.show {
                margin-left: 0;
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Admin Sidebar (036 Back-end System) -->
    <aside class="sidebar" id="adminSidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded p-1 px-2">
                <i class="bi bi-apple"></i>
            </span>
            <div>
                <strong class="fs-5 d-block leading-tight">iRepair Admin</strong>
                <span class="text-xs text-primary" style="font-size: 0.75rem;">ผู้รับผิดชอบหลังบ้าน: รหัส 036</span>
            </div>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-heading">ภาพรวมระบบ</li>
            <li class="nav-item-admin">
                <a href="{{ route('admin.dashboard') }}" class="nav-link-admin {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>แดชบอร์ดสรุปงาน</span>
                </a>
            </li>

            <li class="sidebar-heading">จัดการงานซ่อมไอโฟน</li>
            <li class="nav-item-admin">
                <a href="{{ route('admin.tickets.index') }}" class="nav-link-admin {{ request()->routeIs('admin.tickets.index') || request()->routeIs('admin.tickets.show') || request()->routeIs('admin.tickets.edit') ? 'active' : '' }}">
                    <i class="bi bi-tools"></i>
                    <span>รายการใบแจ้งซ่อม</span>
                </a>
            </li>
            <li class="nav-item-admin">
                <a href="{{ route('admin.tickets.create') }}" class="nav-link-admin {{ request()->routeIs('admin.tickets.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle-fill text-warning"></i>
                    <span>เปิดใบแจ้งซ่อม (หน้าร้าน)</span>
                </a>
            </li>
            <li class="nav-item-admin">
                <a href="{{ route('admin.customers.index') }}" class="nav-link-admin {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>ฐานข้อมูลลูกค้า</span>
                </a>
            </li>

            <li class="sidebar-heading">ข้อมูลเครื่องและบริการ</li>
            <li class="nav-item-admin">
                <a href="{{ route('admin.models.index') }}" class="nav-link-admin {{ request()->routeIs('admin.models.*') ? 'active' : '' }}">
                    <i class="bi bi-phone"></i>
                    <span>รุ่น iPhone และราคา</span>
                </a>
            </li>
            <li class="nav-item-admin">
                <a href="{{ route('admin.services.index') }}" class="nav-link-admin {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="bi bi-wrench-adjustable-circle"></i>
                    <span>ประเภทบริการซ่อม</span>
                </a>
            </li>

            <li class="sidebar-heading">อื่นๆ</li>
            <li class="nav-item-admin">
                <a href="{{ route('home') }}" target="_blank" class="nav-link-admin text-info">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>เปิดหน้าบ้าน (008)</span>
                </a>
            </li>
            <li class="nav-item-admin">
                <a href="{{ route('about') }}" target="_blank" class="nav-link-admin text-secondary">
                    <i class="bi bi-info-circle"></i>
                    <span>ข้อมูลผู้จัดทำโครงงาน</span>
                </a>
            </li>
        </ul>

        <!-- Bottom User Card -->
        <div class="p-3 m-3 rounded-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-weight: 600;">
                    036
                </div>
                <div class="overflow-hidden">
                    <strong class="d-block text-white text-truncate text-sm" style="font-size: 0.88rem;">{{ Auth::user()->name }}</strong>
                    <span class="badge bg-success text-xs" style="font-size: 0.7rem;">{{ Auth::user()->role === 'admin' ? 'ผู้ดูแลระบบหลัก' : 'ช่างซ่อม' }}</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-pill py-1 text-xs" style="font-size: 0.8rem;">
                    <i class="bi bi-box-arrow-right me-1"></i> ออกจากระบบ
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
        <!-- Topbar -->
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light d-lg-none" type="button" onclick="document.getElementById('adminSidebar').classList.toggle('show')">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="d-none d-sm-block">
                    <span class="text-muted small">ระบบบริหารจัดการงานซ่อม iPhone (NPRU IT Project)</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-plus-lg me-1"></i> เปิดใบรับซ่อมใหม่
                </a>
                <div class="vr"></div>
                <span class="small text-muted d-none d-md-inline">
                    เข้าสู่ระบบโดย: <strong>{{ Auth::user()->name }}</strong> (รหัส {{ Auth::user()->student_id ?? '036' }})
                </span>
            </div>
        </header>

        <!-- Flash Notifications -->
        <div class="container-fluid px-4 pt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center mb-0" role="alert">
                    <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center mb-0" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-0" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-circle-fill me-1"></i> พบข้อผิดพลาดในการกรอกข้อมูล:</div>
                    <ul class="mb-0 ps-3 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Dynamic Content Body -->
        <div class="admin-content">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="bg-white border-top py-3 px-4 text-muted small d-flex justify-content-between">
            <div>
                <strong>ระบบจัดการงานซ่อม iPhone (iRepair Studio)</strong> &bull; มหาวิทยาลัยราชภัฏนครปฐม
            </div>
            <div>
                พัฒนาโดย <strong>นายธีรเดช วงศ์สว่าง (036)</strong> & <strong>นายภูมิพัฒน์ เกษมสุข (008)</strong>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
