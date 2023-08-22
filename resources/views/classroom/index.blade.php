@extends('layouts.master')
@section('title', 'classrooms')
@section('style')
<style>

    h3{
        color:rgb(64, 63, 66);
        }
</style>



@endsection

@section('content')

    <x-alert />



    <div class="cards-classroom m-4 text-center">
        <div class="container">
            <h3 class="m-5">My Classrooms</h3>

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
        console.log('@ stack')
    </script>
@endpush
