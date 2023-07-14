@include('partisals.header')

<div class="container">

    <h1>Edit Topic</h1>

    <form action="{{ route('topics.update', $topic->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="name" id="name" placeholder="Topic Name"
                value="{{ $topic->name }}">
            <label for="name">Topic Name</label>
        </div>

        <button type="submit" class="btn btn-primary">Update Topic</button>

    </form>
</div>

@include('partisals.footer')
