<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassroomsController extends Controller
{

    public function index()
    {
        //return response/redirect/json data/file/string
        $classroom = Classroom::orderBy('id', 'DESC')->get(); //collection
        // session('sucsess');
        return view('classroom.index', compact('classroom'))->with('sucsess', 'Classroom created');
    }

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



    public function show(Classroom $classroom)
    {
        // $classroom = Classroom::findOrFail($id);
        return view('classroom.show', [
            'classroom' => $classroom,
        ]);
    }

    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        return view('classroom.edit', [
            'classroom' => $classroom
        ]);
    }

    public function update(Request $request ,$id){
        //Mass Assigment
        $classroom=Classroom::findOrFail($id);
        $classroom->update($request->all());
        return redirect()->route('classroom.index')->with('msg' ,'classroom updated successfully')->with('type', 'primary');
    }

    public function destroy($id){
        Classroom::destroy($id);
        //flash msgs
        return redirect()->route('classroom.index')->with('msg' ,'classroom deleted successfully')->with('type', 'danger');


    }
//with('msg', 'Product updated successfully')->with('type', 'info');

};
