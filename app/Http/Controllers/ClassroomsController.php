<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ClassroomRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ClassroomsController extends Controller
{

    public function index()
    {
        $classroom = Classroom::active()
            ->recent()
            ->get();
        return view(' classroom.index', compact('classroom'))->with('sucsess', 'Classroom created');
    }
    //---------------------------------------------------------------------------
    public function create()
    {
        return view('classroom.create', [
            'classroom' => new Classroom(),
        ]);
    }
    //---------------------------------------------------------------------------

    public function store(ClassroomRequest  $request)
    {
        // $request->validate([
        //     "name" => 'required|max:50 |min:2|string',
        //     "section"  => 'nullable|string|max:255',
        //     "subject" => 'nullable|string|max:255',
        //     "room" => 'nullable|string|max:255',
        //     "cover_image" => [
        //         'nullable',
        //         'image',
        //         Rule::dimensions([
        //             'min_width'  => 200,
        //             'min_hieght' => 200,
        //         ])
        //     ]
        // ]);

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
            $path = Classroom::uploadCoverImage($file);
            //بينشيء ملف داخل الديسك الي أنشاءته
            $request->merge([
                'cover_image_path' => $path,
            ]);
            $validated['cover_image_path'] = $path;
        }


        $request->merge([
            'code' => Str::random(8),
        ]);
        $validated['user_id']= Auth::id();
        $validated = $request->validated();

        $classroom = Classroom::create($request->all());
        return redirect()->route('classroom.index')->with('msg', 'classroom craeted successfully')->with('type', 'success');
    }



    //---------------------------------------------------------------------------


    public function show(Classroom $classroom)
    {
        // $classroom = Classroom::findOrFail($id);
        return view('classroom.show', [
            'classroom' => $classroom,
        ]);
    }


    //---------------------------------------------------------------------------


    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        return view('classroom.edit', [
            'classroom' => $classroom
        ]);
    }

    //---------------------------------------------------------------------------

    public function update(ClassroomRequest $request, $id)
    {
        $validated = $request->validated();
        $classroom = Classroom::findOrFail($id);

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image'); // UploadedFile
            $path = Classroom::uploadCoverImage($file);
            $validated['cover_image_path'] = $path;
        }
        $old = $classroom->cover_image_path;
        $classroom->update($validated);

        if ($old && $old != $classroom->cover_image_path) {
            Classroom::deleteCoverImage($old);
        }

        return redirect()
            ->route('classroom.index')
            ->with('msg', 'Classroom updated successfully')
            ->with('type', 'success');
    }


    //---------------------------------------------------------------------------
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
        // if (File::exists($classroom->cover_image_path)) {
        //     Classroom::deleteCoverImage($classroom->cover_image_path);
        // }
        return redirect()->route('classroom.index')
            ->with('msg', 'Classroom deleted successfully')
            ->with('type', 'danger');
    }

    public function trashed()
    {
        $classroom = Classroom::onlyTrashed()
            ->latest('deleted_at')
            ->get();
        return view('classroom.trashed', compact('classroom'));
    }

    public function restore($id)
    {
        $classroom = Classroom::onlyTrashed()->findOrFail($id);
        $classroom->restore();
        return redirect()->route('classroom.index')
            ->with('msg', "Classroom ({$classroom->name}) restore successfully")
            ->with('type', 'info');
    }

    public function forceDelete($id)
    {
        $classroom = Classroom::withTrashed()->findOrFail($id);
        $classroom->forceDelete();

        Classroom::deleteCoverImage($classroom->cover_image_path);
        return redirect()->route('classroom.index')
            ->with('msg', "Classroom ({$classroom->name}) restore successfully")
            ->with('type', 'success');
    }
}
