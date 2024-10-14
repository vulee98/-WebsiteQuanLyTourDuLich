<x-clayout>
    @if (\Session::has('alert'))
        <script>
            const msg = "{{ \Session::get('alert') }}";
            alert(msg);
        </script>
    @endif
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css" rel="stylesheet">
    {{-- <script src="https://js.stripe.com/v3/"></script> --}}
    <section class="section-header">
        <div class="header__hero">
            <div class="header__hero-overlay">&nbsp;</div>
            <img class="header__hero-img" src="{{ asset('/storage/img/tours') . '/' . $tour['imageCover'] }}"
                alt="{{ $tour['name'] }}">
        </div>
        <div class="heading-box">
            <h1 class="heading-primary">
                <span>{{ $tour['name'] }}</span>
            </h1>
            <div class="heading-box__group">
                <div class="heading-box__detail">
                    <svg class="heading-box__icon">
                        <use xlink:href="{{ asset('/storage/img/icons.svg' . '#icon-clock') }}"></use>
                    </svg>
                    <span class="heading-box__text">{{ $tour['duration'] }} ngày</span>
                </div>
                <div class="heading-box__detail">
                    <svg class="heading-box__icon">
                        <use xlink:href="{{ asset('/storage/img/icons.svg' . '#icon-map-pin') }}"></use>
                    </svg>
                    <span class="heading-box__text">{{ $tour['address'] }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section-description">
        <div class="overview-box">
            <div>
                <div class="overview-box__group">
                    <h2 class="heading-secondary ma-bt-lg">Thông tin</h2>

                    <div class="overview-box__detail">
                        <svg class="overview-box__icon">
                            <use xlink:href="{{ asset('/storage/img/icons.svg' . '#icon-calendar') }}"></use>
                        </svg>
                        <span class="overview-box__label">Ngày khởi hành</span>
                        <span class="overview-box__text">{{ $tour['startDate'] }}</span>
                    </div>

                    <div class="overview-box__detail">
                        <svg class="overview-box__icon">
                            <use xlink:href="{{ asset('/storage/img/icons.svg' . '#icon-trending-up') }}"></use>
                        </svg>
                        <span class="overview-box__label">Độ khó</span>
                        <span class="overview-box__text">{{ $tour['difficulty'] }}</span>
                    </div>

                    <div class="overview-box__detail">
                        <svg class="overview-box__icon">
                            <use xlink:href="{{ asset('/storage/img/icons.svg' . '#icon-user') }}"></use>
                        </svg>
                        <span class="overview-box__label">Thành viên tối đa</span>
                        <span class="overview-box__text">{{ $tour['maxGroupSize'] }} người</span>
                    </div>

                    <div class="overview-box__detail">
                        <svg class="overview-box__icon">
                            <use xlink:href="{{ asset('/storage/img/icons.svg' . '#icon-star') }}"></use>
                        </svg>
                        <span class="overview-box__label">Đánh giá</span>
                        <span class="overview-box__text">4.8 /
                            5</span>
                    </div>
                </div>

                <div class="overview-box__group">
                    <h2 class="heading-secondary ma-bt-lg">Hướng dẫn viên du lịch</h2>
                    <div class="overview-box__detail">
                        <img class="overview-box__img"
                            src="{{ asset('/storage/img/users' . '/' . $tour['guide']['photo']) }}"
                            alt="{{ $tour['guide']['name'] }}">
                        <span class="overview-box__label">{{ $tour['guide']['name'] }}</span>
                        <span class="overview-box__text">{{ $tour['guide']['email'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="description-box">
            <h2 class="heading-secondary ma-bt-lg">Mô tả chi tiết</h2>
            <p class="description__text">{{ $tour['description'] }}</p>
        </div>
    </section>

    <section class="section-pictures">
    <div class="picture-box">
        @if(isset($tour['images'][0]))
            <img class="picture-box__img picture-box__img--1"
                src="{{ asset('/storage/img/tours' . '/' . $tour['images'][0]['name']) }}"
                alt="{{ $tour['images'][0]['name'] }} 1">
        @else
            <img class="picture-box__img picture-box__img--1"
                src="{{ asset('/storage/img/tours/default.jpg') }}"
                alt="Default image">
        @endif
    </div>

    <div class="picture-box">
        @if(isset($tour['images'][1]))
            <img class="picture-box__img picture-box__img--2"
                src="{{ asset('/storage/img/tours' . '/' . $tour['images'][1]['name']) }}"
                alt="{{ $tour['images'][1]['name'] }} 2">
        @else
            <img class="picture-box__img picture-box__img--2"
                src="{{ asset('/storage/img/tours/default.jpg') }}"
                alt="Default image">
        @endif
    </div>

    <div class="picture-box">
        @if(isset($tour['images'][2]))
            <img class="picture-box__img picture-box__img--3"
                src="{{ asset('/storage/img/tours' . '/' . $tour['images'][2]['name']) }}"
                alt="{{ $tour['images'][2]['name'] }} 3">
        @else
            <img class="picture-box__img picture-box__img--3"
                src="{{ asset('/storage/img/tours/default.jpg') }}"
                alt="Default image">
        @endif
    </div>
</section>


    <section class="section-map">
        <div id="map" data-locations="{{ json_encode($locations) }}">
        </div>
    </section>

    <section class="section-reviews">
        <div class="reviews">
            @foreach ($reviews as $review)
                <div class="reviews__card">
                    <div class="reviews__avatar">
                        <img class="reviews__avatar-img"
                            src="{{ asset('/storage/img/users' . '/' . $review['photo']) }}"
                            alt="{{ $review['name'] }}">
                        <h6 class="reviews__user">{{ $review['name'] }}</h6>
                    </div>

                    <p class="reviews__text">
                        {{ $review['content'] }}
                    </p>

                    <div class="reviews__rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg
                                class="{{ $i <= $review['rating'] ? 'reviews__star reviews__star--active' : 'reviews__star reviews__star' }}">
                                <use xlink:href="{{ asset('/storage/img/icons.svg' . '#icon-star') }}"></use>
                            </svg>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section-cta">
        <div class="cta">
            <div class="cta__img cta__img--logo">
                <img src="{{ asset('/storage/img/logo-white.png') }}" alt="Natours logo">
            </div>
            <img class="cta__img cta__img--1"
                src="{{ asset('/storage/img/tours' . '/' . $tour['images'][0]['name']) }}"
                alt="{{ $tour['name'] }} image">
            <img class="cta__img cta__img--2"
                src="{{ asset('/storage/img/tours' . '/' . $tour['images'][1]['name']) }}"
                alt="{{ $tour['name'] }} image">
            <div class="cta__content">
                <h2 class="heading-secondary">What are you waiting for?</h2>
                <p class="cta__text">{{ $tour['duration'] }} days. 1 adventure. Infinite memories. Make it
                    yours today!
                </p>
                @if (Auth::check())
                    <a class="btn btn--green span-all-rows" id="booking-tour"
                        @if ($outOfTicket) href="#"
                        @else
                        href="/booking/{{ $tour['id'] }}/{{ $user['id'] }}" @endif>
                        {{ $outOfTicket ? 'Đã hết vé' : 'Đặt tour ngay!' }}
                    </a>
                @else
                    <a class="btn btn--green span-all-rows" id="booking-tour" href="/login">Đăng nhập để đặt tour!</a>
                @endif
            </div>
        </div>

        <div class="cta" style="margin-top: 50px">
            <div class="user-view__form-container">
                <h2 class="heading-secondary ma-bt-md">ĐÁNH GIÁ CỦA BẠN VỀ CHUYẾN ĐI NÀY</h2>
                <div class="container-review-form">
                    <form method="POST"
                        action="{{ route('review', ['tour_id' => $tour['id'], 'user_id' => $user['id']]) }}"
                        id="review-form">
                        @csrf
                        <x-cinput name="rating" label="Đánh giá (1 - 5 sao)" type="number" min="1" max="5" />

                        <x-cinput name="content" label="Nội dung" type="textarea" rows="5" />

                        <button class="btn btn--green span-all-rows" type="submit">
                            Gửi đánh giá
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="/js/mapbox.js"></script>
</x-clayout>
