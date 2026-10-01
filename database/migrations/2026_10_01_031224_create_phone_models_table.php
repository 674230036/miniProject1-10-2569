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
        Schema::create('phone_models', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. iPhone 15 Pro Max
            $table->string('series'); // e.g. iPhone 15 Series
            $table->integer('release_year')->nullable();
            $table->string('screen_size')->nullable();
            $table->string('image')->nullable();
            $table->decimal('base_screen_price', 10, 2)->default(2500);
            $table->decimal('base_battery_price', 10, 2)->default(1200);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_models');
    }
};
