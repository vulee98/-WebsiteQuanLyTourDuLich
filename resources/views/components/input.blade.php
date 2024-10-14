@php
$_name = $attributes['name'];
$_label = $attributes['label'];
$_type = $attributes['type'] ?? 'text';
$_min = $attributes['min'];
$_selected = $attributes['selected'];
$_old_value = old($_name);

$_element = isset($attributes['element']) ? $attributes['element'] : 'input';
$_rows = $attributes['rows'] ?? 5;

$_multiple = isset($attributes['multiple']);

$_value = $attributes['value'] ?? '';
$_value = empty($_old_value) ? $_value : $_old_value;
@endphp

<div>
    <div class="form-group mt-3">
        @if ($_element != 'checkbox')
            <label for="{{ $_name }}" class="form-label">{{ $_label }} </label>
        @endif
        {{-- Nếu element là textarea --}}
        @if ($_element == 'textarea')
            <textarea id="{{ $_name }}" name="{{ $_name }}" rows="{{ $_rows }}"
                class="form-control @error($_name) is-invalid @enderror">{{ $_value }}</textarea>
            {{-- Nếu element là select --}}
        @elseif ($_element == 'select')
            <select id="{{ $_name }}" name="{{ $_name }}"
                class="form-control 
        @error($_name) is-invalid @enderror">
                <option value="">--Chọn một giá trị--</option>
                @foreach (explode(',', $attributes['data']) as $item)
                    <option {{ $_selected == $item ? 'selected' : '' }} value="{{ $item }}">
                        {{ $item }}</option>
                @endforeach
            </select>
            {{-- Nếu element là checkbox --}}
        @elseif ($_element == 'checkbox')
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="{{ $_name }}" name="{{ $_name }}"
                    {{ isset($attributes['checked']) ? 'checked' : '' }} />
                <label class="form-check-label" for="{{ $_name }}">
                    {{ $_label }}
                </label>
            </div>
            {{-- Nếu element là input --}}
        @else
            <input id="{{ $_name }}" name="{{ $_name }}" type="{{ $_type }}"
                value="{{ $_value }}" {{ isset($_min) ? 'min=' . $_min : '' }}
                {{ $_multiple ? 'multiple' : '' }} class="form-control @error($_name) is-invalid @enderror" />
        @endif

        {{-- Nếu có lỗi validate --}}
        @error($_name)
            <span class="text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
