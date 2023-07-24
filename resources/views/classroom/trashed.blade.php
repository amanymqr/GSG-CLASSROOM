@extends('layouts.master')
@section('title' , 'classrooms')
@section('content')

<x-alert />



<div class="cards-classroom m-4 text-center">
    <div class="container">
        <h1 class="m-5">My Classrooms</h1>

        <div class="row">

            @foreach ($classroom as $classroom)
                <x-card :classroom="$classroom" />
            @endforeach

        </div>


    </div>

</div>
@stop
{{--  @include('partisals.footer')  --}}
@push('scripts')
<script> console.log('@ stack') </script>
@endpush
