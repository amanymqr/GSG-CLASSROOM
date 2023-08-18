<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Classwork;
use App\Models\Submission;
use GuzzleHttp\Psr7\Query;
use App\Rules\ForbiddenFile;
use Illuminate\Http\Request;
use App\Models\ClassworkUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function store(Request $request, Classwork $classwork)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => [
                'file', new ForbiddenFile('application/x-msdownload', 'application/x-httpd-php
            ')
            ]
        ]);
        $assigned = $classwork->users()->where('id', Auth::id())->exists();
        if (!$assigned) {
            abort(403);
        }
        DB::beginTransaction();
        try {
            $data = [];
            foreach ($request->file('files') as $file) {
                $data[] = [
                    'classwork_id' => $classwork->id,
                    'content' => $file->store("submissions/{$classwork->id}"),
                    'type' => 'file',

                ];
            }
            $user = Auth::user();
            $user->submissions()->createMany($data);
            ClassworkUser::where([
                'user_id' => $user->id,
                'classwork_id' => $classwork->id,

            ])->update([
                "status" => 'submitted',
                'submitted_at' => now(),
            ]);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return back()->with('msg', $e->getMessage())->with('type', 'danger');
        }

        return back()->with('msg', 'work submited successfully')->with('type', 'success');
    }

    public function file(Submission $submission)
    {

        $user = Auth::user();

        // SELECT * FROM classroom_user
        // WHERE user_id = ?
        // AND role = teacher
        // AND EXISTS (
        // SELECT 1 FROM classworks WHERE classworks.classroom_id = classroom_user.classroom_id
        // AND EXISTS (
        // SELECT 1 from submissions where submissions.classwork_id = classworks.id id = ?)
        // )

        $collection = DB::select('SELECT * FROM classroom_user
        WHERE user_id = ?
        AND role = ?
        AND EXISTS (
        SELECT 1 FROM classworks WHERE classworks.classroom_id = classroom_user.classroom_id
        AND EXISTS (
        SELECT 1 from submissions where submissions.classwork_id = classworks.id AND id = ?)
        )
        ', [$user->id, 'teacher', $submission->id]);
        // dd($collection);
        $isTeacher = $submission->classwork->classroom->teachers()->where('id', $user->id)->exists();
        $isOwner = $submission->user_id == $user->id;
        if (!$isTeacher && !$isOwner) {
            abort(403);
        }

        // return Storage::disk('local')->download($submission->content);
        return response()->file(storage_path('app/' .  $submission->content));
    }
}