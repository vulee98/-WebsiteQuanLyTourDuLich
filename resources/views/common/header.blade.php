<header class="header">

    <nav class="nav nav--tours">
        <a class="nav__el" href="/">Trang chủ</a>
    </nav>

    <div class="header__logo">
        <img src="{{ asset('/storage/img/logo-white.png') }}" alt="Natours logo">
    </div>

    <nav class="nav nav--user">
        @if (isset($user))
            <a class="nav__el nav__el--logout" id="log-out-btn" href="/logout">Đăng xuất</a>
            <a class="nav__el" href="/account">
                <img class="nav__user-img" src=" {{ asset('/storage/img/users/' . $user['photo']) }} "
                    alt="Photo of {{ $user['name'] }}">
                <span>{{ explode(' ', $user['name'])[0] }}</span>
            </a>
        @else
            <a class="nav__el" href="/login">Đăng nhập</a>
            <a class="nav__el nav__el--cta" href="/signup">Đăng ký</a>
        @endif
    </nav>

</header>
