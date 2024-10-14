<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/style/css/style.css') }}">
    {{-- <link rel="shortcut icon" type="image/png" href="/img/favicon.png"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Timenewroman:300,300i,700">
    <title>{{ $attributes['title'] ?? 'Quản lý tours du lịch' }}</title>
</head>

<body>
    <!-- HEADER-->
    @include('common.header')

    <!-- CONTENT-->
    {{ $slot }}

    <!-- FOOTER-->
    @include('common.footer')

    {{-- <script src="https://js.stripe.com/v3/"></script>
    <script src="/js/bundle.js"></script> --}}
</body>

</html>
