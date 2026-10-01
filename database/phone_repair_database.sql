-- =====================================================================
-- โครงงานระบบสารสนเทศเพื่อการจัดการและติดตามงานแจ้งซ่อมโทรศัพท์เคลื่อนที่ไอโฟน
-- iRepair NPRU - iPhone Repair Service Management System
-- มหาวิทยาลัยราชภัฏนครปฐม (NPRU)
-- คณะผู้จัดทำ:
--   1. นายภูมิพัฒน์ เกษมสุข (รหัสนักศึกษา 654230008) - หน้าบ้าน (Front-end & UI/UX)
--   2. นายธีรเดช วงศ์สว่าง (รหัสนักศึกษา 654230036) - หลังบ้าน (Back-end & Database)
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `phone_repair` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `phone_repair`;

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'technician',
  `student_id` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `student_id`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'นายธีรเดช วงศ์สว่าง', 'admin@irepair.com', '$2y$12$eImiTXuWVxfM37uY4JANjOL.oUetqAHR5dGmMk/Gk9VqgI1y6s5lS', 'admin', '654230036', '089-123-4567', NOW(), NOW()),
(2, 'นายภูมิพัฒน์ เกษมสุข', 'tech008@irepair.com', '$2y$12$eImiTXuWVxfM37uY4JANjOL.oUetqAHR5dGmMk/Gk9VqgI1y6s5lS', 'technician', '654230008', '081-987-6543', NOW(), NOW()),
(3, 'ช่างศักดิ์ดา มะลิวัลย์', 'tech01@irepair.com', '$2y$12$eImiTXuWVxfM37uY4JANjOL.oUetqAHR5dGmMk/Gk9VqgI1y6s5lS', 'technician', NULL, '084-555-7890', NOW(), NOW());

