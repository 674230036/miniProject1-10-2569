<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\PhoneModel;
use App\Models\RepairService;
use App\Models\RepairStatusLog;
use App\Models\RepairTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with realistic Apple repair data.
     */
    public function run(): void
    {
        // ---------------------------------------------------------------------
        // 1. Staff / Admin Users
        // ---------------------------------------------------------------------
        $admin = User::create([
            'name' => 'นายธีรเดช วงศ์สว่าง',
            'email' => 'admin@irepair.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'student_id' => '654230036',
            'phone' => '089-123-4567',
        ]);

        $frontendDev = User::create([
            'name' => 'นายภูมิพัฒน์ เกษมสุข',
            'email' => 'tech008@irepair.com',
            'password' => Hash::make('admin123'),
            'role' => 'technician',
            'student_id' => '654230008',
            'phone' => '081-987-6543',
        ]);

        $techSenior = User::create([
            'name' => 'ช่างศักดิ์ดา มะลิวัลย์',
            'email' => 'tech01@irepair.com',
            'password' => Hash::make('admin123'),
            'role' => 'technician',
            'student_id' => null,
            'phone' => '084-555-7890',
        ]);

        // ---------------------------------------------------------------------
        // 2. iPhone Models
        // ---------------------------------------------------------------------
        $modelsData = [
            [
                'name' => 'iPhone 16 Pro Max',
                'series' => 'iPhone 16 Series',
                'release_year' => 2024,
                'screen_size' => '6.9 นิ้ว Super Retina XDR ProMotion 120Hz',
                'base_screen_price' => 8500,
                'base_battery_price' => 2500,
            ],
            [
                'name' => 'iPhone 16 Pro',
                'series' => 'iPhone 16 Series',
                'release_year' => 2024,
                'screen_size' => '6.3 นิ้ว Super Retina XDR ProMotion 120Hz',
                'base_screen_price' => 7500,
                'base_battery_price' => 2400,
            ],
            [
                'name' => 'iPhone 16',
                'series' => 'iPhone 16 Series',
                'release_year' => 2024,
                'screen_size' => '6.1 นิ้ว Super Retina XDR OLED',
                'base_screen_price' => 5900,
                'base_battery_price' => 2200,
            ],
            [
                'name' => 'iPhone 15 Pro Max',
                'series' => 'iPhone 15 Series',
                'release_year' => 2023,
                'screen_size' => '6.7 นิ้ว Super Retina XDR ProMotion',
                'base_screen_price' => 6900,
                'base_battery_price' => 2200,
            ],
            [
                'name' => 'iPhone 15 Pro',
                'series' => 'iPhone 15 Series',
                'release_year' => 2023,
                'screen_size' => '6.1 นิ้ว Super Retina XDR ProMotion',
                'base_screen_price' => 6500,
                'base_battery_price' => 2100,
            ],
            [
                'name' => 'iPhone 15 Plus',
                'series' => 'iPhone 15 Series',
                'release_year' => 2023,
                'screen_size' => '6.7 นิ้ว Super Retina XDR',
                'base_screen_price' => 4900,
                'base_battery_price' => 1900,
            ],
            [
                'name' => 'iPhone 15',
                'series' => 'iPhone 15 Series',
                'release_year' => 2023,
                'screen_size' => '6.1 นิ้ว Dynamic Island Super Retina XDR',
                'base_screen_price' => 4500,
                'base_battery_price' => 1900,
            ],
            [
                'name' => 'iPhone 14 Pro Max',
                'series' => 'iPhone 14 Series',
                'release_year' => 2022,
                'screen_size' => '6.7 นิ้ว Dynamic Island ProMotion',
                'base_screen_price' => 5900,
                'base_battery_price' => 1800,
            ],
            [
                'name' => 'iPhone 14 Pro',
                'series' => 'iPhone 14 Series',
                'release_year' => 2022,
                'screen_size' => '6.1 นิ้ว Dynamic Island ProMotion',
                'base_screen_price' => 5500,
                'base_battery_price' => 1800,
            ],
            [
                'name' => 'iPhone 14',
                'series' => 'iPhone 14 Series',
                'release_year' => 2022,
                'screen_size' => '6.1 นิ้ว Super Retina XDR',
                'base_screen_price' => 3800,
                'base_battery_price' => 1600,
            ],
            [
                'name' => 'iPhone 13 Pro Max',
                'series' => 'iPhone 13 Series',
                'release_year' => 2021,
                'screen_size' => '6.7 นิ้ว Super Retina XDR ProMotion',
                'base_screen_price' => 4900,
                'base_battery_price' => 1600,
            ],
            [
                'name' => 'iPhone 13 Pro',
                'series' => 'iPhone 13 Series',
                'release_year' => 2021,
                'screen_size' => '6.1 นิ้ว ProMotion จอ 120Hz',
                'base_screen_price' => 4500,
                'base_battery_price' => 1500,
            ],
            [
                'name' => 'iPhone 13',
                'series' => 'iPhone 13 Series',
                'release_year' => 2021,
                'screen_size' => '6.1 นิ้ว Super Retina XDR',
                'base_screen_price' => 3200,
                'base_battery_price' => 1400,
            ],
            [
                'name' => 'iPhone 12 Pro Max',
                'series' => 'iPhone 12 Series',
                'release_year' => 2020,
                'screen_size' => '6.7 นิ้ว Super Retina XDR',
                'base_screen_price' => 3900,
                'base_battery_price' => 1400,
            ],
            [
                'name' => 'iPhone 12 / 12 Pro',
                'series' => 'iPhone 12 Series',
                'release_year' => 2020,
                'screen_size' => '6.1 นิ้ว OLED Super Retina',
                'base_screen_price' => 2900,
                'base_battery_price' => 1300,
            ],
            [
                'name' => 'iPhone 11',
                'series' => 'iPhone 11 Series',
                'release_year' => 2019,
                'screen_size' => '6.1 นิ้ว Liquid Retina HD',
                'base_screen_price' => 1900,
                'base_battery_price' => 1200,
            ],
        ];

        $models = [];
        foreach ($modelsData as $data) {
            $models[$data['name']] = PhoneModel::create($data);
        }

        // ---------------------------------------------------------------------
        // 3. Repair Services
        // ---------------------------------------------------------------------
        $servicesData = [
            [
                'name' => 'เปลี่ยนหน้าจอแท้ (OLED Super Retina)',
                'category' => 'หน้าจอ / กระจก',
                'icon' => 'bi-phone',
                'description' => 'เปลี่ยนจอแท้ รองรับระบบ TrueTone สัมผัสลื่นไหล สีสันตรงตามมาตรฐาน Apple พร้อมประกันยาวนาน',
                'estimated_duration' => '45 - 60 นาที',
                'warranty_period' => '180 วัน (6 เดือน)',
                'base_price' => 3500,
            ],
            [
                'name' => 'เปลี่ยนแบตเตอรี่แท้ มอก. (สุขภาพแบต 100%)',
                'category' => 'แบตเตอรี่',
                'icon' => 'bi-battery-charging',
                'description' => 'แบตเตอรี่มาตรฐาน มอก. พร้อมย้ายขั้วเดิมเพื่อแสดงค่าสุขภาพแบตเตอรี่ 100% ไม่ฟ้องแจ้งเตือนสิ่งแปลกปลอม',
                'estimated_duration' => '30 - 45 นาที',
                'warranty_period' => '180 วัน (6 เดือน)',
                'base_price' => 1500,
            ],
            [
                'name' => 'ลอกเปลี่ยนกระจกจอแท้ (รักษาจอแท้เดิม)',
                'category' => 'หน้าจอ / กระจก',
                'icon' => 'bi-aspect-ratio',
                'description' => 'สำหรับกรณีหน้าจอด้านนอกแตก แต่การสัมผัสและภาพด้านในยังปกติ ใช้เครื่องลอก OCA อัดสูญญากาศมาตรฐานโรงงาน',
                'estimated_duration' => '1 - 2 ชั่วโมง',
                'warranty_period' => '90 วัน',
                'base_price' => 1800,
            ],
            [
                'name' => 'ซ่อมเมนบอร์ด / อาการดับเปิดไม่ติด / บอร์ดช็อต',
                'category' => 'เมนบอร์ด / วงจร',
                'icon' => 'bi-cpu',
                'description' => 'วิเคราะห์ด้วยกล้องอินฟราเรดตรวจจับความร้อน ซ่อม IC พาวเวอร์, บอร์ดประกบช็อต, ซ่อมลายวงจรไฟหลัก ข้อมูลไม่หาย',
                'estimated_duration' => '1 - 3 วัน',
                'warranty_period' => '90 วัน',
                'base_price' => 2500,
            ],
            [
                'name' => 'ซ่อมระบบ Face ID / เซนเซอร์ TrueDepth',
                'category' => 'กล้องและเซนเซอร์',
                'icon' => 'bi-person-bounding-box',
                'description' => 'แก้ปัญหาใบหน้าขึ้นไม่พร้อมใช้งาน สแกนหน้าไม่ผ่าน หลังตกกระแทกหรือโดนเหงื่อ/ละอองน้ำ ซ่อมชิป Dot Projector',
                'estimated_duration' => '2 - 3 ชั่วโมง',
                'warranty_period' => '90 วัน',
                'base_price' => 1900,
            ],
            [
                'name' => 'เปลี่ยนโมดูลกล้องหลังแท้ / กล้องสั่น โฟกัสไม่ได้',
                'category' => 'กล้องและเซนเซอร์',
                'icon' => 'bi-camera',
                'description' => 'แก้ไขอาการกล้องกระตุกสั่น มีเสียงดังจี๊ดๆ ภาพมัว มีจุดดำ จุดม่วง หรือเลนส์แตก เปลี่ยนอะไหล่แท้ตรงรุ่น',
                'estimated_duration' => '45 - 60 นาที',
                'warranty_period' => '90 วัน',
                'base_price' => 2200,
            ],
            [
                'name' => 'เปลี่ยนแพรชาร์จ / ก้นชาร์จหลวม ชาร์จไฟไม่เข้า',
                'category' => 'ระบบไฟและชาร์จ',
                'icon' => 'bi-lightning-charge',
                'description' => 'แก้ปัญหาเสียบสายชาร์จแล้วติดๆ ดับๆ ชาร์จไม่เข้า ไมค์สนทนาไม่ได้ยิน ลำโพงล่างไม่ดัง เปลี่ยนพอร์ตชาร์จคุณภาพสูง',
                'estimated_duration' => '40 - 50 นาที',
                'warranty_period' => '90 วัน',
                'base_price' => 1200,
            ],
            [
                'name' => 'ล้างเครื่องตกน้ำ / อบไล่ความชื้น กู้ข้อมูล',
                'category' => 'เมนบอร์ด / วงจร',
                'icon' => 'bi-droplet',
                'description' => 'ทำความสะอาดคราบขี้เกลือด้วยน้ำยา Ultrasonic ทำความสะอาดบอร์ด อบไล่ความชื้นและตรวจเช็คการกินกระแสไฟ',
                'estimated_duration' => '1 - 2 วัน',
                'warranty_period' => '30 วัน',
                'base_price' => 1500,
            ],
            [
                'name' => 'เปลี่ยนฝาหลังกระจกด้วยระบบ Laser',
                'category' => 'บอดี้ / ฝาหลัง',
                'icon' => 'bi-phone-flip',
                'description' => 'ยิงเลเซอร์ลอกกาวฝาหลังเดิมโดยไม่ต้องแกะเครื่องด้านใน เปลี่ยนกระจกฝาหลังเกรดแท้ แนบสนิทเหมือนใหม่',
                'estimated_duration' => '2 - 3 ชั่วโมง',
                'warranty_period' => '90 วัน',
                'base_price' => 1600,
            ],
        ];

        $services = [];
        foreach ($servicesData as $data) {
            $services[$data['name']] = RepairService::create($data);
        }

        // ---------------------------------------------------------------------
        // 4. Customers
        // ---------------------------------------------------------------------
        $customersData = [
            [
                'name' => 'คุณกานดา รัตนวิจิตร',
                'phone' => '081-234-5678',
                'email' => 'kanda.rat@gmail.com',
                'line_id' => 'kanda_npru',
                'address' => '128/4 ถ.มาลัยแมน ต.ลำพยา อ.เมือง จ.นครปฐม 73000',
                'notes' => 'ลูกค้าประจำ มักนำเครื่องคนในครอบครัวมาตรวจเช็ค',
            ],
            [
                'name' => 'คุณธนพล เจริญสุข',
                'phone' => '086-789-0123',
                'email' => 'tanapol.c@hotmail.com',
                'line_id' => 'ohm_tanapol',
                'address' => '55 หมู่ 2 ต.กำแพงแสน อ.กำแพงแสน จ.นครปฐม 73140',
                'notes' => 'แจ้งว่าต้องใช้งานด่วน มีประชุมสำคัญ',
            ],
            [
                'name' => 'คุณสมชาย พงษ์ศิริ',
                'phone' => '089-456-7890',
                'email' => 'somchai.p@gmail.com',
                'line_id' => 'somchai_p',
                'address' => '99/12 ต.ห้วยจรเข้ อ.เมือง จ.นครปฐม 73000',
                'notes' => 'เครื่องตกพื้นคอนกรีต จอเขียวกระพริบ',
            ],
            [
                'name' => 'คุณพิมพาภรณ์ ทรัพย์ทวี',
                'phone' => '092-345-6789',
                'email' => 'pimpaporn.s@outlook.com',
                'line_id' => 'pim_t',
                'address' => '42 หมู่ 6 ต.ดอนพุทรา อ.ดอนตูม จ.นครปฐม 73150',
                'notes' => 'กระจกหน้าจอแตกเป็นลายใยแมงมุม แต่ภาพยังชัดเจน',
            ],
            [
                'name' => 'คุณณภัทร วงศ์ษา',
                'phone' => '085-678-9012',
                'email' => 'napat.w@gmail.com',
                'line_id' => 'napat_it',
                'address' => '15/3 ต.ศาลายา อ.พุทธมณฑล จ.นครปฐม 73170',
                'notes' => 'นักศึกษา NPRU สอบถามส่วนลดนักศึกษา',
            ],
            [
                'name' => 'คุณอานนท์ มั่นคง',
                'phone' => '090-123-4567',
                'email' => 'arnon.m@gmail.com',
                'line_id' => 'arnon_m',
                'address' => '88/2 ต.พระปฐมเจดีย์ อ.เมือง จ.นครปฐม 73000',
                'notes' => 'ขี่มอเตอร์ไซค์แล้วกล้องหลังสั่น โฟกัสไม่ติด',
            ],
            [
                'name' => 'คุณศิริพร บุญเกิด',
                'phone' => '083-456-7891',
                'email' => 'siriporn.b@yahoo.com',
                'line_id' => 'siri_boon',
                'address' => '71 หมู่ 3 ต.งิ้วราย อ.นครชัยศรี จ.นครปฐม 73120',
                'notes' => 'สแกน Face ID ไม่ได้ ขึ้นบอกให้อยู่ในระยะที่เหมาะสม',
            ],
            [
                'name' => 'คุณกฤษฎา ชื่นชม',
                'phone' => '087-890-1234',
                'email' => 'kritsada.c@gmail.com',
                'line_id' => 'golf_krit',
                'address' => '24 หมู่ 1 ต.บางหลวง อ.บางเลน จ.นครปฐม 73130',
                'notes' => 'เปลี่ยนฝาหลัง iPhone 16 Pro กระจกหลังแตก',
            ],
        ];

        $customers = [];
        foreach ($customersData as $data) {
            $customers[] = Customer::create($data);
        }

        // ---------------------------------------------------------------------
        // 5. Repair Tickets & Timeline Status Logs
        // ---------------------------------------------------------------------
        $ticketsData = [
            // Ticket 1: เสร็จสิ้น พร้อมส่งมอบ
            [
                'ticket_number' => 'REP-202610-001',
                'customer' => $customers[0], // กานดา
                'phone_model' => $models['iPhone 14'],
                'repair_service' => $services['เปลี่ยนแบตเตอรี่แท้ มอก. (สุขภาพแบต 100%)'],
                'device_color' => 'Starlight (ขาวนวล)',
                'imei_serial' => '354892019482716',
                'device_passcode' => '142536',
                'symptom_description' => 'สุขภาพแบตเตอรี่เหลือ 71% เครื่องร้อนง่าย และมีอาการบวมเล็กน้อยจนดันขอบจอขึ้น',
                'device_condition' => 'ขอบข้างมีรอยเคสกัดเล็กน้อย หน้าจอไม่มีรอยแตกร้าว',
                'service_type' => 'walk_in',
                'status' => 'completed',
                'priority' => 'normal',
                'estimated_cost' => 1600,
                'final_cost' => 1600,
                'technician_notes' => 'เปลี่ยนเซลล์แบตเตอรี่แท้ มอก. ความจุเต็ม 100% เชื่อมย้ายขั้ว BMS แท้เดิม ค่าสุขภาพแบตขึ้น 100% ปกติ พร้อมติดซีลกันน้ำให้ใหม่',
                'assigned_to' => $admin->id,
                'warranty_until' => Carbon::now()->addDays(180),
                'completed_at' => Carbon::now()->subHours(2),
                'logs' => [
                    [
                        'status' => 'pending',
                        'title' => 'รับเครื่องเข้าศูนย์บริการ',
                        'note' => 'ลูกค้าส่งเครื่องด้วยตัวเองหน้าร้าน ตรวจสอบสภาพภายนอกและบันทึกอาการแบตเตอรี่เสื่อม',
                        'performed_by' => 'เจ้าหน้าที่เคาน์เตอร์ (008)',
                        'time' => Carbon::now()->subDays(1)->setTime(10, 15),
                    ],
                    [
                        'status' => 'inspecting',
                        'title' => 'ตรวจเช็คระบบไฟและเมนบอร์ด',
                        'note' => 'วัดค่ากระแสไฟ ไม่พบการช็อตของไอซีพาวเวอร์ แบตเตอรี่เสื่อมสภาพจริง',
                        'performed_by' => 'ช่างธีรเดช (036)',
                        'time' => Carbon::now()->subDays(1)->setTime(11, 0),
                    ],
                    [
                        'status' => 'repairing',
                        'title' => 'ดำเนินการเปลี่ยนแบตเตอรี่และเชื่อมขั้ว BMS',
                        'note' => 'ทำการบัดกรีขั้วชิปเดิม และยิงซีลกาวแบตเตอรี่แท้มาตรฐานโรงงาน',
                        'performed_by' => 'ช่างธีรเดช (036)',
                        'time' => Carbon::now()->subDays(1)->setTime(14, 30),
                    ],
                    [
                        'status' => 'completed',
                        'title' => 'การซ่อมเสร็จสิ้น ทดสอบระบบผ่าน 100%',
                        'note' => 'ทดสอบชาร์จไฟเข้าปกติ สุขภาพแบตเตอรี่แสดง 100% พร้อมให้ลูกค้ามารับเครื่องได้เลย',
                        'performed_by' => 'ช่างธีรเดช (036)',
                        'time' => Carbon::now()->subHours(2),
                    ],
                ],
            ],

            // Ticket 2: กำลังซ่อมบอร์ดตกน้ำ
            [
                'ticket_number' => 'REP-202610-002',
                'customer' => $customers[1], // ธนพล
                'phone_model' => $models['iPhone 15 Pro Max'],
                'repair_service' => $services['ล้างเครื่องตกน้ำ / อบไล่ความชื้น กู้ข้อมูล'],
                'device_color' => 'Natural Titanium (ไทเทเนียมธรรมชาติ)',
                'imei_serial' => '359182746192834',
                'device_passcode' => '998877',
                'symptom_description' => 'เครื่องตกสระว่ายน้ำ จมน้ำประมาณ 5 นาที นำขึ้นมาเครื่องดับเปิดไม่ติด ลูกค้าต้องการกู้ข้อมูลสำคัญด้านใน',
                'device_condition' => 'มีคราบไอน้ำที่เลนส์กล้องหน้าและกล้องหลัง ฝาหลังไม่มีรอยแตก',
                'service_type' => 'walk_in',
                'status' => 'repairing',
                'priority' => 'urgent',
                'estimated_cost' => 3500,
                'final_cost' => null,
                'technician_notes' => 'แกะบอร์ดแยกชั้น พบคราบออกไซด์บริเวณชุดไฟหลัก VDD_MAIN ล้างบอร์ดด้วยคลื่นอัลตราโซนิกแล้ว กำลังซ่อมต่อลายวงจร',
                'assigned_to' => $admin->id,
                'warranty_until' => null,
                'completed_at' => null,
                'logs' => [
                    [
                        'status' => 'pending',
                        'title' => 'รับเครื่องกรณีเครื่องตกน้ำด่วน',
                        'note' => 'รับเครื่องเคสด่วน ลูกค้าไม่ได้เสียบสายชาร์จหลังตกน้ำ (ถูกต้อง)',
                        'performed_by' => 'เจ้าหน้าที่เคาน์เตอร์ (008)',
                        'time' => Carbon::now()->subHours(18),
                    ],
                    [
                        'status' => 'inspecting',
                        'title' => 'แกะเปิดเครื่องและประเมินคราบน้ำ',
                        'note' => 'พบแถบวัดความชื้นเปลี่ยนเป็นสีแดงเข้มทั้ง 2 จุด แกะซับความชื้นและถอดขั้วแบตเตอรี่ทันที',
                        'performed_by' => 'ช่างธีรเดช (036)',
                        'time' => Carbon::now()->subHours(16),
                    ],
                    [
                        'status' => 'repairing',
                        'title' => 'แยกบอร์ด 2 ชั้นและทำความสะอาดลายวงจร',
                        'note' => 'ใช้แท่นฮีตเตอร์แยกบอร์ด นำเข้าเครื่องล้างอัลตราโซนิกกำลังสูง ไล่ความชื้นและกำลังต่อลายวงจรช็อต',
                        'performed_by' => 'ช่างธีรเดช (036)',
                        'time' => Carbon::now()->subHours(4),
                    ],
                ],
            ],

            // Ticket 3: ส่งมอบเครื่องแล้ว (Delivered / ปิดงาน)
            [
                'ticket_number' => 'REP-202610-003',
                'customer' => $customers[2], // สมชาย
                'phone_model' => $models['iPhone 13 Pro'],
                'repair_service' => $services['เปลี่ยนหน้าจอแท้ (OLED Super Retina)'],
                'device_color' => 'Sierra Blue (ฟ้าเซียร์ร่า)',
                'imei_serial' => '351239847120938',
                'device_passcode' => '112233',
                'symptom_description' => 'จอเขียวทั้งจอหลังอัปเดต iOS มีเสียงเตือนปกติ สัมผัสได้แต่ไม่เห็นภาพ',
                'device_condition' => 'สภาพสวย มีรอยเคสบางๆ ติดฟิล์มกระจกเดิม',
                'service_type' => 'walk_in',
                'status' => 'delivered',
                'priority' => 'normal',
                'estimated_cost' => 4500,
                'final_cost' => 4500,
                'technician_notes' => 'ดำเนินการซ่อมลายจอแท้ (ต่อลายสะพานไฟ 120Hz) ภาพกลับมาคมชัดสีสดใส TrueTone ใช้ได้ปกติ ประกัน 90 วัน',
                'assigned_to' => $frontendDev->id,
                'warranty_until' => Carbon::now()->addDays(90),
                'completed_at' => Carbon::now()->subDays(2),
                'delivered_at' => Carbon::now()->subDays(1),
                'logs' => [
                    [
                        'status' => 'pending',
                        'title' => 'รับเครื่องตรวจสอบอาการจอขาว/จอเขียว',
                        'note' => 'รับเครื่องจากคุณสมชาย ยืนยันอาการจอเขียวกระพริบหลังอัปเดต',
                        'performed_by' => 'เจ้าหน้าที่เคาน์เตอร์ (008)',
                        'time' => Carbon::now()->subDays(3)->setTime(9, 30),
                    ],
                    [
                        'status' => 'repairing',
                        'title' => 'ต่อสะพานไฟจอแท้ 120Hz',
                        'note' => 'ช่างลงมือยิงสายจัมเปอร์ไฟจอโดยไม่ต้องเปลี่ยนจอใหม่ ประหยัดเงินให้ลูกค้าได้มาก',
                        'performed_by' => 'ช่างศักดิ์ดา',
                        'time' => Carbon::now()->subDays(2)->setTime(13, 0),
                    ],
                    [
                        'status' => 'completed',
                        'title' => 'ซ่อมจอสำเร็จ ภาพสวย คมชัด',
                        'note' => 'ทดสอบระบบ ProMotion 120Hz และ TrueTone ใช้งานได้ 100%',
                        'performed_by' => 'ช่างธีรเดช (036)',
                        'time' => Carbon::now()->subDays(2)->setTime(16, 45),
                    ],
                    [
                        'status' => 'delivered',
                        'title' => 'ลูกค้าตรวจรับเครื่องและชำระเงินเรียบร้อย',
                        'note' => 'ลูกค้าทดสอบเครื่องด้วยตนเองพอใจมาก ออกใบรับประกัน 90 วันและส่งมอบเครื่อง',
                        'performed_by' => 'เจ้าหน้าที่เคาน์เตอร์ (008)',
                        'time' => Carbon::now()->subDays(1)->setTime(14, 20),
                    ],
                ],
            ],

            // Ticket 4: รออะไหล่แท้ (Waiting Parts)
            [
                'ticket_number' => 'REP-202610-004',
                'customer' => $customers[3], // พิมพาภรณ์
                'phone_model' => $models['iPhone 12 / 12 Pro'],
                'repair_service' => $services['ลอกเปลี่ยนกระจกจอแท้ (รักษาจอแท้เดิม)'],
                'device_color' => 'Purple (ม่วง)',
                'imei_serial' => '357283918274619',
                'device_passcode' => '556677',
                'symptom_description' => 'กระจกหน้าจอแตกร้าวจากมุมบนขวา การสัมผัสหน้าจอและจอในยังแสดงผลได้ปกติ ไม่มีเส้นดำ',
                'device_condition' => 'ขอบเครื่องมีรอยตกเล็กน้อยบริเวณมุมขวาบน',
                'service_type' => 'online_booking',
                'status' => 'waiting_parts',
                'priority' => 'normal',
                'estimated_cost' => 1800,
                'final_cost' => null,
                'technician_notes' => 'สั่งกระจกหน้าจอแท้เกรดโรงงานพร้อมกาว OCA อะไหล่กำลังจัดส่งมาถึงช่วงบ่าย',
                'assigned_to' => $admin->id,
                'warranty_until' => null,
                'completed_at' => null,
                'logs' => [
                    [
                        'status' => 'pending',
                        'title' => 'ลูกค้าแจ้งซ่อมออนไลน์ผ่านระบบ',
                        'note' => 'ระบบรับเรื่องแจ้งซ่อมนัดหมายล่วงหน้าจากคุณพิมพาภรณ์',
                        'performed_by' => 'ระบบอัตโนมัติ (Online Booking)',
                        'time' => Carbon::now()->subHours(24),
                    ],
                    [
                        'status' => 'inspecting',
                        'title' => 'ลูกค้านำเครื่องมาส่งหน้าร้าน',
                        'note' => 'ตรวจสอบจอใน OLED ไม่แตกร้าว ทัชสกรีนผ่านทุกจุด สามารถลอกเฉพาะกระจกได้',
                        'performed_by' => 'ช่างธีรเดช (036)',
                        'time' => Carbon::now()->subHours(10),
                    ],
                    [
                        'status' => 'waiting_parts',
                        'title' => 'สั่งเบิกกระจกจอแท้ตรงรุ่น',
                        'note' => 'รอรับอะไหล่จากคลังหลัก คาดว่าจะเริ่มกระบวนการลอกกระจกช่วงบ่ายวันนี้',
                        'performed_by' => 'ช่างธีรเดช (036)',
                        'time' => Carbon::now()->subHours(5),
                    ],
                ],
            ],

            // Ticket 5: กำลังตรวจเช็ค (Inspecting)
            [
                'ticket_number' => 'REP-202610-005',
                'customer' => $customers[4], // ณภัทร
                'phone_model' => $models['iPhone 11'],
                'repair_service' => $services['เปลี่ยนแพรชาร์จ / ก้นชาร์จหลวม ชาร์จไฟไม่เข้า'],
                'device_color' => 'Black (ดำ)',
                'imei_serial' => '358291048291049',
                'device_passcode' => '000000',
                'symptom_description' => 'เสียบสายชาร์จไฟไม่เข้า ต้องคอยดัดสายเอียงๆ ไมโครโฟนเวลาโทรคุยปลายทางบอกไม่ค่อยได้ยิน',
                'device_condition' => 'พอร์ตชาร์จมีฝุ่นอัดแน่น ด้านหลังมีรอยขูดขีดตามการใช้งาน',
                'service_type' => 'walk_in',
                'status' => 'inspecting',
                'priority' => 'normal',
                'estimated_cost' => 1200,
                'final_cost' => null,
                'technician_notes' => 'กำลังใช้กล้องไมโครสโคปส่องทำความสะอาดพอร์ต และวัดค่าความต้านทานขากราวด์',
                'assigned_to' => $frontendDev->id,
                'warranty_until' => null,
                'completed_at' => null,
                'logs' => [
                    [
                        'status' => 'pending',
                        'title' => 'รับเครื่องเข้าคิวตรวจสอบ',
                        'note' => 'รับเครื่องจากนักศึกษา NPRU (ให้ส่วนลดพิเศษ 10%)',
                        'performed_by' => 'ภูมิพัฒน์ (008)',
                        'time' => Carbon::now()->subHours(6),
                    ],
                    [
                        'status' => 'inspecting',
                        'title' => 'กำลังตรวจเช็คแพรชาร์จและระบบไมโครโฟน',
                        'note' => 'ส่องกล้องพบขั้วพินทองเหลืองตัวที่ 4 หักล้ม จำเป็นต้องเปลี่ยนชุดแพรชาร์จใหม่',
                        'performed_by' => 'ภูมิพัฒน์ (008)',
                        'time' => Carbon::now()->subHours(2),
                    ],
                ],
            ],

            // Ticket 6: รอรับเครื่องเข้าคิว (Pending)
            [
                'ticket_number' => 'REP-202610-006',
                'customer' => $customers[5], // อานนท์
                'phone_model' => $models['iPhone 15'],
                'repair_service' => $services['เปลี่ยนโมดูลกล้องหลังแท้ / กล้องสั่น โฟกัสไม่ได้'],
                'device_color' => 'Blue (ฟ้าอ่อน)',
                'imei_serial' => '359384729104823',
                'device_passcode' => '192837',
                'symptom_description' => 'ขี่มอเตอร์ไซค์ติดที่ยึดมือถือ แล้วกล้องหลังสั่นรัวๆ โฟกัสไม่ได้และมีเสียงหวีดในตัวเครื่อง',
                'device_condition' => 'เครื่องสภาพใหม่มาก ไม่มีรอยตก กระจกเลนส์ไม่แตก',
                'service_type' => 'online_booking',
                'status' => 'pending',
                'priority' => 'normal',
                'estimated_cost' => 2200,
                'final_cost' => null,
                'technician_notes' => 'ชุดเซนเซอร์กันสั่น OIS เสียหายจากการสั่นสะเทือนของเครื่องยนต์ เตรียมเปลี่ยนโมดูลกล้องใหม่',
                'assigned_to' => $admin->id,
                'warranty_until' => null,
                'completed_at' => null,
                'logs' => [
                    [
                        'status' => 'pending',
                        'title' => 'แจ้งซ่อมออนไลน์สำเร็จ',
                        'note' => 'ลูกค้านัดหมายนำเครื่องเข้ามาส่งช่วงเย็นวันนี้',
                        'performed_by' => 'ระบบอัตโนมัติ (Online Booking)',
                        'time' => Carbon::now()->subHours(3),
                    ],
                ],
            ],

            // Ticket 7: กำลังซ่อม Face ID
            [
                'ticket_number' => 'REP-202610-007',
                'customer' => $customers[6], // ศิริพร
                'phone_model' => $models['iPhone 13'],
                'repair_service' => $services['ซ่อมระบบ Face ID / เซนเซอร์ TrueDepth'],
                'device_color' => 'Pink (ชมพู)',
                'imei_serial' => '356291847291048',
                'device_passcode' => '741852',
                'symptom_description' => 'สแกนหน้าไม่ได้ ขึ้นว่าระบบ Face ID ไม่พร้อมใช้งาน หลังโดนละอองฝน',
                'device_condition' => 'รอบตัวเครื่องสภาพดี ติดฟิล์มถนอมสายตา',
                'service_type' => 'walk_in',
                'status' => 'repairing',
                'priority' => 'urgent',
                'estimated_cost' => 1900,
                'final_cost' => null,
                'technician_notes' => 'ชิป Dot Projector โดนความชื้น กำลังทำการเชื่อมต่อแพรเสริม JCID เพื่อเขียนข้อมูลดั้งเดิมทับ',
                'assigned_to' => $admin->id,
                'warranty_until' => null,
                'completed_at' => null,
                'logs' => [
                    [
                        'status' => 'pending',
                        'title' => 'รับเครื่องแจ้งอาการ Face ID เสีย',
                        'note' => 'บันทึกข้อมูลอาการและเช็คฟังก์ชันกล้องหน้าทั่วไปยังใช้งานได้',
                        'performed_by' => 'เจ้าหน้าที่เคาน์เตอร์ (008)',
                        'time' => Carbon::now()->subDays(1)->setTime(13, 0),
                    ],
                    [
                        'status' => 'inspecting',
                        'title' => 'ตรวจเช็คด้วยกล่องโปรแกรมเมอร์ JCID',
                        'note' => 'พบไดโอดเลเซอร์ชุด Dot Projector ลัดวงจร ข้อมูลใบหน้าใน EEPROM ยังสมบูรณ์',
                        'performed_by' => 'ช่างธีรเดช (036)',
                        'time' => Carbon::now()->subDays(1)->setTime(15, 30),
                    ],
                    [
                        'status' => 'repairing',
                        'title' => 'ดำเนินการเปลี่ยนแพรและกู้ข้อมูลเซนเซอร์ Face ID',
                        'note' => 'ช่างกำลังใช้กล้องไมโครสโคปบัดกรีเชื่อมแพรแท้ใหม่',
                        'performed_by' => 'ช่างธีรเดช (036)',
                        'time' => Carbon::now()->subHours(1),
                    ],
                ],
            ],

            // Ticket 8: ยิงเลเซอร์ฝาหลังเสร็จแล้ว รอรับเครื่อง
            [
                'ticket_number' => 'REP-202610-008',
                'customer' => $customers[7], // กฤษฎา
                'phone_model' => $models['iPhone 16 Pro'],
                'repair_service' => $services['เปลี่ยนฝาหลังกระจกด้วยระบบ Laser'],
                'device_color' => 'Desert Titanium (ไทเทเนียมทะเลทราย)',
                'imei_serial' => '359918274619283',
                'device_passcode' => '963852',
                'symptom_description' => 'กระจกฝาหลังแตกละเอียดจากการกระแทก ต้องการเปลี่ยนให้เหมือนใหม่งานเนียนๆ',
                'device_condition' => 'กระจกฝาหลังแตกร้าวทั้งแผ่น หน้าจอและกล้องไม่เสียหาย',
                'service_type' => 'walk_in',
                'status' => 'completed',
                'priority' => 'normal',
                'estimated_cost' => 2000,
                'final_cost' => 2000,
                'technician_notes' => 'ยิงเลเซอร์ลอกกาวดำเดิมออกจนสะอาด ติดกระจกฝาหลังแท้เกรดโรงงานพร้อมอัดกาวกันน้ำเรียบร้อย',
                'assigned_to' => $admin->id,
                'warranty_until' => Carbon::now()->addDays(90),
                'completed_at' => Carbon::now()->subHours(1),
                'logs' => [
                    [
                        'status' => 'pending',
                        'title' => 'รับเครื่องเข้าซ่อมฝาหลังแตก',
                        'note' => 'ติดสติ๊กเกอร์กันรอยรอบขอบและกล้องก่อนนำเข้าเครื่องเลเซอร์',
                        'performed_by' => 'ภูมิพัฒน์ (008)',
                        'time' => Carbon::now()->subHours(8),
                    ],
                    [
                        'status' => 'repairing',
                        'title' => 'นำเข้าเครื่องยิง Laser ลอกกาว',
                        'note' => 'ตั้งค่าพารามิเตอร์เลเซอร์ตรงรุ่น iPhone 16 Pro ไม่ส่งผลกระทบต่อแบตเตอรี่และชาร์จไร้สาย',
                        'performed_by' => 'ช่างศักดิ์ดา',
                        'time' => Carbon::now()->subHours(4),
                    ],
                    [
                        'status' => 'completed',
                        'title' => 'ติดฝาหลังแท้และอัดแท่นยึดกาวเสร็จสมบูรณ์',
                        'note' => 'ตัวเครื่องสวยงามเนียนตา ฟังก์ชัน MagSafe ใช้งานได้ปกติ รอส่งมอบ',
                        'performed_by' => 'ช่างธีรเดช (036)',
                        'time' => Carbon::now()->subHours(1),
                    ],
                ],
            ],
        ];

        foreach ($ticketsData as $ticketItem) {
            $logs = $ticketItem['logs'];
            unset($ticketItem['logs']);

            $ticket = RepairTicket::create([
                'ticket_number' => $ticketItem['ticket_number'],
                'customer_id' => $ticketItem['customer']->id,
                'phone_model_id' => $ticketItem['phone_model']->id,
                'repair_service_id' => $ticketItem['repair_service']->id,
                'device_color' => $ticketItem['device_color'],
                'imei_serial' => $ticketItem['imei_serial'],
                'device_passcode' => $ticketItem['device_passcode'],
                'symptom_description' => $ticketItem['symptom_description'],
                'device_condition' => $ticketItem['device_condition'],
                'service_type' => $ticketItem['service_type'],
                'status' => $ticketItem['status'],
                'priority' => $ticketItem['priority'],
                'estimated_cost' => $ticketItem['estimated_cost'],
                'final_cost' => $ticketItem['final_cost'],
                'technician_notes' => $ticketItem['technician_notes'],
                'assigned_to' => $ticketItem['assigned_to'],
                'warranty_until' => $ticketItem['warranty_until'],
                'completed_at' => $ticketItem['completed_at'],
                'delivered_at' => $ticketItem['delivered_at'] ?? null,
            ]);

            foreach ($logs as $log) {
                RepairStatusLog::create([
                    'repair_ticket_id' => $ticket->id,
                    'status' => $log['status'],
                    'title' => $log['title'],
                    'note' => $log['note'],
                    'performed_by' => $log['performed_by'],
                    'created_at' => $log['time'],
                    'updated_at' => $log['time'],
                ]);
            }
        }
    }
}
