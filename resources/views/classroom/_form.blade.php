<div class="form-floating mb-3">
    <input type="text" value="{{ old('name', $classroom->name) }}"
        class="form-control @error('name')is-invalid @enderror" name="name" id="name" placeholder="Class Name">
    <label for="name">Class Name</label>
    @error('name')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="text" value="{{ old('section', $classroom->section) }}"
        class="form-control @error('section')is-invalid @enderror" name="section" id="section" placeholder="Section">
    <label for="section">Section</label>
    @error('section')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="text" value="{{ old('subject', $classroom->subject) }}"
        class="form-control @error('subject')is-invalid @enderror" name="subject" id="subject" placeholder="Subject">
    <label for="subject">Subject</label>
    @error('subject')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-floating mb-3">
    <input type="text" value="{{ old('room', $classroom->room) }}"
        class="form-control @error('room')is-invalid @enderror" name="room" id="room" placeholder="Room">
    <label for="room">Room</label>
    @error('room')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

{{--  <div class="form-floating mb-3">
    @if ($classroom->cover_image_path)
        <img style="max-width: 100%" src="{{ Storage::disk('public')->url($classroom->cover_image_path) }}"
            alt="">
    @endif
    <input type="file" class="form-control @error('cover_image')is-invalid @enderror" name="cover_image"
        id="cover_image" placeholder="Room">
    <label for="cover_image">Cover image</label>
    @error('cover_image')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>  --}}

{{--  <button type="submit" class="btn btn-primary w-100">{{ $button_label }}</button>  --}}
