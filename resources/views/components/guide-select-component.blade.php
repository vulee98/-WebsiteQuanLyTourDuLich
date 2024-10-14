@php
$_selected = $attributes['selected'];
@endphp

<div class="form-group mt-3">
    <label for="guide_id" class="form-label">Hướng dẫn viên du lịch</label>
    <select id="guide_id" name="guide_id" class="form-control 
        @error('guide_id') is-invalid @enderror">
        <option value="">--Chọn hướng dẫn du lịch--</option>
        @foreach ($guides as $guide)
            <option {{ isset($_selected) && $_selected == $guide['id'] ? 'selected' : '' }}
                value="{{ $guide['id'] }}">
                {{ $guide['name'] . ', ' . $guide['email'] }}
            </option>
        @endforeach
    </select>
    {{-- Nếu có lỗi validate --}}
    @error('guide_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>
