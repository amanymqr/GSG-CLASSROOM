@extends('layouts.master')
@section('title', 'show classwork')

@section('content')


    <div class="container mt-5">
        <h3 class="d-flex align-items-center justify-content-between" style="font-size: 35px">
            <span>{{ $classroom->name }} ( # {{ $classroom->id }})</span>
            <span class="ms-3">
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
            </span>
        </h3>

        <form action="{{ URL::current() }}" method="get" class="row row-cols-lg-auto g-3 mb-3 align-items-center">
            <div class="col- d-flex">
                <input type="text" placeholder="search" name="search" class="form-control">
                <button class="btn btn-primary ms-2" type="submit">search</button>
            </div>
        </form>
        <div class="accordion accordion-flush" id="accordionFlushExample">
            @foreach ($classwork as $classworkitem)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapse{{ $classworkitem->id }}" aria-expanded="false"
                            aria-controls="flush-collapseOne">
                            {{ $classworkitem->title }}
                        </button>
                    </h2>
                    <div id="flush-collapse{{ $classworkitem->id }}" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">{{ $classworkitem->description }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $classwork->withQueryString()->links() }}

    @stop