-- --------------------------------------------------------
-- Table: phone_models
-- --------------------------------------------------------
DROP TABLE IF EXISTS `phone_models`;
CREATE TABLE `phone_models` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `series` varchar(255) NOT NULL,
  `release_year` int(11) DEFAULT NULL,
  `screen_size` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `base_screen_price` decimal(10,2) NOT NULL DEFAULT 2500.00,
  `base_battery_price` decimal(10,2) NOT NULL DEFAULT 1200.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `phone_models` (`id`, `name`, `series`, `release_year`, `screen_size`, `base_screen_price`, `base_battery_price`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 16 Pro Max', 'iPhone 16 Series', 2024, '6.9 นิ้ว Super Retina XDR ProMotion 120Hz', 8500.00, 2500.00, 1, NOW(), NOW()),
(2, 'iPhone 16 Pro', 'iPhone 16 Series', 2024, '6.3 นิ้ว Super Retina XDR ProMotion 120Hz', 7500.00, 2400.00, 1, NOW(), NOW()),
(3, 'iPhone 16', 'iPhone 16 Series', 2024, '6.1 นิ้ว Super Retina XDR OLED', 5900.00, 2200.00, 1, NOW(), NOW()),
(4, 'iPhone 15 Pro Max', 'iPhone 15 Series', 2023, '6.7 นิ้ว Super Retina XDR ProMotion', 6900.00, 2200.00, 1, NOW(), NOW()),
(5, 'iPhone 15 Pro', 'iPhone 15 Series', 2023, '6.1 นิ้ว Super Retina XDR ProMotion', 6500.00, 2100.00, 1, NOW(), NOW()),
(6, 'iPhone 15 Plus', 'iPhone 15 Series', 2023, '6.7 นิ้ว Super Retina XDR', 4900.00, 1900.00, 1, NOW(), NOW()),
(7, 'iPhone 15', 'iPhone 15 Series', 2023, '6.1 นิ้ว Dynamic Island Super Retina XDR', 4500.00, 1900.00, 1, NOW(), NOW()),
(8, 'iPhone 14 Pro Max', 'iPhone 14 Series', 2022, '6.7 นิ้ว Dynamic Island ProMotion', 5900.00, 1800.00, 1, NOW(), NOW()),
(9, 'iPhone 14 Pro', 'iPhone 14 Series', 2022, '6.1 นิ้ว Dynamic Island ProMotion', 5500.00, 1800.00, 1, NOW(), NOW()),
(10, 'iPhone 14', 'iPhone 14 Series', 2022, '6.1 นิ้ว Super Retina XDR', 3800.00, 1600.00, 1, NOW(), NOW()),
(11, 'iPhone 13 Pro Max', 'iPhone 13 Series', 2021, '6.7 นิ้ว Super Retina XDR ProMotion', 4900.00, 1600.00, 1, NOW(), NOW()),
(12, 'iPhone 13 Pro', 'iPhone 13 Series', 2021, '6.1 นิ้ว ProMotion จอ 120Hz', 4500.00, 1500.00, 1, NOW(), NOW()),
(13, 'iPhone 13', 'iPhone 13 Series', 2021, '6.1 นิ้ว Super Retina XDR', 3200.00, 1400.00, 1, NOW(), NOW()),
(14, 'iPhone 12 Pro Max', 'iPhone 12 Series', 2020, '6.7 นิ้ว Super Retina XDR', 3900.00, 1400.00, 1, NOW(), NOW()),
(15, 'iPhone 12 / 12 Pro', 'iPhone 12 Series', 2020, '6.1 นิ้ว OLED Super Retina', 2900.00, 1300.00, 1, NOW(), NOW()),
(16, 'iPhone 11', 'iPhone 11 Series', 2019, '6.1 นิ้ว Liquid Retina HD', 1900.00, 1200.00, 1, NOW(), NOW());

-- --------------------------------------------------------
-- Table: repair_services
-- --------------------------------------------------------
DROP TABLE IF EXISTS `repair_services`;
CREATE TABLE `repair_services` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL DEFAULT 'General',
  `icon` varchar(50) NOT NULL DEFAULT 'bi-tools',
  `description` text DEFAULT NULL,
  `estimated_duration` varchar(50) NOT NULL DEFAULT '1 - 2 ชั่วโมง',
  `warranty_period` varchar(50) NOT NULL DEFAULT '90 วัน',
  `base_price` decimal(10,2) NOT NULL DEFAULT 1000.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `repair_services` (`id`, `name`, `category`, `icon`, `description`, `estimated_duration`, `warranty_period`, `base_price`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'เปลี่ยนหน้าจอแท้ (OLED Super Retina)', 'หน้าจอ / กระจก', 'bi-phone', 'เปลี่ยนจอแท้ รองรับระบบ TrueTone สัมผัสลื่นไหล สีสันตรงตามมาตรฐาน Apple พร้อมประกันยาวนาน', '45 - 60 นาที', '180 วัน (6 เดือน)', 3500.00, 1, NOW(), NOW()),
(2, 'เปลี่ยนแบตเตอรี่แท้ มอก. (สุขภาพแบต 100%)', 'แบตเตอรี่', 'bi-battery-charging', 'แบตเตอรี่มาตรฐาน มอก. พร้อมย้ายขั้วเดิมเพื่อแสดงค่าสุขภาพแบตเตอรี่ 100% ไม่ฟ้องแจ้งเตือนสิ่งแปลกปลอม', '30 - 45 นาที', '180 วัน (6 เดือน)', 1500.00, 1, NOW(), NOW()),
(3, 'ลอกเปลี่ยนกระจกจอแท้ (รักษาจอแท้เดิม)', 'หน้าจอ / กระจก', 'bi-aspect-ratio', 'สำหรับกรณีหน้าจอด้านนอกแตก แต่การสัมผัสและภาพด้านในยังปกติ ใช้เครื่องลอก OCA อัดสูญญากาศมาตรฐานโรงงาน', '1 - 2 ชั่วโมง', '90 วัน', 1800.00, 1, NOW(), NOW()),
(4, 'ซ่อมเมนบอร์ด / อาการดับเปิดไม่ติด / บอร์ดช็อต', 'เมนบอร์ด / วงจร', 'bi-cpu', 'วิเคราะห์ด้วยกล้องอินฟราเรดตรวจจับความร้อน ซ่อม IC พาวเวอร์, บอร์ดประกบช็อต, ซ่อมลายวงจรไฟหลัก ข้อมูลไม่หาย', '1 - 3 วัน', '90 วัน', 2500.00, 1, NOW(), NOW()),
(5, 'ซ่อมระบบ Face ID / เซนเซอร์ TrueDepth', 'กล้องและเซนเซอร์', 'bi-person-bounding-box', 'แก้ปัญหาใบหน้าขึ้นไม่พร้อมใช้งาน สแกนหน้าไม่ผ่าน หลังตกกระแทกหรือโดนเหงื่อ/ละอองน้ำ ซ่อมชิป Dot Projector', '2 - 3 ชั่วโมง', '90 วัน', 1900.00, 1, NOW(), NOW()),
(6, 'เปลี่ยนโมดูลกล้องหลังแท้ / กล้องสั่น โฟกัสไม่ได้', 'กล้องและเซนเซอร์', 'bi-camera', 'แก้ไขอาการกล้องกระตุกสั่น มีเสียงดังจี๊ดๆ ภาพมัว มีจุดดำ จุดม่วง หรือเลนส์แตก เปลี่ยนอะไหล่แท้ตรงรุ่น', '45 - 60 นาที', '90 วัน', 2200.00, 1, NOW(), NOW()),
(7, 'เปลี่ยนแพรชาร์จ / ก้นชาร์จหลวม ชาร์จไฟไม่เข้า', 'ระบบไฟและชาร์จ', 'bi-lightning-charge', 'แก้ปัญหาเสียบสายชาร์จแล้วติดๆ ดับๆ ชาร์จไม่เข้า ไมค์สนทนาไม่ได้ยิน ลำโพงล่างไม่ดัง เปลี่ยนพอร์ตชาร์จคุณภาพสูง', '40 - 50 นาที', '90 วัน', 1200.00, 1, NOW(), NOW()),
(8, 'ล้างเครื่องตกน้ำ / อบไล่ความชื้น กู้ข้อมูล', 'เมนบอร์ด / วงจร', 'bi-droplet', 'ทำความสะอาดคราบขี้เกลือด้วยน้ำยา Ultrasonic ทำความสะอาดบอร์ด อบไล่ความชื้นและตรวจเช็คการกินกระแสไฟ', '1 - 2 วัน', '30 วัน', 1500.00, 1, NOW(), NOW()),
(9, 'เปลี่ยนฝาหลังกระจกด้วยระบบ Laser', 'บอดี้ / ฝาหลัง', 'bi-phone-flip', 'ยิงเลเซอร์ลอกกาวฝาหลังเดิมโดยไม่ต้องแกะเครื่องด้านใน เปลี่ยนกระจกฝาหลังเกรดแท้ แนบสนิทเหมือนใหม่', '2 - 3 ชั่วโมง', '90 วัน', 1600.00, 1, NOW(), NOW());

-- --------------------------------------------------------
-- Table: customers
-- --------------------------------------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `line_id` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_phone_index` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `line_id`, `address`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'คุณกานดา รัตนวิจิตร', '081-234-5678', 'kanda.rat@gmail.com', 'kanda_npru', '128/4 ถ.มาลัยแมน ต.ลำพยา อ.เมือง จ.นครปฐม 73000', 'ลูกค้าประจำ', NOW(), NOW()),
(2, 'คุณธนพล เจริญสุข', '086-789-0123', 'tanapol.c@hotmail.com', 'ohm_tanapol', '55 หมู่ 2 ต.กำแพงแสน อ.กำแพงแสน จ.นครปฐม 73140', 'แจ้งว่าต้องใช้งานด่วน', NOW(), NOW()),
(3, 'คุณสมชาย พงษ์ศิริ', '089-456-7890', 'somchai.p@gmail.com', 'somchai_p', '99/12 ต.ห้วยจรเข้ อ.เมือง จ.นครปฐม 73000', 'เครื่องตกพื้นคอนกรีต จอเขียว', NOW(), NOW()),
(4, 'คุณพิมพาภรณ์ ทรัพย์ทวี', '092-345-6789', 'pimpaporn.s@outlook.com', 'pim_t', '42 หมู่ 6 ต.ดอนพุทรา อ.ดอนตูม จ.นครปฐม 73150', 'กระจกหน้าจอแตก', NOW(), NOW()),
(5, 'คุณณภัทร วงศ์ษา', '085-678-9012', 'napat.w@gmail.com', 'napat_it', '15/3 ต.ศาลายา อ.พุทธมณฑล จ.นครปฐม 73170', 'นักศึกษา NPRU', NOW(), NOW()),
(6, 'คุณอานนท์ มั่นคง', '090-123-4567', 'arnon.m@gmail.com', 'arnon_m', '88/2 ต.พระปฐมเจดีย์ อ.เมือง จ.นครปฐม 73000', 'กล้องหลังสั่น โฟกัสไม่ติด', NOW(), NOW()),
(7, 'คุณศิริพร บุญเกิด', '083-456-7891', 'siriporn.b@yahoo.com', 'siri_boon', '71 หมู่ 3 ต.งิ้วราย อ.นครชัยศรี จ.นครปฐม 73120', 'สแกน Face ID ไม่ได้', NOW(), NOW()),
(8, 'คุณกฤษฎา ชื่นชม', '087-890-1234', 'kritsada.c@gmail.com', 'golf_krit', '24 หมู่ 1 ต.บางหลวง อ.บางเลน จ.นครปฐม 73130', 'เปลี่ยนฝาหลัง iPhone 16 Pro', NOW(), NOW());

-- --------------------------------------------------------
-- Table: repair_tickets
-- --------------------------------------------------------
DROP TABLE IF EXISTS `repair_tickets`;
CREATE TABLE `repair_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(50) NOT NULL UNIQUE,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `phone_model_id` bigint(20) UNSIGNED NOT NULL,
  `repair_service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `device_color` varchar(50) DEFAULT NULL,
  `imei_serial` varchar(50) DEFAULT NULL,
  `device_passcode` varchar(50) DEFAULT NULL,
  `symptom_description` text NOT NULL,
  `device_condition` varchar(255) DEFAULT NULL,
  `service_type` varchar(50) NOT NULL DEFAULT 'walk_in',
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `priority` varchar(50) NOT NULL DEFAULT 'normal',
  `estimated_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `final_cost` decimal(10,2) DEFAULT NULL,
  `technician_notes` text DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `warranty_until` date DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer` (`customer_id`),
  KEY `fk_phone_model` (`phone_model_id`),
  KEY `fk_service` (`repair_service_id`),
  KEY `fk_technician` (`assigned_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `repair_tickets` (`id`, `ticket_number`, `customer_id`, `phone_model_id`, `repair_service_id`, `device_color`, `imei_serial`, `device_passcode`, `symptom_description`, `device_condition`, `service_type`, `status`, `priority`, `estimated_cost`, `final_cost`, `technician_notes`, `assigned_to`, `warranty_until`, `completed_at`, `delivered_at`, `created_at`, `updated_at`) VALUES
(1, 'REP-202610-001', 1, 10, 2, 'Starlight (ขาวนวล)', '354892019482716', '142536', 'สุขภาพแบตเตอรี่เหลือ 71% เครื่องร้อนง่าย และมีอาการบวมเล็กน้อยจนดันขอบจอขึ้น', 'ขอบข้างมีรอยเคสกัดเล็กน้อย', 'walk_in', 'completed', 'normal', 1600.00, 1600.00, 'เปลี่ยนเซลล์แบตเตอรี่แท้ มอก. ย้ายขั้ว BMS แท้เดิม สุขภาพขึ้น 100%', 1, DATE_ADD(CURDATE(), INTERVAL 180 DAY), NOW(), NULL, NOW(), NOW()),
(2, 'REP-202610-002', 2, 4, 8, 'Natural Titanium', '359182746192834', '998877', 'เครื่องตกสระว่ายน้ำ จมน้ำประมาณ 5 นาที นำขึ้นมาเครื่องดับเปิดไม่ติด ลูกค้าต้องการกู้ข้อมูลสำคัญ', 'มีคราบไอน้ำที่เลนส์กล้อง', 'walk_in', 'repairing', 'urgent', 3500.00, NULL, 'แกะบอร์ดแยกชั้น ล้างบอร์ดด้วยคลื่นอัลตราโซนิกแล้ว กำลังซ่อมต่อลายวงจร', 1, NULL, NULL, NULL, NOW(), NOW()),
(3, 'REP-202610-003', 3, 12, 1, 'Sierra Blue (ฟ้าเซียร์ร่า)', '351239847120938', '112233', 'จอเขียวทั้งจอหลังอัปเดต iOS มีเสียงเตือนปกติ สัมผัสได้แต่ไม่เห็นภาพ', 'สภาพสวย ติดฟิล์มกระจกเดิม', 'walk_in', 'delivered', 'normal', 4500.00, 4500.00, 'ซ่อมลายจอแท้ ต่อลายสะพานไฟ 120Hz ProMotion และ TrueTone ใช้งานได้ปกติ', 2, DATE_ADD(CURDATE(), INTERVAL 90 DAY), NOW(), NOW(), NOW(), NOW()),
(4, 'REP-202610-004', 4, 15, 3, 'Purple (ม่วง)', '357283918274619', '556677', 'กระจกหน้าจอแตกร้าวจากมุมบนขวา การสัมผัสหน้าจอและจอในยังแสดงผลได้ปกติ ไม่มีเส้นดำ', 'ขอบเครื่องมีรอยตกเล็กน้อย', 'online_booking', 'waiting_parts', 'normal', 1800.00, NULL, 'สั่งกระจกหน้าจอแท้เกรดโรงงานพร้อมกาว OCA อะไหล่กำลังจัดส่งมา', 1, NULL, NULL, NULL, NOW(), NOW()),
(5, 'REP-202610-005', 5, 16, 7, 'Black (ดำ)', '358291048291049', '000000', 'เสียบสายชาร์จไฟไม่เข้า ต้องคอยดัดสายเอียงๆ ไมโครโฟนเวลาโทรคุยปลายทางบอกไม่ค่อยได้ยิน', 'พอร์ตชาร์จมีฝุ่นอัดแน่น', 'walk_in', 'inspecting', 'normal', 1200.00, NULL, 'ส่องกล้องพบขั้วพินทองเหลืองตัวที่ 4 หักล้ม เตรียมเปลี่ยนชุดแพรชาร์จใหม่', 2, NULL, NULL, NULL, NOW(), NOW()),
(6, 'REP-202610-006', 6, 7, 6, 'Blue (ฟ้าอ่อน)', '359384729104823', '192837', 'ขี่มอเตอร์ไซค์ติดที่ยึดมือถือ แล้วกล้องหลังสั่นรัวๆ โฟกัสไม่ได้และมีเสียงหวีด', 'เครื่องสภาพใหม่มาก', 'online_booking', 'pending', 'normal', 2200.00, NULL, 'ชุดกันสั่น OIS เสียหายจากการสั่นสะเทือน เตรียมเปลี่ยนกล้องแท้', 1, NULL, NULL, NULL, NOW(), NOW()),
(7, 'REP-202610-007', 7, 13, 5, 'Pink (ชมพู)', '356291847291048', '741852', 'สแกนหน้าไม่ได้ ขึ้นว่าระบบ Face ID ไม่พร้อมใช้งาน หลังโดนละอองฝน', 'รอบตัวเครื่องสภาพดี', 'walk_in', 'repairing', 'urgent', 1900.00, NULL, 'ชิป Dot Projector ช็อต กำลังใช้กล้องไมโครสโคปบัดกรีเชื่อมแพรแท้ใหม่', 1, NULL, NULL, NULL, NOW(), NOW()),
(8, 'REP-202610-008', 8, 2, 9, 'Desert Titanium', '359918274619283', '963852', 'กระจกฝาหลังแตกละเอียดจากการกระแทก ต้องการเปลี่ยนให้เหมือนใหม่งานเนียนๆ', 'กระจกฝาหลังแตกร้าวทั้งแผ่น', 'walk_in', 'completed', 'normal', 2000.00, 2000.00, 'ยิงเลเซอร์ลอกกาวดำเดิมออก ติดกระจกฝาหลังแท้เกรดโรงงานพร้อมอัดกาวกันน้ำ', 1, DATE_ADD(CURDATE(), INTERVAL 90 DAY), NOW(), NULL, NOW(), NOW());

-- --------------------------------------------------------
-- Table: repair_status_logs
-- --------------------------------------------------------
DROP TABLE IF EXISTS `repair_status_logs`;
CREATE TABLE `repair_status_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `repair_ticket_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `performed_by` varchar(100) NOT NULL DEFAULT 'เจ้าหน้าที่/ช่างซ่อม',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ticket_logs` (`repair_ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `repair_status_logs` (`id`, `repair_ticket_id`, `status`, `title`, `note`, `performed_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'pending', 'รับเครื่องเข้าศูนย์บริการ', 'ลูกค้าส่งเครื่องด้วยตัวเองหน้าร้าน ตรวจสอบสภาพภายนอกและบันทึกอาการแบตเตอรี่เสื่อม', 'เจ้าหน้าที่เคาน์เตอร์ (008)', NOW(), NOW()),
(2, 1, 'inspecting', 'ตรวจเช็คระบบไฟและเมนบอร์ด', 'วัดค่ากระแสไฟ ไม่พบการช็อตของไอซีพาวเวอร์ แบตเตอรี่เสื่อมสภาพจริง', 'ช่างธีรเดช (036)', NOW(), NOW()),
(3, 1, 'repairing', 'ดำเนินการเปลี่ยนแบตเตอรี่และเชื่อมขั้ว BMS', 'ทำการบัดกรีขั้วชิปเดิม และยิงซีลกาวแบตเตอรี่แท้มาตรฐานโรงงาน', 'ช่างธีรเดช (036)', NOW(), NOW()),
(4, 1, 'completed', 'การซ่อมเสร็จสิ้น ทดสอบระบบผ่าน 100%', 'ทดสอบชาร์จไฟเข้าปกติ สุขภาพแบตเตอรี่แสดง 100% พร้อมให้ลูกค้ามารับเครื่องได้เลย', 'ช่างธีรเดช (036)', NOW(), NOW()),
(5, 2, 'pending', 'รับเครื่องกรณีเครื่องตกน้ำด่วน', 'รับเครื่องเคสด่วน ลูกค้าไม่ได้เสียบสายชาร์จหลังตกน้ำ (ถูกต้อง)', 'เจ้าหน้าที่เคาน์เตอร์ (008)', NOW(), NOW()),
(6, 2, 'inspecting', 'แกะเปิดเครื่องและประเมินคราบน้ำ', 'พบแถบวัดความชื้นเปลี่ยนเป็นสีแดงเข้ม แกะซับความชื้นและถอดขั้วแบตเตอรี่ทันที', 'ช่างธีรเดช (036)', NOW(), NOW()),
(7, 2, 'repairing', 'แยกบอร์ด 2 ชั้นและทำความสะอาดลายวงจร', 'ใช้แท่นฮีตเตอร์แยกบอร์ด นำเข้าเครื่องล้างอัลตราโซนิกกำลังสูง ไล่ความชื้นและกำลังต่อลายวงจรช็อต', 'ช่างธีรเดช (036)', NOW(), NOW()),
(8, 3, 'pending', 'รับเครื่องตรวจสอบอาการจอขาว/จอเขียว', 'รับเครื่องจากคุณสมชาย ยืนยันอาการจอเขียวกระพริบหลังอัปเดต', 'เจ้าหน้าที่เคาน์เตอร์ (008)', NOW(), NOW()),
(9, 3, 'repairing', 'ต่อสะพานไฟจอแท้ 120Hz', 'ช่างลงมือยิงสายจัมเปอร์ไฟจอโดยไม่ต้องเปลี่ยนจอใหม่ ประหยัดเงินให้ลูกค้าได้มาก', 'ช่างศักดิ์ดา', NOW(), NOW()),
(10, 3, 'completed', 'ซ่อมจอสำเร็จ ภาพสวย คมชัด', 'ทดสอบระบบ ProMotion 120Hz และ TrueTone ใช้งานได้ 100%', 'ช่างธีรเดช (036)', NOW(), NOW()),
(11, 3, 'delivered', 'ลูกค้าตรวจรับเครื่องและชำระเงินเรียบร้อย', 'ลูกค้าทดสอบเครื่องด้วยตนเองพอใจมาก ออกใบรับประกัน 90 วันและส่งมอบเครื่อง', 'เจ้าหน้าที่เคาน์เตอร์ (008)', NOW(), NOW());
