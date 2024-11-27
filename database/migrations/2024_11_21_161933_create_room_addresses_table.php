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
        Schema::create('room_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('room_name'); // Tên phòng học (VD: B1-101)
            $table->foreignId('building_id')->constrained('buildings')->onDelete('cascade'); // Liên kết đến tòa nhà
            $table->foreignId('campus_id')->constrained('campuses')->onDelete('cascade');   // Liên kết đến cơ sở
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_addresses');
    }
};
