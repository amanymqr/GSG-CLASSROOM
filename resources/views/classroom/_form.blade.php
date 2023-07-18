<div class="form-floating mb-3">
    <x-form.input name="name" value="{{ $classroom->name }}" placeholder="Classroon Name" class="form-control" />
    <label for="name">classroom name</label>
    <x-single-error name="name" />
</div>


<div class="form-floating mb-3">
    <x-form.input name="section" value="{{ $classroom->section }}" placeholder="Classroon Section" />
    <label for="name">classroom section</label>
    <x-single-error name="section" />
</div>


<div class="form-floating mb-3">
    <x-form.input name="subject" value="{{ $classroom->subject }}" placeholder="Classroon Subject" />
    <label for="name">classroom subject</label>
    <x-single-error name="subject" />
</div>

<div class="form-floating mb-3">

    <x-form.input name="room" value="{{ $classroom->room }}" placeholder="Classroon Room" />
    <label for="name">classroom room</label>
    <x-single-error name="room" />

    {{--  <input type="text" value="{{ old('room', $classroom->room) }}"
        class="form-control @error('room')is-invalid @enderror" name="room" id="room" placeholder="Room">
    <label for="room">Room</label>
    <x-single-error name="room" />  --}}
</div>

<div class=" mb-3">
    @if ($classroom->cover_image_path)
        <img style="width: 100%; height: 120px;object-fit: cover;"
            src="{{ asset('storage/' . $classroom->cover_image_path) }}" alt="...">
    @endif
    <label for="name">classroom cover image</label>
    <x-form.input type="file" name="cover_image" value="{{ $classroom->cover_image }}" placeholder="Classroon Cover Image" />
    <x-single-error name="cover_image" />

</div>

<button type="submit" class="btn btn-primary w-100">{{ $button_label }}</button>
