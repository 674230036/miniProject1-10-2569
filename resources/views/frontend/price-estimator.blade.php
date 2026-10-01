@extends('layouts.app')

@section('title', 'คำนวณและประเมินราคาซ่อม iPhone - iRepair NPRU')

@section('content')
<div class="py-5 bg-light">
    <div class="container py-lg-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="text-center mb-5">
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 mb-2">
                        <i class="bi bi-calculator me-1"></i> Interactive Price Calculator
                    </span>
                    <h1 class="display-6 fw-bold">ประเมินราคาค่าซ่อม iPhone เบื้องต้น</h1>
                    <p class="text-muted">
                        เลือกรุ่น iPhone และอาการเสียเพื่อตรวจสอบราคาประเมินเบื้องต้น พร้อมระยะเวลาการซ่อมและประกัน
                    </p>
                </div>

                <div class="row g-4">
                    <!-- Calculator Inputs -->
                    <div class="col-lg-7">
                        <div class="card card-apple p-4 p-md-5 h-100">
                            <h5 class="fw-bold text-dark border-bottom pb-3 mb-4">
                                <i class="bi bi-sliders text-primary me-2"></i>เลือกรุ่นและอาการเสีย
                            </h5>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">1. เลือกรุ่น iPhone ของคุณ</label>
                                <select id="modelSelect" class="form-select form-select-lg">
                                    <option value="" disabled selected>-- เลือกรุ่น iPhone --</option>
                                    @foreach($models as $model)
                                        <option value="{{ $model->id }}" 
                                                data-name="{{ $model->name }}"
                                                data-screen="{{ $model->base_screen_price }}"
                                                data-battery="{{ $model->base_battery_price }}">
                                            {{ $model->name }} ({{ $model->series }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">2. เลือกอาการเสีย / ชิ้นส่วนที่ต้องการซ่อม</label>
                                <select id="serviceSelect" class="form-select form-select-lg">
                                    <option value="" disabled selected>-- เลือกประเภทอาการเสีย --</option>
                                    <option value="screen" data-name="เปลี่ยนหน้าจอแท้ (OLED Super Retina)" data-time="45 - 60 นาที" data-warranty="180 วัน">
                                        เปลี่ยนหน้าจอแท้ OLED (จอแตก / สัมผัสไม่ได้ / จอเขียว)
                                    </option>
                                    <option value="battery" data-name="เปลี่ยนแบตเตอรี่แท้ มอก. (สุขภาพ 100%)" data-time="30 - 45 นาที" data-warranty="180 วัน">
                                        เปลี่ยนแบตเตอรี่แท้ มอก. (แบตเสื่อม / แบตบวม / ชาร์จลดไว)
                                    </option>
                                    @foreach($services as $service)
                                        @if(!str_contains($service->name, 'เปลี่ยนหน้าจอ') && !str_contains($service->name, 'เปลี่ยนแบตเตอรี่'))
                                        <option value="{{ $service->id }}" 
                                                data-name="{{ $service->name }}"
                                                data-price="{{ $service->base_price }}"
                                                data-time="{{ $service->estimated_duration }}"
                                                data-warranty="{{ $service->warranty_period }}">
                                            {{ $service->name }} (หมวด: {{ $service->category }})
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="alert alert-light border small text-muted mb-0">
                                <i class="bi bi-info-circle text-primary me-1"></i>
                                ราคาที่คำนวณเป็นราคามาตรฐานรวมค่าแรงช่างแล้ว หากมีหลายอาการพร้อมกัน ทางร้านมีส่วนลดพิเศษให้อีก 10 - 20%
                            </div>
                        </div>
                    </div>

                    <!-- Estimate Summary Result Box -->
                    <div class="col-lg-5">
                        <div class="card card-apple p-4 p-md-5 h-100 bg-white border-primary border-2 shadow-sm text-center d-flex flex-column justify-content-between">
                            <div>
                                <span class="badge bg-primary text-white rounded-pill px-3 py-1 mb-3">สรุปผลการประเมินราคา</span>
                                
                                <h4 class="fw-bold text-dark mb-1" id="displayModel">-- กรุณาเลือกรุ่น --</h4>
                                <p class="text-muted small mb-4" id="displayService">-- กรุณาเลือกอาการเสีย --</p>

                                <div class="p-3 bg-light rounded-4 mb-4">
                                    <span class="text-muted small d-block">ราคาประเมินโดยประมาณ</span>
                                    <div class="display-5 fw-bold text-primary brand-font" id="displayPrice">
                                        ฿0
                                    </div>
                                    <span class="text-muted text-xs" style="font-size: 0.78rem;">รวมค่าแรงและอะไหล่แล้ว</span>
                                </div>

                                <div class="text-start small text-secondary mb-4">
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span><i class="bi bi-clock me-1 text-primary"></i> เวลาที่ใช้ซ่อม:</span>
                                        <strong id="displayTime">-</strong>
                                    </div>
                                    <div class="d-flex justify-content-between py-1 border-bottom">
                                        <span><i class="bi bi-shield-check me-1 text-success"></i> ระยะเวลารับประกัน:</span>
                                        <strong id="displayWarranty">-</strong>
                                    </div>
                                    <div class="d-flex justify-content-between py-1">
                                        <span><i class="bi bi-check2-circle me-1 text-info"></i> ตรวจเช็คเครื่อง:</span>
                                        <strong class="text-success">ฟรี (ไม่มีค่าเปิดเครื่อง)</strong>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <a href="{{ route('booking.create') }}" class="btn btn-apple w-100 py-3 fw-bold" id="btnBookNow">
                                    <i class="bi bi-calendar-check me-1"></i> จองคิวแจ้งซ่อมทันที
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modelSelect = document.getElementById('modelSelect');
        const serviceSelect = document.getElementById('serviceSelect');
        const displayModel = document.getElementById('displayModel');
        const displayService = document.getElementById('displayService');
        const displayPrice = document.getElementById('displayPrice');
        const displayTime = document.getElementById('displayTime');
        const displayWarranty = document.getElementById('displayWarranty');

        function updateEstimate() {
            const selectedModelOpt = modelSelect.options[modelSelect.selectedIndex];
            const selectedServiceOpt = serviceSelect.options[serviceSelect.selectedIndex];

            if (!modelSelect.value || !serviceSelect.value) {
                return;
            }

            const modelName = selectedModelOpt.getAttribute('data-name');
            const screenPrice = parseFloat(selectedModelOpt.getAttribute('data-screen')) || 2500;
            const batteryPrice = parseFloat(selectedModelOpt.getAttribute('data-battery')) || 1500;

            const serviceVal = serviceSelect.value;
            const serviceName = selectedServiceOpt.getAttribute('data-name');
            const time = selectedServiceOpt.getAttribute('data-time') || '1 - 2 ชั่วโมง';
            const warranty = selectedServiceOpt.getAttribute('data-warranty') || '90 วัน';

            let finalPrice = 0;
            if (serviceVal === 'screen') {
                finalPrice = screenPrice;
            } else if (serviceVal === 'battery') {
                finalPrice = batteryPrice;
            } else {
                finalPrice = parseFloat(selectedServiceOpt.getAttribute('data-price')) || 1800;
            }

            displayModel.textContent = modelName;
            displayService.textContent = serviceName;
            displayPrice.textContent = '฿' + finalPrice.toLocaleString('th-TH');
            displayTime.textContent = time;
            displayWarranty.textContent = warranty;
        }

        modelSelect.addEventListener('change', updateEstimate);
        serviceSelect.addEventListener('change', updateEstimate);
    });
</script>
@endsection
