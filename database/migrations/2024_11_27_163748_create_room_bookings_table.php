<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Liên kết với bảng users
            $table->foreignId('room_id')->constrained()->onDelete('cascade'); // Liên kết với bảng rooms
            $table->foreignId('room_address_id')->constrained()->onDelete('cascade'); // Liên kết với bảng room_addresses
            $table->enum('status', ['Chờ duyệt', 'Đang mượn phòng', 'Chưa trả phòng'])->default('Chờ duyệt');
            $table->string('time_slot'); // Ví dụ: "Tiết 1, Tiết 2, Tiết 3"
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_bookings');
    }
};
