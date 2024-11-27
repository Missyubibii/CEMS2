<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAddress extends Model
{
    use HasFactory;

    protected $fillable = ['room_name', 'building_id', 'campus_id'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_address_id');
    }

}


