@extends('layouts.master')
@section('title' , 'classrooms')
@section('content')

<x-alert />



<div class="cards-classroom m-4 text-center">
    <div class="container">
        <h1 class="m-5">Trashed Classrooms</h1>

        <div class="row">

            @foreach ($classroom as $classroom)
            <div class="col-4 mb-3">
                <div class="card" style="width: 18rem;">
                    @if ($classroom->cover_image_path)
                        <img src="{{ asset('storage/' . $classroom->cover_image_path) }}"
                            class="card-img-top" style="height: 100px; object-fit: cover" alt="Classroom Cover Image">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $classroom->name }}</h5>
                        <p class="card-text">{{ $classroom->section }}-{{ $classroom->room }}</p>

                        <div class="text-center">
                            <form action="{{ route('classroom.restore', $classroom->id) }}" method="post" class="d-inline-block">
                                @csrf
                                @method('put')
                                <button class="btn btn-sm btn-secondary mx-2">Restore</button>
                            </form>

                            <form action="{{ route('classroom.force-delete', $classroom->id) }}" method="post" class="d-inline-block">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm text-white" onclick="return confirm('Are you sure')">Delete Forever</button>
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
{{--  @include('partisals.footer')  --}}
@push('scripts')
<script> console.log('@ stack') </script>
@endpush
