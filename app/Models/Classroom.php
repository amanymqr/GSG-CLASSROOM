<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{

    use HasFactory , SoftDeletes;

    //to  enhance code from maintanace
    public static string $disk='public';

    protected $fillable=[
        'name',
        'section',
        'subject',
        'room',
        'theme',
        'cover_image_path',
        'code'
    ];

//change the route key name from id to code
public function getRouteKeyName()
{
    return 'code';
}

public static function  uploadCoverImage($file){
    $path = $file->store('/covers', [
        'disk' => self::$disk,
    ]);return $path;
}

public static function  deleteCoverImage($path){
if($path || Storage::disk(Classroom::$disk)->exists($path)){
    return Storage::disk(Classroom::$disk)->delete($path);
}

}
}
