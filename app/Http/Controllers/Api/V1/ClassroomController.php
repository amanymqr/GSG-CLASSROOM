<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomCollection;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ClassroomResource;
use DragonCode\Contracts\Cashier\Http\Response;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (Auth::guard('sanctum')->user()->tokenCan('classrooms.read')) {
            abort(403);
        }
        $classrooms = Classroom::with('user:id,name', 'topics')->withCount('students as students')
            ->paginate(5);

        return ClassroomResource::collection($classrooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required'],
        ]);
        $classroom = Classroom::create($request->all());
        return response()->json([
            'code' => 100,
            'message' => __('Classroom Created!'),
            'classroom' => $classroom,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.show')) {
            abort(403);
        }
        $classroom->load('user')->loadCount('students');
        return new ClassroomCollection($classroom);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.update')) {
            abort(403);
        }
        $request->validate([
            'name' => [
                'sometimes',
                'required',
                Rule::unique('classrooms')->ignore($classroom->id),
            ],
            // 'name' => ['sometimes', 'required', Rule::uniqid('classrooms', 'name')->ignore($classroom->id)],
            'section' => ['sometimes', 'required'],
        ]);

        $classroom->update($request->all());

        return [
            'code' => 100,
            'message' => __('Classroom Updated!'),
            'classroom' => $classroom,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.delete')) {
            abort(403);
        }
        Classroom::destroy($id);
        return response()->json([], 204);
    }
}
