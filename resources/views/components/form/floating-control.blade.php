

<div class="form-floating mb-3">
    {{ $slot }}
    {{--  {{ $lable }}  --}}

    <label for="{{ $name }}">{{ $placeholder }}</label>
    <x-form.single-error name="{{ $name }}" />
</div>
