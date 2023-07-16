@extends('layouts.master')

@section('title' , 'cretae classrooms')
@section('content')


    <div class="container py-5">

        <h1>Create Classroom</h1>

@include('partisals.error_validation')

        <form action="{{ route('classroom.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('classroom._form',[
            'button_label'=>'create classroom'
        ])

        <div class=" mb-3">
            <input type="file" class="form-control" name="cover_image" id="cover_image" placeholder="Room">
        </div>


            <button class="btn btn-primary w-100">Create Classroom</button>
        </form>

    </div>
@stop
{{--  @class(['form-control', 'is-invalid'=>$errors->has('name')])  --}}
