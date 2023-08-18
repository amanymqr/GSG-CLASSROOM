@props([
    'classroom', // object,
])

<div class="col-md-4 col-sm-6 mb-3">
    <a href="{{ route('classroom.show', $classroom->id) }}" class="text-decoration-none">

        <div class="card border-0" style="width: 100%; position: relative; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;">
            @if ($classroom->cover_image_path)
                <img src="{{ asset('storage/' . $classroom->cover_image_path) }}" class="card-img-top img-fluid border-bottom"
                    style="height: 150px; object-fit: cover;" alt="Classroom Cover Image">
                {{--  @else
        <img src="https://placehold.co/150x6" class="card-img-top img-fluid" alt="">  --}}
            @endif

            {{--  class="card-img-top img-fluid border-bottom  --}}
            <div class="card-img-overlay" style="pointer-events: none;">
                <div class="position-absolute top-9 pt-3 text-white">
                    <h5 class="card-title text-start">{{ $classroom->name }}</h5>
                    <p class="card-text text-start">{{ $classroom->section }}-{{ $classroom->room }}</p>
                </div>
            </div>

            {{--  <hr class="divider" style="margin-top: 160px">  --}}
            <div class="card-body">

                <div class="d-flex justify-content-end">
                    <a href="{{ $classroom->url }}" class="btn text-secondary btn-sm"><i
                            class="bi bi-arrows-fullscreen"></i></a>

                    <a href="{{ route('classroom.edit', $classroom->id) }}" class="btn text-primary btn-sm"><i class="bi bi-pen"></i></a>

                    <form action="{{ route('classroom.destroy', $classroom->id) }}" method="post"
                        class="d-inline-block">
                        @csrf
                        @method('delete')
                        <button class="btn  text-danger btn-sm" onclick="return confirm('Are you sure')"><i
                                class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>

        </div>
    </a>
</div>
