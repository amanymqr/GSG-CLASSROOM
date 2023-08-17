    @extends('layouts.master')

    @section('title', 'show classrooms')

    @section('style')
        <style>
            .code {
                box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
            }

            .join {
                box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
            }
        </style>

    @endsection
    @section('content')


        <div class="container">
            @if ($classroom->cover_image_path)
                <div class=" my-5" style="position: relative;">
                    <img src="{{ asset('storage/' . $classroom->cover_image_path) }}" class="card-img-top rounded-3 img-fluid"
                        style="height: 250px; object-fit: cover;" alt="Classroom Cover Image">
                    <div
                        style="position: absolute; bottom: 20px; left: 20px; color: white; text-shadow: 1px 1px 3px #000000b3;">
                        <h3 style="font-size: 35px">{{ $classroom->name }} ( # {{ $classroom->id }}) </h3>
                        <h3>{{ $classroom->section }} </h3>
                    </div>
                </div>
            @endif

            {{-- Classroom Details --}}
            <div class="row">
                <div class="col-md-3">
                    <div class=" code rounded p-3 text-center">
                        <p>class code</p>
                        <span class="text-success fs-2">{{ $classroom->code }}</span>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card border-0 ms-end mb-3 join">
                        <div class="card-body">
                            <h5 class="card-title">Link to join Classroom </h5>
                            <span class="card-text">You can share this link with friend to join classroom!</span>
                            <p>
                                invitation link:
                                <a href="{{ $invitation_link }}">{{ $invitation_link }}</a>

                            </p>
                            <a class="btn btn-secondary" href="{{ route('classroom.classwork.index', $classroom->id) }}">classworks</a>

                        </div>
                    </div>
                </div>


            </div>

        </div>


    @endsection
