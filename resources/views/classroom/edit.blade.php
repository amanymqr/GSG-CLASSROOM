@extends('layouts.master')
@section('title', 'edit classrooms' . $classroom->name)

@section('content')


    <div class="container py-5">
        <x-block-error />
        <h1 class="text-center">Update Classroom</h1>
        <form action="{{ route('classroom.update', $classroom->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')



            @include('classroom._form',[
                'button_label'=>'edit classroom'] )



            {{--  <img src="{{ asset('storage/' . $classroom->cover_image_path) }}" alt="...">
            <div class=" mb-3">
                <label for="floatingInput">cover image</label>
                <input type="file" class="form-control" name="cover_image" id="floatingInput" placeholder="cover image">
            </div>  --}}


            {{--  <button class="btn btn-primary w-100">update</button>  --}}
        </form>

    </div>
@stop
{{--  @include('partisals.footer')  --}}
