@extends('layouts.master')
@section('title', 'classrooms')

@section('content')
    <div class="container mt-4">
        <h1>{{ $classroom->name }}</h1>



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
                        <td></td>

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
                        <td></td>

                    </tr>
                @endforeach
            </tbody>

        </table>



    </div>
@stop
