<?php

namespace App\Models;

use App\concerns\HasPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory , HasPrice;
    protected $guarded = [];

    protected $casts = [
        'data' => 'json',
    ];
}
