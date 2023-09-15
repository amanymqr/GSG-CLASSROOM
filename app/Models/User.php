<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use App\Models\Comment;
use App\Models\Classroom;
use App\Models\Submission;
use App\Models\ClassworkUser;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, HasLocalePreference
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
            'classroom_user',   //pivot table
            'user_id',     //fk for current model in pivot table
            'classroom_id',          //fk for related model in pivot table
            'id',               //PK for current model
            'id',               //PK for related model
        )->withPivot(['role', 'created_at']);
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

    public function submission()
    {
        return $this->hasMany(Submission::class);
    }


    public function profile()
    {
        return $this->hasOne(Profile::class , 'user_id' , 'id')->withDefault();
    }

    public function routeNotificationForMail($notification = null)
    { // بنحط اسم الحقل تبع الايميل اذا كان غير email notificationعشان يعرف وين يبعت ال
        return $this->email;
    }

    public function routeNotificationForVonage($notification = null)
    {
        return '972595143154';
    }

    public function routeNotificationForHadara($notification = null)
    {
        return '972595143154';
    }

    public function recievesBroadcastNotificationsOn()
    {
        return 'Notifications.' . $this->id;
    }

    public function preferredLocale()
    {
        return $this->profile->locale;
        }
}
