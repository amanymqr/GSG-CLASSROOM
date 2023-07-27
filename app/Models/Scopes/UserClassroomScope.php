<?php

namespace App\Models\Scopes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class UserClassroomScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if ($id = Auth::id()) {
            $builder->where('user_id', '=', $id);
        }
    }
}
//'id in(select classroom_id in from classroom_user where user_id =?)',[
    // $id
    // ]
