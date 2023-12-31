@extends('layouts.master')
@section('title', __('Classrooms'))

@section('style')
    <style>
        h3 {
            color: rgb(64, 63, 66);
        }
    </style>



@endsection

@section('content')

    <x-alert />
    {{--  {!! __('pagination.next') !!}


    {!! __('pagination.previous') !!}  --}}


    <div class="cards-classroom m-4 text-center">
        <div class="container">
            <h3 class="m-5">My {{ __('Classrooms') }}</h3>

            <div class="row">

                @foreach ($classroom as $classroom)
                    <x-card :classroom="$classroom" />
                @endforeach

            </div>


        </div>

    </div>
@stop
{{--  @include('partisals.footer')  --}}
@push('scripts')
    <script>
        {{--  fetch('/api/v1/classrooms')
            .then(res => res.json())
            .then(json => {
                let ul = document.getElementById('clasrooms')
                for (let i in json) {
                    ul.innerHTML += '<li>${json[i].name}</li>'
                }
            })  --}}
        console.log('@ stack')
    </script>
@endpush
