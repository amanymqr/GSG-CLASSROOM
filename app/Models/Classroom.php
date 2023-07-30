<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Scopes\UserClassroomScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


        static::creating(function (Classroom $classroom) {
            $classroom->code = Str::random(8);
            $classroom->user_id = Auth::id();
        });

        static::forceDeleted(function (Classroom $classroom) {
            static::deleteCoverImage($classroom->cover_image_path);
        });
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
        DB::table('classroom_user')->insert([
            'classroom_id' => $this->id,
            'user_id' => $user_id,
            'role' => $role,
            'created_at' => now(),
        ]);
    }

    //get{{ attribute }}Attribute//accessor
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    // public function getCoverImageUrlAttribute(){
    //     if($this->cover_image_path){
    //         return Storage::disk(static::$disk)->url($this->cover_image_path);
    //     }
    //         return'https://placehold.co/100x65';
    // }

    public function getUrlAttribute()
    {
        return route("classroom.show", $this->id);
    }
}
