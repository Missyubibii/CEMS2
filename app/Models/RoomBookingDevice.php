<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBookingDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_booking_id',
        'device_id',
        'quantity',
    ];

    public function roomBooking()
    {
        return $this->belongsTo(RoomBooking::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
