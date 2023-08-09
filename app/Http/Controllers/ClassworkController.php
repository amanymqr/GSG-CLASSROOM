<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Classwork;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            ->with('topic') //eager load
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
        return view('classwork.create', compact('classroom', 'type'));
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

        DB::transaction(function () use ($classroom, $request) {

            $classwork = $classroom->classworks()->create($request->all());
            $classwork->users()->attach($request->input('studets'));

        });
        return redirect()->route('classroom.classwork.index', $classroom->id)->with('msg', 'classwork craeted successfully')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom , Classwork $classwork)
    {
        // $classwork->load('comments.user');
        return view('classwork.show', compact('classroom','classwork' ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request , Classroom $classroom , Classwork $classwork)
    {
        $type = $this->getType($request);
        $assigned=$classwork->users()->pluck('id')->toArray();
        return view('classwork.edit', compact('classroom', 'type' ,'classwork' ,'assigned'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request , Classroom $classroom , Classwork $classwork)
    {

        $classwork->update($request->all());
        $classwork->users()->sync($request->input('studets'));
        return redirect()->route('classroom.classwork.index', ['classroom' => $classroom])
        ->with('msg', 'classwork updated successfully')
        ->with('type', 'success');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
