<?php

namespace App\Models;

use App\Models\User;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stream extends Model
{
    use HasFactory , HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [ 'user_id', 'content', 'classroom_id', 'link'];
    public function getUpdatedAtColumn()
    {
    }
    // protected static function booted()
    // {
    //     // static::creating(function (Stream $stream) {
    //     //     $stream->id = Str::uuid();
    //     // });
    // }
    public function setUpdatedAt($value)
    {
        return $this;
    }

    public function classroom()
    {

        return $this->belongsTo(Classroom::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classwork()
    {

        return $this->belongsTo(Classwork::class);
    }
}
