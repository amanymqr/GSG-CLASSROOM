<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ClassroomPeopleController extends Controller
{

    public function index(Classroom $classroom)
    {
        // dd($classroom->users ,
        //     $classroom->classworks->first()->users);
        return view('classroom.people', compact(['classroom']));
    }
    public function destroy(Request $request, Classroom $classroom)
    {
        $request->validate([
            'user_id' => ['required', /*'exists:classroom_user,user_id'*/],
        ]);
        $user_id = $request->input('user_id');
        if ($user_id == $classroom->user_id) {
            $classroom->users()->detach($user_id);
            return redirect()->route('classroom.people', $classroom->id)
                ->with('msg', 'Cant remove user')
                ->with('type', 'danger');
        }
        $classroom->users()->detach($request->input('user_id'));
        return redirect()->route('classroom.people', $classroom->id)
            ->with('msg', 'user removed successfully')
            ->with('type', 'success');
    }
}
