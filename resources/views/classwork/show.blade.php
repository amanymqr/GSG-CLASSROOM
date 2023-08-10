@extends('layouts.master')
@section('title', 'show classwork')

@section('content')


    <div class="container mt-5">
        <h3 style="font-size: 35px">{{ $classroom->name }} ( # {{ $classroom->id }}) </h3>
        <x-alert />

        <h4>{{ $classwork->title }}</h4>
        <div>
            <p>
                {{ $classwork->description }}
            </p>
        </div>
        <h4>Comments</h4>
        {{--  <x-alert />  --}}
        <form action="{{ route('comments.store') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $classwork->id }}">
            <input type="hidden" name="type" value=" classwork">
            <div class="d-flex ">
                <div class="col-8">
                    <x-form.floating-control name="content" placeholder="comment">
                        <x-form.textarea name="content" :value="$classwork->content" placeholder="comment" />
                    </x-form.floating-control>
                </div>
                <div class="ms-1">
                    <button class="btn btn-secondary" type="submit">comment</button>

                </div>
            </div>
        </form>


        <div class="mt-4">
            @foreach ($classwork->comments as $comment)
                <div class="row">
                    <div class="col-md-2">
                        <img src="https://ui-avatars.com/api/?name={{ $comment->user->name }}" alt="">
                    </div>

                    <div class="col-md-10">
                        <p>By:{{ $comment->user->name }}. Time{{  $comment->created_at->diffForHumans() }}</p>
                        <p>{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    @stop
