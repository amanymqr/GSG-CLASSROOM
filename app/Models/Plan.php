<?php

namespace App\Models;

use App\Models\User;
use App\Models\Features;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function features()
    {
        return $this->belongsToMany(Features::class, 'plan_feature', 'plan_id', 'feature_id')
            ->withPivot(['feature_value']);

    }

    public function price(): Attribute
    {
        return new Attribute(
            get: fn ($price) => $price / 100,
            set: fn ($price) => $price * 100,
        );
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class , 'subscriptions');
    }
}
