<x-clayout title="Đăng nhập">
    <main class="main">
        <div class="login-form">
            <h2 class="heading-secondary ma-bt-lg">Đăng nhập</h2>
            <form method="POST" class="form form--login" action={{ route('auth.login') }}>
                @error('error')
                    <span style="color:red; font-size:15px;">
                        {{ $message }}
                    </span>
                @enderror
                @csrf
                <x-cinput name="email" label="Email" placeholder="nguyenvana@gmail.com" />
                <x-cinput name="password" label="Mật khẩu" type="password" placeholder="••••••••" minlength="4" />

                <div class="form__group"><button class="btn btn--green">Đăng nhập</button></div>
            </form>
        </div>
    </main>
</x-clayout>
