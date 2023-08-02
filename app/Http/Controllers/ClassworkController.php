<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Classwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\type;

class ClassworkController extends Controller
{
    protected function getType(Request $request)
    {
        $type = $request->query('type');
        $allowed_types = [
            Classwork::TYPE_ASSIGMENT,
            Classwork::TYPE_MATERIAL,
            Classwork::TYPE_QUESTION,
        ];
        if (!in_array($type, $allowed_types)) {
            $type = Classwork::TYPE_ASSIGMENT;
        }
        return $type;
    }


    public function index(Classroom $classroom)
    {

        $classwork = $classroom->classworks()
                ->with('topic')//eager load
                ->orderBy('published_at')->groupBy()
                ->lazy();
        return view('classwork.index', [
            'classroom' => $classroom,
            'classwork' => $classwork->groupBy('topic_id'),
        ]);
    }




    public function create(Request $request, Classroom $classroom)
    {
        $type = $this->getType($request);
        // $topics=$classroom->topics();
        return view('classwork.create', compact('classroom', 'type' ));
    }


    public function store(Request $request, Classroom $classroom)
    {
        // dd($request->all());
        $type = $this->getType($request);
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],


        ]);
        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type,
        ]);
        // dd($request->all());

        $classwork = $classroom->classworks()->create($request->all());
        return redirect()->route('classroom.classwork.index', $classroom->id)->with('msg', 'classwork craeted successfully')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
