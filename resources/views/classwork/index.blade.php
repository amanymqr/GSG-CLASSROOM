@extends('layouts.master')
@section('title', 'show classwork')

@section('content')


    <div class="container mt-5">

        <h3 style="font-size: 35px">{{ $classroom->name }} ( # {{ $classroom->id }}) </h3>
        <h3>classwork
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    + create
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item"
                            href="{{ route('classroom.classwork.create', ['classroom' => $classroom->id, 'type' => 'assignment']) }}">Assignment</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('classroom.classwork.create', ['classroom' => $classroom->id, 'type' => 'question']) }}">Question</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('classroom.classwork.create', ['classroom' => $classroom->id, 'type' => 'material']) }}">Material</a>
                    </li>
                </ul>


            </div>
        </h3>
        @forelse($classwork as $i => $group)
        <h3>{{ $group->first()->topic->name }}</h3>
        <div class="accordion accordion-flush" id="accordion{{ $i }}">
            @foreach ($group as $classwork)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapse{{ $classwork->id }}" aria-expanded="false"
                            aria-controls="flush-collapseOne">
                            {{ $classwork->title }}
                            /{{ $classwork->topic->name }}
                        </button>


                        {{--  <a href="{{ route('comments.store', ['classroom' => $classroom, 'classwork' => $classwork]) }}" class="btn btn-info">show</a>  --}}
                    </h2>
                    <div id="flush-collapse{{ $classwork->id }}" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingOne" data-bs-parent="#accordion{{ $i }}">
                        <div class="accordion-body">{{ $classwork->description }}</div>
                        <a href="{{ route('classroom.classwork.edit', [$classwork->classroom_id , $classwork->id]) }}" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <p>No Classworks Found!</p>
    @endforelse


    </div>
@stop
