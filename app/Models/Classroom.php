<?php

namespace App\Models;
use Exception;
use App\Models\Topic;
use App\Models\Classwork;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Observers\ClassroomObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Scopes\UserClassroomScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{

    use HasFactory, SoftDeletes;

    //to  enhance code from maintanace
    public static string $disk = 'public';

    protected $fillable = [
        'name',
        'section',
        'subject',
        'room',
        'theme',
        'cover_image_path',
        'code',
        'user_id'
    ];
    //global scope
    protected static function booted()
    {
        // static::addGlobalScope('user' , function(Builder $query){
        //     $query->where('user_id' , '=' , Auth::id());
        // });
        static::addGlobalScope(new UserClassroomScope);
        Classroom::observe(ClassroomObserver::class);
    }


    //Relations--------
    public function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class, "classroom_id", "id");
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, "classroom_id", "id");
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'classroom_user',   //pivot table
            'classroom_id',     //fk for current model in pivot table
            'user_id',          //fk for related model in pivot table
            'id',               //PK for current model
            'id',               //PK for related model
        )->withPivot(['role' , 'created_at']);

    }


    public function teachers(){
        return $this->users()->wherePivot('role' , '=' , 'teacher');
    }

    public function students(){
        return $this->users()->wherePivot('role' , '=' , 'student');
    }



    //change the route key name from id to code
    public function getRouteKeyName()
    {
        return 'id';
    }

    public static function  uploadCoverImage($file)
    {
        $path = $file->store('/covers', [
            'disk' => self::$disk,
        ]);
        return $path;
    }

    public static function  deleteCoverImage($path)
    {
        if ($path || Storage::disk(Classroom::$disk)->exists($path)) {
            return Storage::disk(Classroom::$disk)->delete($path);
        }
    }

    //local scope
    public function scopeActive(Builder $query)
    {
        $query->where('status', '=', 'active');
    }

    public function scopeRecent(Builder $query)
    {
        $query->orderBy('updated_at', 'DESC');
    }

    public function scopeStatus(Builder $query, $status = 'active')
    {
        $query->where('status', '=', $status);
    }




    public function join($user_id, $role = 'student')
    {
        $exists =$this->users()->where('user_id' , '=' , $user_id)->exists();
        if($exists){
        throw new Exception("You are already joined in this class");
        }
        return $this->users()->attach($user_id , [
            'role' => $role,
            'created_at' => now(),
        ]);

    }

    //get{{ attribute }}Attribute//accessor
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }


    public function getUrlAttribute()
    {
        return route("classroom.show", $this->id);
    }
}
