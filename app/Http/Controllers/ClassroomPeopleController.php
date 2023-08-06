<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomPeopleController extends Controller
{

    public function __invoke(Classroom $classroom)  {
        // dd($classroom->users ,
        //     $classroom->classworks->first()->users);
        return view('classroom.people' , compact(['classroom']));

    }
}
