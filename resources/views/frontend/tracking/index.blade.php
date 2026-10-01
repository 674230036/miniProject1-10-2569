@extends('layouts.app')

@section('title', 'ตรวจสอบสถานะงานซ่อมไอโฟน - iRepair NPRU')

@section('content')
<div class="py-5 bg-light">
    <div class="container py-lg-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 mb-2">
                    <i class="bi bi-clock-history me-1"></i> Live Tracking System
                </span>
                <h1 class="display-6 fw-bold mb-3">ติดตามสถานะงานซ่อม iPhone ของคุณ</h1>
                <p class="text-muted mb-4">
                    ตรวจสอบขั้นตอนการปฏิบัติงานของช่างแบบเรียลไทม์ ด้วยเลขที่ใบรับซ่อม หรือเบอร์โทรศัพท์ที่ใช้ลงทะเบียน
                </p>

                <!-- Search Card -->
                <div class="card card-apple p-4 p-md-5 text-start shadow-sm mb-4">
                    <form action="{{ route('tracking.search') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">กรอกเลขที่ใบรับซ่อม หรือ เบอร์โทรศัพท์ลูกค้า</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light text-muted border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="keyword" class="form-control border-start-0 ps-0" 
                                       placeholder="ตัวอย่าง: REP-202610-001 หรือ 081-234-5678" 
                                       value="{{ old('keyword', request('keyword')) }}" required autofocus>
                                <button class="btn btn-primary px-4 fw-medium" type="submit">
                                    <i class="bi bi-crosshair me-1"></i> ค้นหา
                                </button>
                            </div>
                            <div class="form-text mt-2 text-muted">
                                <i class="bi bi-info-circle me-1"></i> เลขที่ใบรับซ่อมจะระบุอยู่ในใบรับเครื่องที่ช่างออกให้ หรือในหน้าจอยืนยันการแจ้งซ่อมออนไลน์
                            </div>
                        </div>
                    </form>

                    <div class="pt-3 border-top mt-3">
                        <h6 class="text-secondary small fw-bold mb-2">คลิกเพื่อทดสอบงานซ่อมตัวอย่างในระบบ:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($sampleTickets as $sample)
                            <a href="{{ route('tracking.show', $sample->ticket_number) }}" class="btn btn-light btn-sm border rounded-pill text-dark text-start">
                                <strong class="text-primary">{{ $sample->ticket_number }}</strong>
                                <span class="text-muted ms-1">({{ $sample->phoneModel->name }} - {{ $sample->status_thai }})</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="card p-3 border-0 bg-white rounded-4 shadow-sm text-start">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle fs-4">
                                <i class="bi bi-question-circle"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold mb-1">ไม่พบข้อมูล หรือจำเลขที่ใบรับซ่อมไม่ได้?</h6>
                            <p class="text-muted small mb-0">
                                ท่านสามารถติดต่อสอบถามโดยตรงกับเจ้าหน้าที่ช่างได้ที่เบอร์ Hotline: <strong>089-123-4567</strong> หรือ LINE: <strong>@irepair_npru</strong> โดยแจ้งชื่อ-นามสกุลของท่าน
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
