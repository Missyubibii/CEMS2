<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
