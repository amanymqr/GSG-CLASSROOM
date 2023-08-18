<?php

namespace App\Http\Controllers;

use App\Models\Classwork;
use App\Models\Submission;
use App\Rules\ForbiddenFile;
use Illuminate\Http\Request;
use App\Models\ClassworkUser;
use GuzzleHttp\Psr7\Query;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Throwable;

class SubmissionController extends Controller
{
    public function store(Request $request, Classwork $classwork)
    {
        $request->validate([
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
            foreach ($request->file('files') as $file) {
                Submission::create([
                    'user_id' => Auth::id(),
                    'classwork_id' => $classwork->id,
                    'content' => $file->store("submissions/{$classwork->id}"),
                    'type' => 'file',

                ]);
            }
            ClassworkUser::where([
                'user_id' => Auth::id(),
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
}
