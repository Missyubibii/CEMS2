<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_name',
        'building_id',
        'campus_id',
        'capacity',
        'status'
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class);
    }
}


