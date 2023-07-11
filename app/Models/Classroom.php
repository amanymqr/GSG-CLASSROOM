<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable=[
        'name',
        'section',
        'subject',
        'room',
        'theme',
        'cover_image_path',
        'code'
    ];
    use HasFactory;
}
