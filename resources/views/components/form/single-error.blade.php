
@props([
    'name'
])

@error('name')
    <small class="text-danger">{{ $message }}</small>
@enderror
