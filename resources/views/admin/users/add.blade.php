<x-layout title="Thêm người dùng">
    <h3 class="display-4 text-center">
        THÊM NGƯỜI DÙNG
    </h3>
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ route('save_user') }}" enctype="multipart/form-data">
                @csrf
                <x-input name="name" label="Tên người dùng" />
                <x-input name="email" label="Email" type="email" />
                <x-input name="password" label="Mật khẩu" type="password" />
                <x-input name="confirmPassword" label="Xác nhận mật khẩu" type="password" />
                <x-input name="photo" label="Ảnh đại diện" type="file" />
                <x-input name="phoneNumber" label="Số điện thoại" />
                <x-input name="role" label="Chức vụ" data="admin, user, guide" element="select" />

                {{-- <div class="mt-3">
                    <label class="font-weight-bold">
                        <input type="checkbox" name="is_admin" />
                        Tài khoản admin
                    </label>
                </div> --}}
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
