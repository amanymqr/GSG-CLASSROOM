
@include('partisals.header')


    <div class="container">
        <h1 class="p-4 text-center">Show Details Of Classrooms</h1>

        <h3>{{ $classroom->name }} ( # {{ $classroom->id }}) </h3>
        <h3>{{ $classroom->section }} </h3>

        <div class="row">
            <div class="col-md-3">
                <div class="border rounded p-3 text-center">
                <span class="text-success fs-2">{{ $classroom->code }}</span>
                </div>
            </div>
            <div class="col-md-9">

            </div>
        </div>
    </div>
    {{--  @include('layouts.footer')  --}}

    @include('partisals.footer')
