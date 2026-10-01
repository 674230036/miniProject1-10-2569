<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบรับเครื่องซ่อม - {{ $ticket->ticket_number }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Prompt', sans-serif;
            color: #000000;
            background: #ffffff;
            padding: 20px;
        }

        .print-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #333333;
            padding: 30px;
            background: #ffffff;
        }

        .brand-title {
            font-family: 'Kanit', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .barcode-sim {
            font-family: monospace;
            letter-spacing: 5px;
            font-size: 1.4rem;
            font-weight: 700;
            padding: 6px 12px;
            border: 1px dashed #333333;
            display: inline-block;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #000000 !important;
            padding: 8px 12px;
            font-size: 0.92rem;
        }

        .terms-box {
            font-size: 0.8rem;
            line-height: 1.5;
            color: #444444;
            border: 1px solid #cccccc;
            padding: 12px;
            background: #fdfdfd;
        }

        .signature-box {
            border-top: 1px solid #000000;
            padding-top: 5px;
            text-align: center;
            font-size: 0.88rem;
            width: 220px;
            margin: 50px auto 0 auto;
        }

        @media print {
            body {
                padding: 0;
                background: #ffffff;
            }
            .print-container {
                border: none;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Print Action Buttons (Hidden when printing) -->
    <div class="no-print text-center mb-4">
        <button onclick="window.print()" class="btn btn-primary px-4 py-2 rounded-pill me-2">
            พิมพ์เอกสารนี้ (Print)
        </button>
        <button onclick="window.close()" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
            ปิดหน้านี้
        </button>
    </div>

    <div class="print-container">
        <!-- Header -->
        <div class="row align-items-center pb-3 border-bottom border-dark mb-3">
            <div class="col-8">
                <div class="brand-title text-dark">iRepair Store NPRU (ศูนย์บริการซ่อมไอโฟน)</div>
                <div class="small">สาขาวิชาเทคโนโลยีสารสนเทศ คณะวิทยาศาสตร์และเทคโนโลยี ม.ราชภัฏนครปฐม</div>
                <div class="small">ที่อยู่: 85 ถ.มาลัยแมน ต.นครปฐม อ.เมือง จ.นครปฐม 73000 &bull; โทร: 089-123-4567, 081-987-6543</div>
                <div class="small">LINE: @irepair_npru &bull; เว็บไซต์: http://localhost/Final Project</div>
            </div>
            <div class="col-4 text-end">
                <div class="barcode-sim mb-1">{{ $ticket->ticket_number }}</div>
                <div class="small fw-bold">ใบรับเครื่องซ่อม / ใบแจ้งหนี้</div>
                <div class="small text-muted">วันที่: {{ $ticket->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>

        <!-- Info Grid -->
        <table class="table table-bordered mb-3">
            <tbody>
                <tr>
                    <th class="table-light" style="width: 22%;">ชื่อลูกค้า</th>
                    <td style="width: 28%;"><strong>{{ $ticket->customer->name }}</strong></td>
                    <th class="table-light" style="width: 22%;">เบอร์โทรศัพท์</th>
                    <td style="width: 28%;">{{ $ticket->customer->phone }}</td>
                </tr>
                <tr>
                    <th class="table-light">รุ่นโทรศัพท์</th>
                    <td><strong>{{ $ticket->phoneModel->name }}</strong></td>
                    <th class="table-light">สีตัวเครื่อง</th>
                    <td>{{ $ticket->device_color ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="table-light">เลข IMEI / Serial</th>
                    <td class="font-monospace">{{ $ticket->imei_serial ?? 'ไม่ได้ระบุ' }}</td>
                    <th class="table-light">รหัสผ่าน (Passcode)</th>
                    <td>{{ $ticket->device_passcode ? 'ระบุในระบบ' : 'ไม่มีรหัส' }}</td>
                </tr>
                <tr>
                    <th class="table-light">สภาพตัวเครื่องก่อนซ่อม</th>
                    <td colspan="3">{{ $ticket->device_condition ?? 'ปกติ ไม่มีรอยแตกชัดเจน' }}</td>
                </tr>
                <tr>
                    <th class="table-light">อาการเสียที่แจ้งซ่อม</th>
                    <td colspan="3"><strong>{{ $ticket->symptom_description }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Charges & Status -->
        <table class="table table-bordered mb-3">
            <thead class="table-light">
                <tr>
                    <th>รายการบริการ / อะไหล่</th>
                    <th>ระยะเวลาประกัน</th>
                    <th class="text-end" style="width: 25%;">จำนวนเงิน (บาท)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $ticket->repairService ? $ticket->repairService->name : 'ตรวจเช็คและซ่อมแซมตามอาการ' }}</strong>
                        @if($ticket->technician_notes)
                            <div class="small text-muted mt-1">หมายเหตุช่าง: {{ $ticket->technician_notes }}</div>
                        @endif
                    </td>
                    <td>{{ $ticket->repairService ? $ticket->repairService->warranty_period : '90 วัน' }}</td>
                    <td class="text-end fw-bold">
                        ฿{{ number_format($ticket->final_cost ?: $ticket->estimated_cost, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-end fw-bold">ยอดเงินสุทธิทั้งสิ้น (Total Amount):</td>
                    <td class="text-end fw-bold fs-6">
                        ฿{{ number_format($ticket->final_cost ?: $ticket->estimated_cost, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Terms and Conditions -->
        <div class="terms-box mb-4">
            <strong>เงื่อนไขการรับบริการและการรับประกัน:</strong>
            <ol class="mb-0 ps-3 mt-1">
                <li>กรุณานำใบรับเครื่องซ่อมฉบับนี้มาแสดงทุกครั้งเมื่อมารับเครื่อง หากสูญหายต้องแสดงบัตรประชาชนตัวจริง</li>
                <li>ทางศูนย์บริการรับประกันเฉพาะอาการและอะไหล่ที่เปลี่ยนตามระบุ หากเครื่องตกกระแทก โดนน้ำซ้ำ หรือมีการแกะจากที่อื่น จะสิ้นสุดการรับประกันทันที</li>
                <li>กรุณามารับเครื่องภายใน 30 วัน นับจากวันที่ได้รับแจ้งว่าซ่อมเสร็จ มิฉะนั้นทางศูนย์จะไม่รับผิดชอบต่อความเสียหายใดๆ</li>
            </ol>
        </div>

        <!-- Signatures -->
        <div class="row pt-2">
            <div class="col-6 text-center">
                <div class="signature-box">
                    ลงชื่อ......................................................<br>
                    ( {{ $ticket->customer->name }} )<br>
                    <strong>ลูกค้าผู้ส่งซ่อม</strong>
                </div>
            </div>
            <div class="col-6 text-center">
                <div class="signature-box">
                    ลงชื่อ......................................................<br>
                    ( {{ $ticket->technician ? $ticket->technician->name : 'นายธีรเดช วงศ์สว่าง (036)' }} )<br>
                    <strong>เจ้าหน้าที่ / ช่างผู้รับเครื่อง</strong>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 pt-2 border-top small text-muted" style="font-size: 0.75rem;">
            เอกสารนี้จัดทำโดยระบบสารสนเทศ iRepair NPRU &bull; พัฒนาโดย นายธีรเดช (036) และ นายภูมิพัฒน์ (008)
        </div>
    </div>

</body>
</html>
