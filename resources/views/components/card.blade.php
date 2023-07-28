@props([
    'classroom', // object,
])

<div class="col-md-4 col-sm-6 mb-3">
    <a href="{{ route('classroom.show', $classroom->id) }}" class="text-decoration-none">

    <div class="card shadow" style="width: 100%; position: relative;">
        @if ($classroom->cover_image_path)
            <img src="{{ asset('storage/' . $classroom->cover_image_path) }}" class="card-img-top img-fluid"
                style="height: 150px; object-fit: cover;" alt="Classroom Cover Image">
        @endif

        <div class="card-img-overlay" style="pointer-events: none;">
            <div class="position-absolute top-9 text-white">
                <h5 class="card-title">{{ $classroom->name }}</h5>
                <p class="card-text">{{ $classroom->section }}-{{ $classroom->room }}</p>
            </div>
        </div>
        {{--  <hr class="divider" style="margin-top: 160px">  --}}
        <div class="card-body">

            <div class="d-flex justify-content-end">
                <a href="{{ route('classroom.show', $classroom->id) }}" class="btn"><i class="bi bi-arrows-fullscreen"></i></a>

                <a href="{{ route('classroom.edit', $classroom->id) }}"
                    class="btn"><i class="bi bi-pen"></i></a>

                <form action="{{ route('classroom.destroy', $classroom->id) }}" method="post" class="d-inline-block">
                    @csrf
                    @method('delete')
                    <button class="btn" onclick="return confirm('Are you sure')"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>

    </div>
    </a>
</div>

