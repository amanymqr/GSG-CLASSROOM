<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ClassroomRequest;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class ClassroomsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Classroom::class);
    }


    public function index()
    {
        // $this->authorize('view-any', Classroom::class);
        $classroom = Classroom::active()
            ->recent()
            // ->withoutGlobalScopes()
            ->get();
        return view('classroom.index', compact('classroom'))->with('sucsess', 'Classroom created');
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


        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image'); // UploadedFile
            $path = Classroom::uploadCoverImage($file);
            //بينشيء ملف داخل الديسك الي أنشاءته
            $request->merge([
                'cover_image_path' => $path,
            ]);
            $validated['cover_image_path'] = $path;
        }


        // $request->merge([
        //     'code' => Str::random(8),
        // ]);
        // $validated['user_id'] = Auth::id();
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $classroom = Classroom::create($request->all());
            //when create  classroom the role is teacher
            $classroom->join(Auth::id(), 'teacher');

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
        return redirect()->route('classroom.index')->with('msg', 'classroom craeted successfully')->with('type', 'success');
    }



    //---------------------------------------------------------------------------


    public function show(Classroom $classroom)
    {
        // $classroom = Classroom::findOrFail($id);
        $invitation_link = URL::temporarySignedRoute('classroom.join', now()->addHours(3), [
            'classroom' => $classroom->id,
            'code' => $classroom->id,
        ]);
        return view('classroom.show', [
            'classroom' => $classroom,
            'invitation_link' => $invitation_link,

        ]);
    }


    //---------------------------------------------------------------------------


    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        return view('classroom.edit', [
            'classroom' => $classroom,
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
        $classroom->delete();
        return redirect()->route('classroom.index')
            ->with('msg', 'Classroom deleted successfully')
            ->with('type', 'danger');
    }


    //---------------------------------------------------------------------------

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

        // Classroom::deleteCoverImage($classroom->cover_image_path);
        return redirect()->route('classroom.index')
            ->with('msg', "Classroom ({$classroom->name}) deleted for ever successfully")
            ->with('type', 'success');
    }
}
