@include('partisals.header')

<div class="container">
@include('partisals.flash_msg')

    <h1 class="text-center my-4">Topics</h1>
    <a href="{{ route('topics.create') }}" class="btn btn-primary w-100">Create Topics <i class="fa-solid fa-plus"></i></a>
    <div class="col my-5">




        @foreach ($topics as $topic)
        <div class="card mb-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="col-md-9">
                    {{ $topic->name }}
                </div>
                <div class="col-md-3">
                    <div class="btn-group">
                        <a class="btn btn-sm btn-primary mx-2" href="{{ route('topics.show', $topic->id) }}">show</a>
                        <a class="btn btn-sm btn-info mx-2 text-white" href="{{ route('topics.edit', $topic->id) }}">edit</a>
                        <form action="{{ route('topics.destroy', $topic->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach




    </div>
    @include('partisals.footer')
