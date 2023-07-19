<x-form.floating-control name="name" placeholder="Classroom Name">
    <x-form.input name="name" :value="$classroom->name" placeholder="Classroom Name" />
</x-form.floating-control>


<x-form.floating-control name="section" placeholder="Section">
    <x-form.input name="section" value="{{ $classroom->section }}" placeholder="Section" />
</x-form.floating-control>



<x-form.floating-control name="subject" placeholder="Subject">
    <x-form.input name="subject" value="{{ $classroom->subject }}" placeholder="subject" />
</x-form.floating-control>



<x-form.floating-control name="room" placeholder="Room">
    <x-form.input name="room" value="{{ $classroom->room }}" placeholder="room" />
</x-form.floating-control>



<div class=" mb-3">
    @if ($classroom->cover_image_path)
        <img style="width: 100%; height: 120px;object-fit: cover;"
            src="{{ asset('storage/' . $classroom->cover_image_path) }}" alt="...">
    @endif
    <label for="name">classroom cover image</label>
    <x-form.input type="file" name="cover_image" value="{{ $classroom->cover_image }}"
        placeholder="Classroon Cover Image" />
    <x-form.single-error name="cover_image" />
</div>


<button type="submit" class="btn btn-primary w-100">{{ $button_label }}</button>
