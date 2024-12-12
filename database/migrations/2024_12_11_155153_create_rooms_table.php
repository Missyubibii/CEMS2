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
            Schema::create('rooms', function (Blueprint $table) {
                $table->id();
                $table->string('room_name');
                $table->foreignId('building_id')->constrained('buildings')->onDelete('cascade');
                $table->foreignId('campus_id')->constrained('campuses')->onDelete('cascade');
                $table->integer('capacity');
                $table->enum('status', ['Còn trống', 'Đang sử dụng', 'Đang bảo trì']);
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
};
