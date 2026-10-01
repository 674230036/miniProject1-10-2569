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
        Schema::create('repair_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->default('General');
            $table->string('icon')->default('bi-tools');
            $table->text('description')->nullable();
            $table->string('estimated_duration')->default('1 - 2 ชั่วโมง');
            $table->string('warranty_period')->default('90 วัน');
            $table->decimal('base_price', 10, 2)->default(1000);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_services');
    }
};
