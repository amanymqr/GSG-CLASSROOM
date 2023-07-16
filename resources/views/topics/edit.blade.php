@include('partisals.header')

<div class="container">
    @include('partisals.flash_msg')

    <h1>Edit Topic</h1>

    <form action="{{ route('topics.update', $topic->id) }}" method="POST">
        @csrf
        @method('put')
@include('topics._form')
        <button type="submit" class="btn btn-primary">Update Topic</button>

    </form>
</div>

@include('partisals.footer')
