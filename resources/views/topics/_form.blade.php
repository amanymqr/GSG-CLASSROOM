

<div class="form-floating mb-3">
    <input type="text" class="form-control  @error('name')is-invalid @enderror" value="{{ old('name', $topic->name) }}" name="name" id="name" placeholder="Topic Name"
        value="{{ $topic->name }}">
    <label for="name">Topic Name</label>
    @error('name')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
