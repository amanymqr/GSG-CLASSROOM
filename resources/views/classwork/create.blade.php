@extends('layouts.master')
@section('title', 'show classwork')

@section('content')


    <div class="container mt-5">

        <h3 style="font-size: 35px">{{ $classroom->name }} ( # {{ $classroom->id }}) </h3>
        <h4>Create Classwork</h4>

        <form action="{{ route('classroom.classwork.store', [$classroom->id, 'type' => $type]) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-8">

                    <x-form.floating-control name="title" placeholder="title">
                        <x-form.input name="title" value="" placeholder="title" />
                    </x-form.floating-control>

                    <x-form.floating-control name="description" placeholder="description">
                        <x-form.textarea name="description" value="" placeholder="description" />
                    </x-form.floating-control>
                </div>
                <div class="col-md-4">
                    @foreach ($classroom->students as $student)
                        <div class="form-check">
                            <input name="students[]" class="form-check-input" type="checkbox" value="{{ $student->id }}" id="std-{{ $student->id }}" checked>
                            <label class="form-check-label" for="std-{{ $student->id }}">
                                {{ $student->name }}
                            </label>
                        </div>
                    @endforeach

                    <select class="form-select" name="topic_id" id="topic_id">
                        <option value="">no topic</option>
                        @foreach ($classroom->topics as $topic)
                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>







            <button class="btn btn-secondary" type="submit">create</button>



        </form>




    @stop