@props([
    'name', //requried
    'value' => '', //defualt value
    'type' => 'text',
    'id' => null,
])


<textarea name="{{ $name }}"
        id="{{ $id ?? $name }}"
    {{ $attributes->merge([

    ])->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>{{ old($name, $value) }} </textarea>




