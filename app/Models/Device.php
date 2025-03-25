<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomBookingDevice;

class Device extends Model
{
    use HasFactory;

    /**
     * Các cột có thể gán giá trị hàng loạt.
     *
     * @var array
     */
    protected $fillable = [
        'device_name',
        'quantity',
        'category',
        'status',
    ];

    public function roomBookingDevices()
    {
        return $this->hasMany(RoomBookingDevice::class);
    }

    public function roomBookings()
    {
        return $this->belongsToMany(RoomBooking::class, 'room_booking_device')
            ->withPivot('quantity');
    }

}
