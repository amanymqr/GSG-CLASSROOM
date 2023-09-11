@extends('layouts.master')
@section('title', 'show classwork')

@section('style')
    <style>
        .cover {
            margin-top: -15px;
        }
    </style>
    <style>
        .pagination a {
            color: #198754;
        }


        {{--  pagination .page-item.active .page-link {
                background-color: #198754;

            }  --}} {{--  .btn1 {
                background-color: green;
                color: white;
            }
            --}} .btn1 svg {
            background-color: #198754;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            fill: white;
            padding: 5px;
            margin-right: 10px;
        }

        .accordion-header {
            border: 1px solid #eee;
            border-bottom: none;
            border-radius: 12px;
        }

        .accordion-body {
            border: 1px solid #eee;

        }

        .accordion-button.btn1 {
            background-color: #fff;
        }

        {{--  .accordion-button {
            color: #198754;
        }  --}}
    </style>
@endsection
@section('content')


    <div class="container ">

        <div class="row d-flex justify-content-center cover">
            <div class="col-md-12">
                @if ($classroom->cover_image_path)
                    <div class="my-5" style="position: relative;">
                        <img src="{{ asset('storage/' . $classroom->cover_image_path) }}"
                            class="card-img-top rounded-3 img-fluid" style="height: 250px; object-fit: cover;"
                            alt="Classroom Cover Image">
                        <div
                            style="position: absolute; bottom: 20px; left: 20px; color: white; text-shadow: 1px 1px 3px #000000b3;">
                            <h3 style="font-size: 30px">{{ $classroom->name }} Classworks </h3>
                            <h4>{{ $classroom->section }}</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 d-flex align-items-center justify-content-start">
                @can('create', ['App\\Models\\Classwork', $classroom])
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton1"
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
                @endcan


            </div>


            <div class="col-md-6">
                <form action="{{ URL::current() }}" method="get" class="row g-3 mb-0 align-items-center">
                    <div class="col">
                        <div class="input-group">
                            <input type="text" placeholder="Search" name="search" class="form-control">
                            <button class="btn btn-success btn-sm" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>


        </div>

        <div class="accordion" id="accordionExample">
            @foreach ($classwork as $classworkitem)
                <div class="accordion-item mb-3 border-0">
                    <h2 class="accordion-header" id="heading{{ $classworkitem->id }}">
                        <button class="accordion-button btn1" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $classworkitem->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $classworkitem->id }}">
                            <svg focusable="false" width="24" height="24" viewBox="0 0 24 24" class=" NMm5M hhikbc">
                                <path d="M7 15h7v2H7zm0-4h10v2H7zm0-4h10v2H7z"></path>
                                <path
                                    d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-.14 0-.27.01-.4.04a2.008 2.008 0 0 0-1.44 1.19c-.1.23-.16.49-.16.77v14c0 .27.06.54.16.78s.25.45.43.64c.27.27.62.47 1.01.55.13.02.26.03.4.03h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7-.25c.41 0 .75.34.75.75s-.34.75-.75.75-.75-.34-.75-.75.34-.75.75-.75zM19 19H5V5h14v14z">
                                </path>
                            </svg>
                            <span
                                class="text-success">{{ ucfirst($classworkitem->title) }}-{{ $classworkitem->type }}</span>
                        </button>
                    </h2>
                    <div id="collapse{{ $classworkitem->id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $classworkitem->id }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            {!! $classworkitem->description !!}
                            <a href="{{ route('classroom.classwork.edit', [$classworkitem->classroom_id, $classworkitem->id]) }}"
                                class="btn btn-sm text-primary"><i class="bi bi-pencil-square"></i></a>
                            <a href="{{ route('classroom.classwork.show', [$classworkitem->classroom_id, $classworkitem->id]) }}"
                                class="btn text-success btn-sm"><i class="bi bi-box-arrow-up-right"></i></a>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        {{ $classwork->withQueryString()->links() }}

        @push('scripts')
            <script>
                classroomId = "{{ $classroom->id }}"
            </script>
        @endpush

    @stop

