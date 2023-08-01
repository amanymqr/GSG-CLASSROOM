<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory , SoftDeletes;
    // protected $conn ='mysql';
    // protected $primaryKey ='id';
    // protected $keyType ='int';
    // public $incrementing =true;
    // public $timestamps= false ;
    protected $fillable = [
        'name','classroom_id','user_id'
    ];

    public function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class, "topic_id" , "id");
    }

}
