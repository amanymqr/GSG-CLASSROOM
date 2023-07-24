@include('partisals.header')

<div class="container">
@include('partisals.flash_msg')

    <h1 class="text-center my-4"> Trashed Topics</h1>
    {{--  <a href="{{ route('topics.create') }}" class="btn btn-primary w-100">Create Topics <i class="fa-solid fa-plus"></i></a>
    <div class="col my-5">  --}}




        @foreach ($topics as $topics)
        <div class="card mb-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="col-md-9">
                    {{ $topics->name }}
                </div>
                <div class="col-md-3">
                    <div class="btn-group">

                        {{--  <a class="btn btn-sm btn-info mx-2 text-white" href="{{ route('topics.edit', $topics->id) }}">edit</a>  --}}
                        <form action="{{ route('topics.restore', $topics->id) }}" method="post">
                            @csrf
                            @method('put')
                            <button class="btn btn-sm btn-secondary mx-2 ">Restore</button>
                        </form>

                        <form action="{{ route('topics.force-delete', $topics->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger">Delete Forever</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach




    </div>
    @include('partisals.footer')
