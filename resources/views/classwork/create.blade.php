@extends('layouts.master')
@section('title', 'show classwork')

@section('content')


    <div class="container mt-5">

        <h3 style="font-size: 35px">{{ $classroom->name }} ( # {{ $classroom->id }}) </h3>
        <h4>Create Classwork</h4>
        <form action="{{ route('classroom.classwork.store', [$classroom->id, 'type' => $type]) }}" method="post">
            @csrf


            <x-form.floating-control name="title" placeholder="title">
                <x-form.input name="title" value="" placeholder="title" />
            </x-form.floating-control>

            <x-form.floating-control name="description" placeholder="description">
                <x-form.textarea name="description" value="" placeholder="description" />
            </x-form.floating-control>
{{--
            <x-form.floating-control name="topic_id" placeholder="topic_id">
                <x-form.input name="topic_id" value="" placeholder="topic_id" />
            </x-form.floating-control>  --}}

            <select class="form-select" name="topic_id" id="topic_id">
                <option value="">no topic</option>
                    @foreach ($classroom->topics as $topic )
                        <option value="{{$topic->id }}">{{ $topic->name }}</option>
                    @endforeach
            </select>


            <button class="btn btn-secondary" type="submit">create</button>



        </form>




    @stop
