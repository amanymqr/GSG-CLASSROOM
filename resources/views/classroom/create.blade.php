@extends('layouts.master')

@section('title' , 'cretae classrooms')
@section('content')

    <div class="container py-5">
        <h1>Create Classroom</h1>
        <form action="{{ route('classroom.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" id="name" placeholder="name">
                <label for="name">Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="section" id="section" placeholder="section">
                <label for="section">section</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="subject">
                <label for="subject">subject</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="room" id="room" placeholder="room">
                <label for="room">room</label>
            </div>


            <div class=" mb-3">
                <input type="file" class="form-control" name="cover_image" id="cover_image" placeholder="Room">
            </div>

            <button class="btn btn-primary w-100">Create Classroom</button>
        </form>

    </div>

@stop
