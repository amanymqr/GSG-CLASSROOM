<?php

namespace App\Http\Controllers;

use App\Enums\classworkType;
use App\Models\Classroom;
use App\Models\Classwork;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

use function PHPSTORM_META\type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Gate;

class ClassworkController extends Controller
{
    protected function getType(Request $request)
    {
        $type = $request->query('type');
        $allowed_types = [
            Classwork::TYPE_ASSIGNMENT,
            Classwork::TYPE_MATERIAL,
            Classwork::TYPE_QUESTION,
        ];
        if (!in_array($type, $allowed_types)) {
            $type = Classwork::TYPE_ASSIGNMENT;
        }
        return $type;
    }



    public function index(Request $request, Classroom $classroom)
    {
        $this->authorize('view-Any', [Classwork::class, $classroom]);
        $classwork = $classroom->classworks()
            ->with('topic')
            ->filter($request->query())
            ->latest('published_at')->paginate(5);

        return view('classwork.index', [
            'classroom' => $classroom,
            'classwork' => $classwork
        ]);
    }



    public function create(Request $request, Classroom $classroom)
    {
        $this->authorize('create', [Classwork::class, $classroom]);
        // $response = Gate::inspect('classworks.create', [$classroom]);
        // if (!$response->allowed()) {
        //     abort(403, $response->message());
        // }
        // Gate::authorize('classworks.create', [$classroom]);
        // if (!Gate::allows('classworks.create', [$classroom])) {
        //     abort(403, 'not authorized');
        // };
        $type = $this->getType($request);

        // dd(($type));
        // $topics=$classroom->topics();
        $classwork = new Classwork();
        return view('classwork.create', compact('classroom', 'classwork', 'type'));
    }


    public function store(Request $request, Classroom $classroom)
    {
        $this->authorize('create', [Classwork::class, $classroom]);
        // if (Gate::denies('classworks.create', [$classroom])) {
        //     abort(403, 'not authorized');
        // };
        $type = $this->getType($request);

        // Validate the request data
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn () => $type == 'assignment'), 'numeric', 'min:0'],
            'options.due' => ['nullable', 'date', 'after:published_at']
        ]);
        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type->value,
        ]);


        try {
            // Use a transaction to save the classwork and related data
            DB::transaction(function () use ($classroom, $request, $type) {
                $classwork = $classroom->classworks()->create($request->all());
                $classwork->users()->attach($request->input('studets'));
            });

            // Redirect with a success message

        } catch (QueryException $e) {
            // Redirect back with an error message
            return back()
                ->with('msg',  $e->getMessage())->with('type', 'danger');
        }
        return redirect()
            ->route('classroom.classwork.index', $classroom->id)
            ->with('msg', 'Classwork created successfully')
            ->with('type', 'success');
    }




    public function show(Classroom $classroom, Classwork $classwork)
    {
        $this->authorize('view', $classwork);
        // Gate::authorize('classworks.view', [$classwork]);

        $submissions = Auth::user()
            ->submissions()
            ->where('classwork_id', $classwork->id)->get();
        // $classwork->load('comments.user');
        return view('classwork.show', compact('classroom', 'classwork', 'submissions'));
    }




    public function edit(Request $request, Classroom $classroom, Classwork $classwork)
    {

        // $type = $this->getType($request);
        // if ($classwork->getType == 'assignment') {
        //     $type = $this->getType($request);
        // } else {
        //     $type = $classwork->type;
        // }

        $classwork = $classroom->classworks()
            ->findOrFail($classwork->id);
        $this->authorize('update',  $classwork);
        $type = $classwork->type->value;
        $assigned = $classwork->users()->pluck('id')->toArray();
        return view('classwork.edit', compact('classroom', 'type', 'classwork', 'assigned'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, Classwork $classwork)
    {

        $this->authorize('update',  $classwork);
        $type = $classwork->type;
        $validate =  $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn () => $type == 'assignment' || 'question'), 'numeric', 'min:0'],
            'options.due' => ['nullable', 'date', 'after:published_at'],
        ]);
        $classwork->update($request->all());
        return view('classwork.edit', compact('classroom', 'classwork'))
            ->with('success', 'Classwork Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom, Classwork $classwork)
    {
        $this->authorize('delete',  $classwork);
    }
}
