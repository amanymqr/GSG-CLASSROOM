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

            .cover {
                margin-top: -15px;
            }
        </style>

    @endsection
    @section('content')

        <div class="container">
            <div class="row d-flex justify-content-center cover">
                <div class="col-md-12">
                    @if ($classroom->cover_image_path)
                        <div class="my-5" style="position: relative;">
                            <img src="{{ asset('storage/' . $classroom->cover_image_path) }}"
                                class="card-img-top rounded-3 img-fluid" style="height: 250px; object-fit: cover;"
                                alt="Classroom Cover Image">
                            <div
                                style="position: absolute; bottom: 20px; left: 20px; color: white; text-shadow: 1px 1px 3px #000000b3;">
                                <h4 style="font-size: 35px">{{ $classroom->name }} ( # {{ $classroom->id }}) </h4>
                                <h4>{{ $classroom->section }}</h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>


            {{-- Classroom Details --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="code rounded p-4 text-center mb-4">
                        <span>class code</span><br>
                        <span class="text-success fs-4">{{ $classroom->code }}</span>
                    </div>

                </div>

                <div class="col-md-8">


                    <div class="card border-0 ms-end mb-4 join">
                        <div class="card-body">
                            <span style="font-size: 14px">
                                invitation link to Classroom :
                                <a href="{{ $invitation_link }}">{{ $invitation_link }}</a>
                            </span>


                        </div>

                    </div>


                    <a class="btn w-100 btn-outline-success mb-5"
                    href="{{ route('classroom.classwork.index', $classroom->id) }}">classworks</a>

                </div>
            </div>

        </div>
    @endsection
