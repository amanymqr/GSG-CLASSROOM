

<div class="form-floating mb-3">
    <input type="text" class="form-control  @error('name')is-invalid @enderror" value="{{ old('name', $topics->name) }}" name="name" id="name" placeholder="Topic Name"
        value="{{ $topics->name }}">
    <label for="name">Topic Name</label>
    @error('name')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<button type="submit" class="btn btn-success w-100 my-4">{{ $btn }}</button>
