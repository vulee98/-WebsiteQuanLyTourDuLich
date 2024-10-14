<x-clayout title="Trang cá nhân">
    @if (\Session::has('success'))
        <script>
            alert("{{ \Session::get('success') }}")
        </script>
    @endif
    <main class="main">
        <div class="user-view">
            @include('common.sidebar')

            <div class="user-view__content">
                <div class="user-view__form-container">
                    <h2 class="heading-secondary ma-bt-md">Thông tin cá nhân</h2>
                    <form method="POST" action={{ route('change-info') }} class="form form-user-data"
                        enctype="multipart/form-data">
                        @csrf
                        <x-cinput name="name" label="Tên người dùng" value="{{ $user['name'] ?? '' }}" />
                        <x-cinput name="email" label="Email" value="{{ $user['email'] ?? '' }}" />
                        <x-cinput name="phoneNumber" label="Số điện thoại" value="{{ $user['phoneNumber'] ?? '' }}" />
                        <div class="form__group form__photo-upload">
                            <img class="form__user-photo"
                                src="{{ isset($user['photo']) ? asset('/storage/img/users') . '/' . $user['photo'] : '' }}"
                                alt="User photo">
                            <input class="form__upload" type="file" accept="image/*" id="photo" name="photo">
                            <label for="photo">Chọn hình mới</label>
                        </div>
                        <div class="form__group right">
                            <button type="submit" class="btn btn--small btn--green">Lưu chỉnh sửa</button>
                        </div>
                    </form>
                </div>
                <div class="line">&nbsp;</div>
                <div class="user-view__form-container">
                    <h2 class="heading-secondary ma-bt-md">Đổi mật khẩu</h2>
                    <form class="form form-user-password" method="POST" action={{ route('change-password') }}>
                        @csrf
                        <x-cinput name="currentPassword" label="Mật khẩu hiện tại" type="password"
                            placeholder="••••••••" minlength="4" />
                        @if (\Session::has('currentPasswordError'))
                            <span class="text-error">
                                {{ \Session::get('currentPasswordError') }}
                            </span>
                        @endif
                        <x-cinput name="newPassword" label="Mật khẩu mới" type="password" placeholder="••••••••"
                            minlength="4" />
                        <x-cinput name="confirmPassword" label="Nhập lại mật khẩu" type="password"
                            placeholder="••••••••" minlength="4" />

                        <div class="form__group right">
                            <button type="submit" class="btn btn--small btn--green btn--save-password">Lưu mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-clayout>
