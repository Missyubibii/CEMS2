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
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('start_period_id')->constrained('periods')->onDelete('cascade');
            $table->foreignId('end_period_id')->constrained('periods')->onDelete('cascade');
            $table->date('booking_date');
            $table->text('purpose');
            $table->enum('status', ['Chờ duyệt','Từ chối duyệt', 'Đang sử dụng', 'Đã trả phòng'])->default('Chờ duyệt');
            $table->timestamps();
        });

        Schema::create('room_booking_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_booking_id')->constrained('room_bookings')->onDelete('cascade');
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_bookings');
        Schema::dropIfExists('room_booking_devices');
    }
};
