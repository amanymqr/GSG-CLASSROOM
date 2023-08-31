@extends('layouts.master')
@section('title', 'show classwork')
@section('style')
    <style>
        .title {
            position: relative;
        }

        .with-icon {
            display: flex;
            align-items: center;
        }

        .icon {
            position: absolute;
            left: -30px;
            background-color: #198754;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            fill: white;
            padding: 5px;
            {{--  margin: 0 20px;  --}}
        }

        .titleType {
            margin-left: 20px;
        }

        .divider {
            width: 100%;
            color: #125e3a;
            {{--  height: 20px;  --}}
        }

        .options span {
            font-size: 12px;
        }
    </style>
@endsection
@section('content')


    <div class="container mt-5">
        <x-alert />
        <div class="row d-flex align-items-center justify-content-around">


            <div class="col-md-7">

                <div class="title">
                    <h5 class="text-success with-icon">
                        <svg focusable="false" viewBox="0 0 24 24" class="icon ">
                            <path d="M7 15h7v2H7zm0-4h10v2H7zm0-4h10v2H7z"></path>
                            <path
                                d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-.14 0-.27.01-.4.04a2.008 2.008 0 0 0-1.44 1.19c-.1.23-.16.49-.16.77v14c0 .27.06.54.16.78s.25.45.43.64c.27.27.62.47 1.01.55.13.02.26.03.4.03h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7-.25c.41 0 .75.34.75.75s-.34.75-.75.75-.75-.34-.75-.75.34-.75.75-.75zM19 19H5V5h14v14z">
                            </path>
                        </svg>
                        <span class="titleType">{{ ucfirst($classwork->title) }}-{{ $classwork->type }}
                        </span>
                    </h5>
                    <hr class="divider">
                    </hr>
                </div>

                <div class="d-flex justify-content-between options">
                    <span>{{ $classwork->options['due'] }}</span>
                    <span>{{ $classwork->options['grade'] }}</span>
                </div>


                <div>
                    {!! $classwork->description !!}

                </div>

                <hr class="divider">
                </hr>
            </div>


            <div class="col-md-4">
                @can('submissions.create', [$classwork])


                    @if ($submissions->count())
                        <div class="card  submissions text-success ">
                            <div class="card-body">
                                <h4>submissions</h4>
                                <ul>
                                    @foreach ($submissions as $submission)
                                        <li><a href="{{ route('submissions.file', $submission->id) }}">File
                                                #{{ $loop->iteration }} </a></li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body py-4">
                                <h4 class="text-success  text-center">submissions</h4>
                                <form action="{{ route('submissions.store', $classwork->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <x-form.floating-control name="files" placeholder="">
                                        <x-form.input type="file" name="files[]" multiple placeholder="select file" />
                                    </x-form.floating-control>
                                    <button type="submit" class="btn btn-success w-100">submit</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            @endcan



        </div>




        <div class="row">

            <div class="col-md-7 comments mt-2">
                <h5 class="text-success">Comments
                    <h5 />
                    <form action="{{ route('comments.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $classwork->id }}">
                        <input type="hidden" name="type" value=" classwork">
                        <div class="d-flex ">
                            <div class="col-11">
                                <x-form.floating-control name="content" placeholder="comment">
                                    <x-form.textarea name="content" :value="$classwork->content" placeholder="comment" />
                                </x-form.floating-control>
                            </div>
                            <div class="ms-1 mt-4">
                                <button class="btn btn-sm btn-outline-success" type="submit">post</button>

                            </div>
                    </form>

            </div>


            @foreach ($classwork->comments as $comment)
                <div class="card border-0 "
                    style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center  text-secondary">
                            <img class="rounded-circle " style="width: 40px"
                                src="https://ui-avatars.com/api/?name={{ $comment->user->name }}" alt="">
                            <span style="font-size: 12px" class="ms-2 mb-0">By:{{ $comment->user->name }}.
                                Time{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p style="font-size: 14px " class="ms-5 mb-0">{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach


        </div>

        {{--  <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <img class="rounded-circle"
                        src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="{{ auth()->user()->name }} Avatar">
                    <input type="text" class="form-control ms-2" placeholder="Add a comment...">
                    <button class="btn btn-primary ms-2">Post</button>
                </div>
            </div>
        </div>  --}}





    @stop
