<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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
    //-----------------------------

    public function store(Request $request)
    {
        // try{
        $request->validate([
            "name" => 'required|max:50 |min:2|string',
            "section"  => 'nullable|string|max:255',
            "subject" => 'nullable|string|max:255',
            "room" => 'nullable|string|max:255',
            "cover_image" => [
                'image',
                Rule::dimensions([
                    'min_width'  => 200,
                    'min_hieght' => 200,
                ])
            ]
        ]);
        // }catch(ValidationException $e){
        //     return redirect()
        //         ->back()
        //         ->withInput()
        //         ->withErrors($e->errors());
        // }
        // dd( $request->all());
        // $classroom =new Classroom();
        // $classroom->name =$request->post('name');
        // $classroom->section =$request->post('section');
        // $classroom->subject =$request->post('subject');
        // $classroom->room =$request->post('room');
        // $classroom->code =Str::random(8);
        // $classroom->save();//insert
        // return redirect()-> route('classroom.index');

        if ($request->hasFile('cover_image')) {
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

        return redirect()->route('classroom.index')->with('msg', 'classroom craeted successfully')->with('type', 'success');
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
    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        return view('classroom.edit', [
            'classroom' => $classroom
        ]);
    }
    //----------------------------------

    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);
        $request->validate([
            "name" => 'required|max:50 |min:2|string',
            "section"  => 'nullable|string|max:255',
            "subject" => 'nullable|string|max:255',
            "room" => 'nullable|string|max:255',
        ]);

        //my solution
        // if ($request->hasFile('cover_image')) {
        //     // Delete the old image file

        //     $file = $request->file('cover_image'); // Uploaded File
        //     $cover_image = $file->store('/covers', 'public');
        // }
        // $classroom->update([
        //     'cover_image_path' => $cover_image,
        //     'section' => $request->section,
        //     'room' => $request->room,
        //     'subject' => $request->subject,
        //     'name' => $request->name,

        // ]);

        //solution1
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image'); // UploadedFile
        //solution1
            // $name = $classroom->cover_image_path ?? (Str::length(40) . '.' . $file->getClientOriginalExtension());
            // $path = $file->storeAS('/covers', basename($name), [
            //     'disk' => 'public'
            // ]);



        //solution2
        $path = $file->store('/covers', [
            'disk' => 'public'
        ]);

        $request->merge([
            'cover_image_path' => $path,
            // update image value
        ]);

    }
        $old = $classroom->cover_image_path;
        $classroom->update($request->all());

        if ($old && $old != $classroom->cover_image_path) {
            Storage::disk('public')->delete($old);
        }


        return redirect()
            ->route('classroom.index')
            ->with('msg', 'Classroom updated successfully')
            ->with('type', 'success');
    }


    //-----------------------------------
    public function destroy($id)
    {
        $classroom = Classroom::find($id);
        //my solution
        // if ($classroom->cover_image_path) {
        //     // Delete the cover image file
        //     Storage::delete('public/' . $classroom->cover_image_path);
        // }


        //instructor solution
        $classroom->delete();
        Storage::disk('public')->delete($classroom->cover_image_path);
        return redirect()->route('classroom.index')
            ->with('msg', 'Classroom deleted successfully')
            ->with('type', 'danger');
    }
};
