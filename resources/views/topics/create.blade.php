@include('partisals.header')

<div class="container">
    <h1 class="text-center my-4">Create Topic</h1>

    <form action="{{ route('topics.store') }}" method="POST">
        @csrf
        @include('topics._form')


        <button type="submit" class="btn btn-success w-100 my-4">Create Topic</button>

    </form>
</div>

@include('partisals.footer')
