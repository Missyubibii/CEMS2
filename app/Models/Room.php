<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_name',
        'room_address_id',
        'capacity',
        'status'
    ];

    public function roomAddress()
    {
        return $this->belongsTo(RoomAddress::class, 'room_address_id');
    }
}


