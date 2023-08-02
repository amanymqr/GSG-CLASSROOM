<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;

class TopicsController extends Controller
{
    public function index($classroom)
    {
        $topics = Topic::where('classroom_id' , '=' , $classroom)->orderBy('name','DESC')->get();
        // $topics=$classroom->topics()->orderBy('name','DESC')->get();
        return view('topics.index', compact('topics'))->with('sucsess', 'topics created');

    }


    public function create($classroom)
    {
        return view('topics.create', [
            'topics' => new Topic(),
            'classroom' => $classroom,
        ]);
    }

    public function store(Request $request , $classroom)
    {
        $request->validate([
            'name' =>'required|max:250',]
        );
        $topics = new Topic();
        $topics->name = $request->post('name');
        $topics->save();
        return redirect()->route('topics.index')->with('msg', 'topics craeted successfully')->with('type', 'success');
    }


    public function show($id)
    {
        $topics = Topic::findOrFail($id);
        return view('topics.show', compact('topics'));
    }



    public function edit($id)
    {
        $topics = Topic::findOrFail($id);
        return view('topics.edit', compact('topics'));
    }



    public function update(Request $request, $id)
    {
        $topics = Topic::findOrFail($id);
        $request->validate([
            'name' => 'required'
        ]);

        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('topics')->ignore($topics->id),
            ],
        ]);
        $topics->update($request->all());
        return Redirect::route('topics.index')->with('msg', 'topics updated successfully')
        ->with('type', 'info');
    }



    public function destroy($id)
    {
        $topics = Topic::findOrFail($id);
        $topics->destroy($id);
        return redirect(route('topics.index'));
    }



    public function trashed()
    {
        $topics = Topic::onlyTrashed()
            ->latest('deleted_at')
            ->get();
        return view('topics.trashed', compact('topics'));
    }

    public function restore($id)
    {
        $topics = Topic::onlyTrashed()->findOrFail($id);
        $topics->restore();
        return redirect()->route('topics.index')
            ->with('msg', "topics ({$topics->name}) restore successfully")
            ->with('type', 'info');
    }

    public function forceDelete($id)
    {
        $topics = Topic::withTrashed()->findOrFail($id);
        $topics->forceDelete();

        return redirect()->route('topics.index')
            ->with('msg', "topics ({$topics->name}) restore successfully")
            ->with('type', 'success');

    }
}
