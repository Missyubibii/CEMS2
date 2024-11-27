<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
            Schema::create('rooms', function (Blueprint $table) {
                $table->id();
                $table->foreignId('room_address_id')->constrained('room_addresses')->onDelete('cascade');
                $table->integer('capacity'); // Sức chứa
                $table->enum('status', ['Còn trống', 'Đang sử dụng', 'Đang bảo trì']); // Trạng thái
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
