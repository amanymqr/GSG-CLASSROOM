<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\Comment;
use App\Models\Classroom;
use App\Models\ClassworkUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classwork extends Model
{
    use HasFactory;

//make the code more readable and maintainablep
const TYPE_ASSIGMENT='assigment';
const TYPE_MATERIAL='material';
const TYPE_QUESTION='question';
const STATUS_DRAFT='draft';
const STATUS_PUBLISHED='published';
// assigment
// material
// question
    protected $fillable = [

        'classroom_id',
        'user_id',
        'topic_id',
        'title',
        'description',
        'type',
        'status',
        'published_at',
        'options',
    ];

    //Relations
    public function classroom():BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }

    public function topic():BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('grade' , 'submitted_at' , 'status' , 'created_at')->using(ClassworkUser::class);
    }

public function comments(){
    return  $this -> morphMany(Comment::class,'commentable');
}
}
