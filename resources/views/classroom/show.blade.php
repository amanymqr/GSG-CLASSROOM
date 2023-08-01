@extends('layouts.master')
@section('title', 'show classrooms')

@section('content')


    <div class="container">
        @if ($classroom->cover_image_path)
            <div class=" my-5" style="position: relative;">
                <img src="{{ asset('storage/' . $classroom->cover_image_path) }}" class="card-img-top rounded-3 img-fluid"
                    style="height: 250px; object-fit: cover;" alt="Classroom Cover Image">
                <div
                    style="position: absolute; bottom: 20px; left: 20px; color: white; text-shadow: 1px 1px 3px #000000b3;">
                    <h3 style="font-size: 35px">{{ $classroom->name }} ( # {{ $classroom->id }}) </h3>
                    <h3>{{ $classroom->section }} </h3>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-3">
                <div class="border rounded p-3 text-center">
                    <span>class code</span>
                    <span class="text-success fs-2">{{ $classroom->code }}</span>
                </div>
            </div>
            <div class="col-md-9 ">
                <p>
                    invitation link
                    <a href="{{ $invitation_link }}">{{ $invitation_link }}</a>
                </p>

                <p>
                    <a class="btn btn-secondary" href="{{ route('classroom.classwork.index', $classroom->id) }}">classworks</a>
                </p>
            </div>
        </div>
    </div>


@endsection
