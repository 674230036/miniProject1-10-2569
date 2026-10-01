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
        $response->assertSee('ภูมิพัฒน์');
        $response->assertSee('ธีรเดช');
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

        // เข้าสู่ระบบด้วยบัญชีแอดมิน
        $admin = User::where('email', 'admin@irepair.com')->first();
        $loginResponse = $this->post('/login', [
            'email' => 'admin@irepair.com',
            'password' => 'admin123',
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
}
