<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'commentable_type',
        'commentable_id',
        'content',
        'ip',
        'user_agent',
    ];
    protected $with=[
        'user'
    ];
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name'=>'deleted user'
        ]);
    }
    public function commentable(){
        return $this->morphTo();
        //بناء على قيمة الكومنت لارافيل بتعرف مع مين هتربط
    }
}
