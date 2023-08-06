<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomPeopleController extends Controller
{

    public function __invoke(Classroom $classroom)  {
        return view('classroom.people' , compact(['classroom']));

    }
}
