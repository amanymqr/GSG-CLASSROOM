<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ClassroomsController extends Controller
{

    public function index()
    {
        //return response/redirect/json data/file/string
        $classroom = Classroom::orderBy('id', 'DESC')->get(); //collection
        // session('sucsess');
        return view('classroom.index', compact('classroom'))->with('sucsess', 'Classroom created');
    }
//-----------------------------
    public function create()
    {
        return view('classroom.create');
    }

    public function store(Request $request)
    {
        // dd( $request->all());
        // $classroom =new Classroom();
        // $classroom->name =$request->post('name');
        // $classroom->section =$request->post('section');
        // $classroom->subject =$request->post('subject');
        // $classroom->room =$request->post('room');
        // $classroom->code =Str::random(8);
        // $classroom->save();//insert
        // return redirect()-> route('classroom.index');

        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image'); // UploadedFile
            $path = $file->store('/covers', 'public');
            //بينشيء ملف داخل الديسك الي أنشاءته
            $request->merge([
                'cover_image_path' => $path,
            ]);
        }

        $request->merge([
            'code' => Str::random(8),
        ]);
        $classroom = Classroom::create($request->all());

        return redirect()->route('classroom.index')->with('msg' ,'classroom craeted successfully')->with('type', 'success');
    }
//-------------------------------
    public function show(Classroom $classroom)
    {
        // $classroom = Classroom::findOrFail($id);
        return view('classroom.show', [
            'classroom' => $classroom,
        ]);
    }
//----------------------------------
    public function edit($id){
        $classroom = Classroom::findOrFail($id);
        return view('classroom.edit', [
            'classroom' => $classroom
        ]);
    }
//----------------------------------

// public function update(Request $request, $id)
// {
//     $classroom = Classroom::findOrFail($id);

//     if ($request->hasFile('cover_image')) {
//         // Delete the old image file
//         Storage::delete('public/' . $classroom->cover_image_path);

//         $file = $request->file('cover_image'); // Uploaded File
//         $img = $file->store('/covers', 'public');
//     }

//     // Update attributes using mass assignment
//     $classroom->update(array_merge($request->except('cover_image'), [
//         'cover_image_path' => $img ?? $classroom->cover_image_path,
//     ]));

//     return redirect()
//         ->route('classroom.index')
//         ->with('msg', 'Classroom updated successfully')
//         ->with('type', 'success');
// }

public function update(Request $request, $id)
{
    $classroom = Classroom::findOrFail($id);
    if ($request->hasFile('cover_image')) {
        // Delete the old image file

        $file = $request->file('cover_image'); // Uploaded File
        $cover_image = $file->store('/covers', 'public');
    }

    $classroom->update([
        'cover_image_path' => $cover_image,
        'section' => $request->section,
        'room' => $request->room,
        'subject' => $request->subject,
        'name' => $request->name,

    ]);

    return redirect()
        ->route('classroom.index')
        ->with('msg', 'Classroom updated successfully')
        ->with('type', 'success');
}


//-----------------------------------
public function destroy($id)
{
    $classroom = Classroom::find($id);

    if ($classroom->cover_image_path) {
        // Delete the cover image file
        Storage::delete('public/' . $classroom->cover_image_path);
    }

    Classroom::destroy($id);

    return redirect()->route('classroom.index')
        ->with('msg', 'Classroom deleted successfully')
        ->with('type', 'danger');
}

};

