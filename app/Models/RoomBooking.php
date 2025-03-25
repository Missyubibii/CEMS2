<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Period;


class RoomBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'start_period_id',
        'end_period_id',
        'booking_date',
        'purpose',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function startPeriod()
    {
        return $this->belongsTo(Period::class, 'start_period_id');
    }

    public function endPeriod()
    {
        return $this->belongsTo(Period::class, 'end_period_id');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'room_booking_device')
                    ->withPivot('quantity');
    }

    public function isConflict(RoomBooking $newBooking)
    {
        return RoomBooking::where('room_id', $newBooking->room_id)
            ->where('booking_date', $newBooking->booking_date)
            ->where(function ($query) use ($newBooking) {
                // Kiểm tra nếu các tiết học trùng
                $query->whereBetween('start_period_id', [$newBooking->start_period_id, $newBooking->end_period_id])
                    ->orWhereBetween('end_period_id', [$newBooking->start_period_id, $newBooking->end_period_id]);
            })
            ->exists();
    }

}




