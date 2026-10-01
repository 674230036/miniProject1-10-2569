<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repair_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // e.g. REP-202610-001
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('phone_model_id')->constrained('phone_models')->cascadeOnDelete();
            $table->foreignId('repair_service_id')->nullable()->constrained('repair_services')->nullOnDelete();
            $table->string('device_color')->nullable();
            $table->string('imei_serial')->nullable();
            $table->string('device_passcode')->nullable();
            $table->text('symptom_description');
            $table->string('device_condition')->nullable(); // สภาพภายนอกเครื่อง
            $table->string('service_type')->default('online_booking'); // online_booking, walk_in, delivery
            $table->string('status')->default('pending'); // pending, inspecting, waiting_parts, repairing, completed, delivered, cancelled
            $table->string('priority')->default('normal'); // normal, urgent
            $table->decimal('estimated_cost', 10, 2)->default(0);
            $table->decimal('final_cost', 10, 2)->nullable();
            $table->text('technician_notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->date('warranty_until')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_tickets');
    }
};
