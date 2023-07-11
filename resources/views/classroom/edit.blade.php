@include('partisals.header')


    <div class="container py-5">
        <h1 class="text-center">Update Classroom</h1>
        <form action="{{ route('classroom.update' , $classroom->id) }}" method="POST">
        @csrf
        @method('put')
            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{ $classroom->name }}" name="name" id="name" placeholder="name">
                <label for="name">Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{ $classroom->section }}" name="section" id="section" placeholder="section">
                <label for="section">section</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{ $classroom->subject }}" name="subject" id="subject" placeholder="subject">
                <label for="subject">subject</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{ $classroom->room }}" name="room" id="room" placeholder="room">
                <label for="room">room</label>
            </div>

            <div class=" mb-3">
                <label for="floatingInput">cover image</label>
                <input type="file" class="form-control"  name="cover_image" id="floatingInput" placeholder="cover image">
            </div>

            <button class="btn btn-primary w-100">update</button>
        </form>

    </div>

    @include('partisals.footer')


