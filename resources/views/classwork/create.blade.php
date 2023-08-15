@extends('layouts.master')
@section('title', 'show classwork')

@section('content')
    {{--  <x-block-error />  --}}

    <div class="container mt-5">

        <h3 style="font-size: 35px">{{ $classroom->name }} ( # {{ $classroom->id }}) </h3>
        <h4>Create Classwork</h4>

        <form action="{{ route('classroom.classwork.store', [$classroom->id, 'type' => $type]) }}" method="post">
            @csrf
            @include('classwork._form')

            <button class="btn btn-secondary mt-4" type="submit">create</button>

        </form>




    @stop
