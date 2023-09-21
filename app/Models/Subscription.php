<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\User;
use App\concerns\HasPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory , HasPrice;
    protected $fillable = [
        'plan_id', 'user_id', 'price', 'expires_at', 'status'
    ];

    protected $cast = [
        'expires_at' => 'datetime',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
