@extends('layouts.master')
@section('title', 'classrooms')

@section('content')
    <div class="container mt-4">
        <h1>{{ $classroom->name }}</h1>
        <x-alert />



        <table class="table">
            <h4 class="mt-5">Teachers</h4>
            <thead>
                <tr>
                    <th></th>
                    <th>name</th>
                    <th>role</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classroom->teachers()->orderBy('name')->get() as $user)
                    <tr>
                        <td></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->pivot->role }}</td>
                        <td></td> <td><form action="{{ route('classroom.people.destroy' , $classroom->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button class="btn btn-danger">Remove</button>


                    </tr>
                @endforeach
            </tbody>

        </table>

        <table class="table ">
            <h4 class="mt-5">Students</h4>
            <thead>
                <tr>
                    <th></th>
                    <th>name</th>
                    <th>role</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classroom->students()->orderBy('name')->get() as $user)
                    <tr>
                        <td></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->pivot->role }}</td>
                        <td><form action="{{ route('classroom.people.destroy' , $classroom->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button class="btn btn-danger">Remove</button>

                        </form></td>

                    </tr>
                @endforeach
            </tbody>

        </table>



    </div>
@stop
