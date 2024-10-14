<nav class="user-view__menu">
    <ul class="side-nav">
        <li>
            <a href="/account">
                <svg>
                    <use xlink:href="{{ asset('/storage/img/icons.svg' . '#icon-settings') }}"></use>
                </svg>Cài đặt
            </a>
        </li>
        <li>
            <a href="/my-bookings">
                <svg>
                    <use xlink:href="{{ asset('/storage/img/icons.svg' . '#icon-briefcase') }}"></use>
                </svg>Các tour đã đặt
            </a>
        </li>
        <!-- <li>
            <a href="/my-reviews">
                <svg>
                    <use xlink:href="{{ asset('/storage/img/icons.svg' . '#icon-star') }}"></use>
                </svg>Các đánh giá của tôi
            </a>
        </li> -->
        @if (isset($user) && $user['role'] == 'admin')
            <li>
                <a href="/admin">
                    <svg>
                        <use xlink:href="{{ asset('/storage/img/icons.svg' . '#icon-map') }}"></use>
                    </svg>Quán lý các tours
                </a>
            </li>
        @endif
    </ul>
</nav>
