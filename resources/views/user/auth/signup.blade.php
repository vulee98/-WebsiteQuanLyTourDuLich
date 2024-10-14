<x-clayout title="Đăng ký tài khoản">
    <main class="main">
        <div class="login-form">
            <h2 class="heading-secondary ma-bt-lg">Đăng ký tài khoản</h2>
            <form method="POST" class="form form--login" action={{ route('auth.signup') }}>
                @csrf
                <x-cinput name="name" label="Tên người dùng" placeholder="Nguyễn Văn A" />
                <x-cinput name="phoneNumber" label="Số điện thoại" placeholder="0123456789" minlength="10" />
                <x-cinput name="email" label="Email" placeholder="nguyenvana@gmail.com" />
                <x-cinput name="password" label="Mật khẩu" type="password" placeholder="••••••••" minlength="4" />
                <x-cinput name="confirmPassword" label="Nhập lại mật khẩu" type="password" placeholder="••••••••"
                    minlength="4" />

                <div class="form__group"><button class="btn btn--green">Đăng ký ngay</button></div>
            </form>
        </div>
    </main>
</x-clayout>
