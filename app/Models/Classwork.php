<?php

namespace App\Models;

use App\Enums\classworkType;
use App\Models\Topic;
use App\Models\Comment;
use App\Models\Classroom;
use App\Models\ClassworkUser;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classwork extends Model
{
    use HasFactory;

    //make the code more readable and maintainablep
    const TYPE_ASSIGNMENT = 'assignment';
    const TYPE_MATERIAL = 'material';
    const TYPE_QUESTION = 'question';
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';



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


    protected $casts = [
        'options' =>  'json',
        'classroom_id' => 'integer',
        'published_at' => 'datetime:Y-m-d',
        'type' => classworkType::class,


    ];

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['search'] ?? '', function ($builder, $value) {
            $builder->where('title', 'LIKE', '%' . $value . '%')
                ->orWhere('description', 'LIKE', '%' . $value . '%');
        })
            ->when($filters['type'] ?? '', function ($builder, $value) {
                $builder->where('type', 'LIKE', '%' . $value . '%');
            });
    }


    protected static function booted()
    {

        static::creating(function (Classwork $classwork) {
            if (!$classwork->published_at) {
                $classwork->published_at = now();
            }
        });
    }

    public function getPublishedDateAttribute()
    {
        if ($this->published_at)
            return $this->published_at->format('Y-m-d');
    }


    //Relations
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('grade', 'submitted_at', 'status', 'created_at')->using(ClassworkUser::class);
    }

    public function comments()
    {
        return  $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
