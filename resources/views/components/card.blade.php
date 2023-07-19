
@props([
        'classroom', //object,
    ])

<div class="col-4 mb-3">
    <div class="card" style="width: 18rem;">
        @if ($classroom->cover_image_path)
            <img src="{{ asset('storage/' . $classroom->cover_image_path) }}"
                class="card-img-top" style="height: 100px; object-fit: cover" alt="Classroom Cover Image">
        @endif

        <div class="card-body">
            <h5 class="card-title">{{ $classroom->name }}</h5>
            <p class="card-text">{{ $classroom->section }}-{{ $classroom->room }}</p>

            <div class="text-center">
                <a href="{{ route('classroom.show', $classroom->code) }}" class="btn btn-primary btn-sm mr-2">View</a>

                <a href="{{ route('classroom.edit', $classroom->id) }}" class="btn btn-success btn-sm text-white mr-2">Update</a>

                <form action="{{ route('classroom.destroy', $classroom->id) }}" method="post" class="d-inline-block">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger btn-sm text-white" onclick="return confirm('Are you sure')">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
