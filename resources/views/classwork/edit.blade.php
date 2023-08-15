@extends('layouts.master')
@section('title', 'show classwork')

@section('content')


    <div class="container mt-5">

        <h3 style="font-size: 35px">{{ $classroom->name }} ( # {{ $classroom->id }}) </h3>
        <x-alert />

        <h4>update Classwork</h4>

        <form action="{{ route('classroom.classwork.update', [$classroom->id, $classwork->id , 'type' => $type]) }}" method="post">
            @csrf
            @method('put')


            @include('classwork._form')





            <button class="btn btn-secondary" type="submit">update</button>



        </form>




    @stop
