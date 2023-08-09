<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Comment;
use App\Models\Classroom;
use App\Models\ClassworkUser;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = ucfirst(strtolower($value));
    }
    public function email()
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => strtoupper($value),
            //new way to write Mutators&Accessors

        );
    }


    public function classrooms()
    {
        return $this->belongsToMany(
            Classroom::class,
            'classroom_user', //related model
            'classroom_id', //pivot table
            'user_id',     //fk for current model in pivot table
            'id',
            'id',
        )->wherePivot('role', 'created_at');
    }

    public function createdClassrooms()
    {
        return $this->hasMany(Classroom::class, 'user_id');
    }
    // public function classworks()
    // {
    //     return $this->hasManyThrough(
    //         Classwork::class,
    //         'App\Models\User',
    //         'id',
    //         'user_id'
    //     ); //through model

    // }

    public function classworks()
    {
        return $this->belongsToMany(Classwork::class)->using(ClassworkUser::class)->withPivot(['grade', 'status', 'submitted_at', 'created_at']);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
