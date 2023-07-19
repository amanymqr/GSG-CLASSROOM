@props([
    'name', //requried
    'value' => '', //defualt value
    'type' => 'text',
])


<input type={{ $type }} value="{{ old($name, $value) }}" name="{{ $name }}" id="{{ $id ?? $name }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>
{{--  ->merge([
            'type' => 'text',
        ]) == 'type' => 'text',  --}}



