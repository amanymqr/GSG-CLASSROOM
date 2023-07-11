
@include('partisals.header')

<div class="cards-classroom m-4 text-center">
    <div class="container">
        <h1 class="m-5">My Classrooms</h1>
        <div class="row">
            @foreach ($classroom as $classroom)
                <div class="col-md-4 mb-3">

                    <div class="card" style="width: 18rem;">
                        {{--  <img src="..." class="card-img-top" alt="...">  --}}
                        <div class="card-body">
                            <h5 class="card-title">{{ $classroom->name }}</h5>
                            <p class="card-text">{{ $classroom->section }}</p>


                            <div class="text-center">
                                <a href="{{ route('classroom.show', $classroom->id) }}" class="btn btn-primary btn-sm mr-2">View</a>

                                <a href="{{ route('classroom.edit', $classroom->id) }}" class="btn btn-success btn-sm text-white mr-2">Update</a>

                                <form action="{{ route('classroom.destroy', $classroom->id) }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm text-white">Delete</button>
                                </form>
                            </div>


                        </div>
                    </div>


                </div>
            @endforeach

        </div>

    </div>

</div>

@include('partisals.footer')
