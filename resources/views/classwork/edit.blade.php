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
            <div class="row">
                <div class="col-md-8">

                    <x-form.floating-control name="title" placeholder="title">
                        <x-form.input name="title" :value="$classwork->title" placeholder="title" />
                    </x-form.floating-control>

                    <x-form.floating-control name="description" placeholder="description">
                        <x-form.textarea name="description" :value="$classwork->description" placeholder="description" />
                    </x-form.floating-control>
                </div>
                <div class="col-md-4">
                    @foreach ($classroom->students as $student)
                        <div class="form-check">
                            <input name="students[]" class="form-check-input" type="checkbox" value="{{ $student->id }}" id="std-{{ $student->id }}" @checked(in_array($student->id , $assigned  ))>
                            <label class="form-check-label" for="std-{{ $student->id }}">
                                {{ $student->name }}
                            </label>
                        </div>
                    @endforeach

                    <select class="form-select" name="topic_id" id="topic_id">
                        <option value="">no topic</option>
                        @foreach ($classroom->topics as $topic)
                            <option @selected($topic->id == $classwork->topic_id) value="{{ $topic->id }}">{{ $topic->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>







            <button class="btn btn-secondary" type="submit">update</button>



        </form>




    @stop
