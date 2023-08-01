@props([
    'name', //requried
    'value' => '', //defualt value
    'type' => 'text',
])


<textarea

        name="{{ $name }}"
        id="{{ $id ?? $name }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>{{ old($name, $value)  }} </textarea>
{{--  ->merge([
            'type' => 'text',
        ]) == 'type' => 'text',  --}}



