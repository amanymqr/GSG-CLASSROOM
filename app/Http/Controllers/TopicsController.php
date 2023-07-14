<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TopicsController extends Controller
{
    public function index(Request $request)
    {
        $topics = Topic::orderBy('name','DESC')->get();
        return view('topics.index', compact('topics'));
    }


    public function create(Request $request)
    {
        return view('topics.create');
    }


    public function store(Request $request)
    {
        $topic = new Topic();
        $topic->name = $request->post('name');
        $topic->save();
        return redirect()->route('topics.index');
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
        $topic->update($request->all());
        return Redirect::route('topics.index');
    }



    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->destroy($id);
        return redirect(route('topics.index'));
    }
}
