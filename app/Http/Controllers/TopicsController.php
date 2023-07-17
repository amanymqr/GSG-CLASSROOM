<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;

class TopicsController extends Controller
{
    public function index(Request $request)
    {
        $topics = Topic::orderBy('name','DESC')->get();
        return view('topics.index', compact('topics'))->with('sucsess', 'topic created');

    }


    public function create(Request $request)
    {
        return view('topics.create', [
            'topic' => new Topic(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|max:250',]
        );
        $topic = new Topic();
        $topic->name = $request->post('name');
        $topic->save();
        return redirect()->route('topics.index')->with('msg', 'topic craeted successfully')->with('type', 'success');
    }


    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        return view('topics.show', compact('topic'));
    }



    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        return view('topics.edit', compact('topic'));
    }



    public function update(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);
        $request->validate([
            'name' => 'required'
        ]);

        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('topics')->ignore($topic->id),
            ],
        ]);
        $topic->update($request->all());
        return Redirect::route('topics.index')->with('msg', 'topic updated successfully')
        ->with('type', 'info');
    }



    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->destroy($id);
        return redirect(route('topics.index'));
    }
}
