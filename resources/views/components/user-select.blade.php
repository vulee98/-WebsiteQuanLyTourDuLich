@php
$_selected = $attributes['selected'];
@endphp

<div class="form-group mt-3">
    <!-- <label for="user_id" class="form-label">Chọn user</label> -->
    <select {{ isset($attributes['disabled']) ? 'disabled' : '' }} id="user_id" name="user_id" class="form-control 
        @error('user_id') is-invalid @enderror">
        <option value="">--Chọn người đặt--</option>
        @foreach ($users as $user)
            <option {{ isset($_selected) && $_selected == $user['id'] ? 'selected' : '' }}
                value="{{ $user['id'] }}">
                {{ $user['name'] . ' ,  ' . $user['email']. ' , ' . $user['phoneNumber'] }}
            </option>
        @endforeach
    </select>
    {{-- Nếu có lỗi validate --}}
    @error('user_id')
        <span class="text-danger">
            {{ $message }}
        </span>
    @enderror
</div>
