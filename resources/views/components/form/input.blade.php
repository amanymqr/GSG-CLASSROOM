@props([
    'name', //requried
    'value' => '', //defualt value
    'type' => 'text',
])

@php
    $old_name = str_replace('[', '.', $name);
    $old_ = str_replace(']', '', $old_name);
@endphp


<input type={{ $type }} value="{{ old($old_name, $value) }}" name="{{ $name }}" id="{{ $id ?? $name }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>
{{--  ->merge([
            'type'  => 'text',
        ]) == 'type' => 'text',  --}}



