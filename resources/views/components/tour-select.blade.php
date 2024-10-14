@php
$_selected = $attributes['selected'];
@endphp

<div class="form-group mt-3">
    <label for="tour_id" class="form-label">Chọn tour</label>
    <select {{ isset($attributes['disabled']) ? 'disabled' : '' }} id="tour_id" name="tour_id" class="form-control 
        @error('tour_id') is-invalid @enderror">
        <option value="">--Chọn tour được đặt--</option>
        @foreach ($tours as $tour)
            <option {{ isset($_selected) && $_selected == $tour['id'] ? 'selected' : '' }}
                value="{{ $tour['id'] }}">
                {{ $tour['name'] }}
            </option>
        @endforeach
    </select>
    {{-- Nếu có lỗi validate --}}
    @error('tour_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>
