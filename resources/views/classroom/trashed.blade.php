@extends('layouts.master')
@section('title', 'classrooms')
@section('content')

    <x-alert />




    <div class="cards-classroom m-4 text-center">
        <div class="container">
            <h1 class="m-5">Trashed Classrooms</h1>

            <div class="row">

                    @foreach ($classroom as $classroom)
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card shadow" style="width: 100%;height: 250px;    position: relative;">
                                @if ($classroom->cover_image_path)
                                    <img src="{{ asset('storage/' . $classroom->cover_image_path) }}"
                                        class="card-img-top img-fluid" style="height: 150px; object-fit: cover;"
                                        alt="Classroom Cover Image">
                                @endif

                                <div class="card-img-overlay" style="pointer-events: none;">
                                    <div class="position-absolute top-9 text-white">
                                        <h5 class="card-title">{{ $classroom->name }}</h5>
                                        <p class="card-text">{{ $classroom->section }}-{{ $classroom->room }}</p>
                                    </div>
                                </div>

                                <div class="card-body">

                                    <div class="d-flex justify-content-end">
                                        <form action="{{ route('classroom.restore', $classroom->id) }}" method="post"
                                            class="d-inline-block">
                                            @csrf
                                            @method('put')
                                            <button class="btn btn-sm btn-secondary mx-2"><i
                                                    class="bi bi-arrow-clockwise"></i></button>
                                        </form>

                                        <form action="{{ route('classroom.force-delete', $classroom->id) }}" method="post"
                                            class="d-inline-block">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm text-white"
                                                onclick="return confirm('Are you sure')"><i
                                                    class="bi bi-trash2"></i></button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
            </div>


        </div>


    </div>


@stop
@push('scripts')
    <script>
        console.log('@ stack')
    </script>
@endpush
