@props([
    'name', //requried
    'value' => '', //defualt value
    'type' => 'text',
    'id'
])

@php
    $old_name = str_replace('[', '.', $name);
    $old_ = str_replace(']', '', $old_name);
@endphp


<input
    value="{{ old($old_name, $value) }}"
    type={{ $type }}
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    {{ $attributes->merge([
        'type' => 'text'
        ])
        ->class(['form-control', 'is-invalid' => $errors->has($old_name)]) }}>
