
@extends('layouts.master')
@section('content')

<div class="d-flex align-items-center justify-content-center vh-100">
    <h2>{{ $classroom->name }}</h2>
    <form action="{{ route('classroom.join' , $classroom->id) }}" method="post">
        @csrf
        <button class="btn btn=primary">{{ __('join') }}</button>
    </form>
</div>
@stop
