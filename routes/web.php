<?php

use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PhoneModelController as AdminPhoneModelController;
use App\Http\Controllers\Admin\RepairServiceController as AdminRepairServiceController;
use App\Http\Controllers\Admin\RepairTicketController as AdminRepairTicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - ระบบแจ้งซ่อมไอโฟน (iRepair Studio)
| โครงงานพัฒนาระบบสารสนเทศ มหาวิทยาลัยราชภัฏนครปฐม (NPRU)
| - Front-end: นายภูมิพัฒน์ เกษมสุข (รหัสนักศึกษา 654230008)
| - Back-end: นายธีรเดช วงศ์สว่าง (รหัสนักศึกษา 654230036)
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. หน้าบ้าน (Front-end โดย 008)
// =========================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/price-estimator', [HomeController::class, 'priceEstimator'])->name('price.estimator');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// ตรวจสอบและติดตามสถานะงานซ่อม
Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
Route::get('/tracking/search', [TrackingController::class, 'track'])->name('tracking.search');
Route::get('/tracking/{ticket_number}', [TrackingController::class, 'show'])->name('tracking.show');
Route::get('/tracking/{ticket_number}/print', [TrackingController::class, 'printSlip'])->name('tracking.print');

// ระบบแจ้งซ่อมออนไลน์ (ลูกค้าทั่วไปไม่ต้องล็อกอิน)
Route::get('/repair/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/repair/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/repair/success/{ticket_number}', [BookingController::class, 'success'])->name('booking.success');

// =========================================================================
// 2. ระบบเข้าสู่ระบบ (Authentication)
// =========================================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// 3. ระบบหลังบ้าน (Back-end โดย 036) - ต้องผ่านการยืนยันตัวตน (auth)
// =========================================================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // หน้าสรุปภาพรวม (Dashboard)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // จัดการใบแจ้งซ่อม (Repair Tickets)
    Route::get('/tickets', [AdminRepairTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [AdminRepairTicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [AdminRepairTicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}', [AdminRepairTicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{id}/edit', [AdminRepairTicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{id}', [AdminRepairTicketController::class, 'update'])->name('tickets.update');
    Route::post('/tickets/{id}/status', [AdminRepairTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::delete('/tickets/{id}', [AdminRepairTicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/tickets/{id}/print', [AdminRepairTicketController::class, 'printSlip'])->name('tickets.print');

    // จัดการรุ่นไอโฟน (iPhone Models)
    Route::get('/models', [AdminPhoneModelController::class, 'index'])->name('models.index');
    Route::post('/models', [AdminPhoneModelController::class, 'store'])->name('models.store');
    Route::put('/models/{id}', [AdminPhoneModelController::class, 'update'])->name('models.update');
    Route::delete('/models/{id}', [AdminPhoneModelController::class, 'destroy'])->name('models.destroy');

    // จัดการบริการซ่อมและอัตราค่าบริการ (Repair Services)
    Route::get('/services', [AdminRepairServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [AdminRepairServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{id}', [AdminRepairServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [AdminRepairServiceController::class, 'destroy'])->name('services.destroy');

    // จัดการข้อมูลลูกค้า (Customers)
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [AdminCustomerController::class, 'show'])->name('customers.show');
});
