<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\PhoneModel;
use App\Models\RepairService;
use App\Models\RepairTicket;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepairSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * ทดสอบการเข้าถึงหน้าแรกและหน้าทั่วไปของหน้าบ้าน (008)
     */
    public function test_frontend_pages_render_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('iRepair');
        $response->assertSee('008');
        $response->assertSee('036');

        $response = $this->get('/services');
        $response->assertStatus(200);

        $response = $this->get('/price-estimator');
        $response->assertStatus(200);

        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('รัชต์พงษ์');
        $response->assertSee('ศุภนัฐ');
    }

    /**
     * ทดสอบระบบค้นหาและติดตามสถานะงานซ่อม
     */
    public function test_tracking_system_works(): void
    {
        $ticket = RepairTicket::first();

        // ค้นหาด้วย Ticket Number
        $searchResponse = $this->get('/tracking/search?keyword=' . $ticket->ticket_number);
        $searchResponse->assertRedirect('/tracking/' . $ticket->ticket_number);

        // หน้าแสดงรายละเอียดและไทม์ไลน์
        $detailResponse = $this->get('/tracking/' . $ticket->ticket_number);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee($ticket->ticket_number);
        $detailResponse->assertSee($ticket->customer->name);
    }

    /**
     * ทดสอบการส่งคำขอแจ้งซ่อมออนไลน์ (Online Booking)
     */
    public function test_customer_can_submit_online_repair(): void
    {
        $model = PhoneModel::first();
        $service = RepairService::first();

        $formData = [
            'customer_name' => 'คุณทดสอบ ระบบ',
            'customer_phone' => '088-999-7777',
            'customer_line' => 'test_line',
            'customer_email' => 'test@example.com',
            'customer_address' => 'อ.เมือง จ.นครปฐม',
            'phone_model_id' => $model->id,
            'repair_service_id' => $service->id,
            'device_color' => 'Space Black',
            'imei_serial' => '351111222333444',
            'device_passcode' => '123456',
            'symptom_description' => 'หน้าจอดับ เปิดเครื่องมีเสียงสั่น แต่ภาพไม่ขึ้น',
            'service_type' => 'online_booking',
        ];

        $response = $this->post('/repair/booking', $formData);
        $response->assertStatus(302);

        $newTicket = RepairTicket::where('imei_serial', '351111222333444')->first();
        $this->assertNotNull($newTicket);
        $this->assertEquals('pending', $newTicket->status);

        $response->assertRedirect('/repair/success/' . $newTicket->ticket_number);

        // เข้าดูหน้าแจ้งผลสำเร็จ
        $successResponse = $this->get('/repair/success/' . $newTicket->ticket_number);
        $successResponse->assertStatus(200);
        $successResponse->assertSee($newTicket->ticket_number);
    }

    /**
     * ทดสอบการเข้าสู่ระบบหลังบ้านและการทำงานของ Admin (036)
     */
    public function test_admin_authentication_and_dashboard(): void
    {
        // ถ้ายังไม่ล็อกอิน เข้าหน้า dashboard จะถูก redirect ไป login
        $guestResponse = $this->get('/admin/dashboard');
        $guestResponse->assertRedirect('/login');

        // เข้าสู่ระบบด้วยบัญชีแอดมิน (นายศุภนัฐ 674230036)
        $admin = User::where('email', '674230036@webmail.npru.ac.th')->first();
        $loginResponse = $this->post('/login', [
            'email' => '674230036@webmail.npru.ac.th',
            'password' => '674230036',
        ]);
        $loginResponse->assertRedirect('/admin/dashboard');

        // เข้าหน้าแดชบอร์ดหลังบ้าน
        $dashboardResponse = $this->actingAs($admin)->get('/admin/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('แดชบอร์ดภาพรวมระบบงานซ่อม');

        // ทดสอบหน้าจัดการตั๋ว
        $ticketsResponse = $this->actingAs($admin)->get('/admin/tickets');
        $ticketsResponse->assertStatus(200);

        // ทดสอบอัปเดตสถานะงานซ่อม
        $ticket = RepairTicket::where('status', '!=', 'completed')->first();
        $updateStatusResponse = $this->actingAs($admin)->post('/admin/tickets/' . $ticket->id . '/status', [
            'status' => 'completed',
            'log_title' => 'ทดสอบเปลี่ยนสถานะเป็นซ่อมเสร็จ',
            'log_note' => 'ผ่านการทดสอบระบบเรียบร้อยทุกฟังก์ชัน',
            'final_cost' => 2500,
            'warranty_days' => 90,
        ]);

        $updateStatusResponse->assertRedirect('/admin/tickets/' . $ticket->id);
        $this->assertEquals('completed', $ticket->fresh()->status);
        $this->assertEquals(2500, $ticket->fresh()->final_cost);

        // ทดสอบพิมพ์ใบรับเครื่อง
        $printResponse = $this->actingAs($admin)->get('/admin/tickets/' . $ticket->id . '/print');
        $printResponse->assertStatus(200);
        $printResponse->assertSee($ticket->ticket_number);
        $printResponse->assertSee('ใบรับเครื่องซ่อม');
    }

    /**
     * ทดสอบการแสดงผลหน้าสมัครสมาชิกสำหรับลูกค้า
     */
    public function test_customer_registration_page_renders_successfully(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('สมัครสมาชิกสำหรับลูกค้า');
        $response->assertSee('เบอร์โทรศัพท์มือถือ');
        $response->assertSee('เข้าสู่ระบบที่นี่');
    }

    /**
     * ทดสอบการสมัครสมาชิกลูกค้าใหม่ และเชื่อมโยงเข้าสู่ระบบอัตโนมัติ
     */
    public function test_customer_can_register_new_account_and_access_portal(): void
    {
        $regData = [
            'name' => 'คุณทดสอบ สมัครใหม่',
            'phone' => '089-999-8888',
            'email' => 'newcustomer@test.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'line_id' => 'new_line',
            'address' => 'ม.ราชภัฏนครปฐม ต.นครปฐม',
        ];

        $response = $this->post('/register', $regData);
        $response->assertRedirect('/customer/my-repairs');

        // ตรวจสอบว่ามีผู้ใช้ User สร้างขึ้นในระบบ
        $this->assertDatabaseHas('users', [
            'email' => 'newcustomer@test.com',
            'role' => 'customer',
            'phone' => '089-999-8888',
        ]);

        // ตรวจสอบว่ามีข้อมูล Customer ถูกสร้างขึ้น
        $this->assertDatabaseHas('customers', [
            'phone' => '089-999-8888',
            'email' => 'newcustomer@test.com',
        ]);

        // ตรวจสอบว่าล็อกอินอยู่ และเข้าถึงหน้า portal ได้
        $portalResponse = $this->get('/customer/my-repairs');
        $portalResponse->assertStatus(200);
        $portalResponse->assertSee('คุณทดสอบ สมัครใหม่');
        $portalResponse->assertSee('รายการเครื่องซ่อมของฉัน');
    }

    /**
     * ทดสอบการเข้าสู่ระบบของลูกค้าเดิม และนำทางไปยังหน้างานซ่อมของฉัน
     */
    public function test_customer_login_redirects_to_customer_repairs(): void
    {
        // ล็อกอินด้วยบัญชีลูกค้าจำลอง (คุณกานดา)
        $loginResponse = $this->post('/login', [
            'email' => 'kanda.rat@gmail.com',
            'password' => 'password123',
        ]);

        $loginResponse->assertRedirect('/customer/my-repairs');

        $customer = User::where('email', 'kanda.rat@gmail.com')->first();
        $portalResponse = $this->actingAs($customer)->get('/customer/my-repairs');
        $portalResponse->assertStatus(200);
        $portalResponse->assertSee('คุณกานดา รัตนวิจิตร');
        // ต้องเห็น Ticket REP-202610-001 ของคุณกานดา
        $portalResponse->assertSee('REP-202610-001');
    }

    /**
     * ทดสอบการแก้ไขข้อมูลส่วนตัวของลูกค้า
     */
    public function test_customer_can_update_profile(): void
    {
        $customer = User::where('email', 'kanda.rat@gmail.com')->first();

        $updateResponse = $this->actingAs($customer)->put('/customer/profile', [
            'name' => 'คุณกานดา รัตนวิจิตร (แก้ไข)',
            'phone' => '081-234-5678',
            'line_id' => 'kanda_new_line',
            'address' => 'บ้านเลขที่ 999 ต.พระปฐมเจดีย์ อ.เมือง จ.นครปฐม',
        ]);

        $updateResponse->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'name' => 'คุณกานดา รัตนวิจิตร (แก้ไข)',
        ]);
        $this->assertDatabaseHas('customers', [
            'phone' => '081-234-5678',
            'name' => 'คุณกานดา รัตนวิจิตร (แก้ไข)',
            'line_id' => 'kanda_new_line',
        ]);
    }
}

