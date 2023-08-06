<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Scopes\UserClassroomScope;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JoinClassroomController extends Controller
{


    public function create($id)
    {
        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)
            ->active()
            ->findOrFail($id);
        try {
            $this->exists($classroom, Auth::id());
        } catch (Exception $e) {
            return redirect()->route('classroom.show', $id);
        }
        return view('classroom.join', compact('classroom'));
    }



    public function store(Request $request, $id)
    {
        $request->validate([
            'role' => 'in:student ,teacher'
        ]);
        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)
            ->active()
            ->findOrFail($id);
        try {
            $this->exists($classroom, Auth::id());
        } catch (Exception $e) {
            return redirect()->route('classroom.show', $id);
        }
        $classroom->join(Auth::id(), $request->input('role', 'student'));
        return view('classroom.join', compact('classroom'));
    }


    public function exists(Classroom $classroom, $user_id)
    {
        $exists =$classroom->users()->where('user_id' , '=' , $user_id)->exists();
        if($exists){
        throw new Exception("You are already joined in this class");
        }
    }

}
