@props([
    'name', //requried
    'value' => '', //defualt value
    'type' => 'text',
])

@php
    $old_name = str_replace('[', '.', $name);
    $old_ = str_replace(']', '', $old_name);
@endphp


<input
    value="{{ old($old_name, $value) }}"
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    {{ $attributes->merge([
        'type' => 'text'
        ])
        ->class(['form-control', 'is-invalid' => $errors->has($old_name)]) }}>











{{--  ->merge([
            'type'  => 'text',
        ]) == 'type' => 'text',  --}}

{{--
        @php
        $old_name = str_replace('[', $name);
        $old_name = str_replace(']', '' $old_name);
        @endphp
        <input
        value="{{ old ($old_name, $value) }}"
        name="{{ $name }}"
        id="{{ $id ?? $name}}"
        {{ $attributes->merge([
        'type' => 'text'
        ])
        ->class(['form-control', 'is-invalid' => $errors->has ($old_name)]) }}
        >  --}}
