@php
$_name = $attributes['name'];
$_label = $attributes['label'];
$_type = $attributes['type'] ?? 'text';
$_minlength = $attributes['minlength'];
$_min = $attributes['min'];
$_max = $attributes['max'];
$_rows = $attributes['rows'];

$_placeholder = $attributes['placeholder'];
$_old_value = old($_name);

$_value = $attributes['value'] ?? '';
$_value = empty($_old_value) ? $_value : $_old_value;
@endphp

<div class="form__group">

    <label class="form__label" for="{{ $_name }}">{{ $_label }}</label>

    @if ($_type == 'textarea')
        <textarea id="{{ $_name }}" name="{{ $_name }}" rows="{{ $_rows }}"
            class="form-form__input"></textarea>
    @else
        <input class="form__input" id="{{ $_name }}" name="{{ $_name }}" type="{{ $_type }}"
            value="{{ $_value }}" minlength='{{ $_minlength }}' min='{{ $_min }}'
            max='{{ $_max }}' placeholder='{{ $_placeholder }}' />
    @endif

    {{-- Nếu có lỗi validate --}}
    @error($_name)
        <span class="text-error">
            {{ $message }}
        </span>
    @enderror
</div>
