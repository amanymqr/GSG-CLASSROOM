
@extends('layouts.master')
@section('title' , 'Join classroom')
@section('content')

<div class=" d-flex align-items-center justify-content-center mt-5 ">
<div class="border p-5 text-center">
    <h2 >{{ $classroom->name }}</h2>
    <form  action="{{ route('classroom.join' , $classroom->id) }}" method="post">
        @csrf
    <button type="submit" class="btn btn-primary">{{ __('join') }}</button>

</div>

    </form>
</div>
@stop
