<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Laravel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>--}}
    @livewireStyles
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- PWA манифест и настройки -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#ffffff">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="apple-touch-icon" href="{{ asset('logoNEXDAY192.png') }}">

    <!-- iPhone SE (1-е поколение) -->
    <link rel="apple-touch-startup-image" href="{{ asset('logoNEXDAY192.png') }}"
          media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)">

    <!-- iPhone 8, 7, 6, 6s -->
    <link rel="apple-touch-startup-image" href="{{ asset('logoNEXDAY192.png') }}"
          media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)">

    <!-- iPhone 8 Plus, 7 Plus, 6s Plus, 6 Plus -->
    <link rel="apple-touch-startup-image" href="{{ asset('logoNEXDAY192.png') }}"
          media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)">

    <!-- iPhone X, XS, 11 Pro -->
    <link rel="apple-touch-startup-image" href="{{ asset('logoNEXDAY192.png') }}"
          media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)">

    <!-- iPhone XR, 11 -->
    <link rel="apple-touch-startup-image" href="{{ asset('logoNEXDAY192.png') }}"
          media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)">

    <!-- iPhone XS Max, 11 Pro Max -->
    <link rel="apple-touch-startup-image" href="{{ asset('logoNEXDAY192.png') }}"
          media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)">

    <!-- iPhone 12 mini -->
    <link rel="apple-touch-startup-image" href="{{ asset('logoNEXDAY192.png') }}"
          media="(device-width: 360px) and (device-height: 780px) and (-webkit-device-pixel-ratio: 3)">

    <!-- iPhone 12, 12 Pro -->
    <link rel="apple-touch-startup-image" href="{{ asset('logoNEXDAY192.png') }}"
          media="(device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3)">

    <!-- iPhone 12 Pro Max -->
    <link rel="apple-touch-startup-image" href="{{ asset('logoNEXDAY192.png') }}"
          media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3)">
</head>
<body class="bg-gray-100 flex flex-col h-screen">
@include('includes.header')
<main class="flex-grow flex @yield('main-flex-status', 'flex-row justify-center')">
    @yield('content')
</main>
@include('includes.footer')
@livewireScripts
{{--<style>--}}
{{--    @media (max-width: 768px) {--}}
{{--        #footer {--}}
{{--            display: none !important;--}}
{{--        }--}}
{{--    }--}}
{{--</style>--}}

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (/Mobi|Android|iPhone|iPad|iPod/.test(navigator.userAgent)) {
            document.getElementById("footer").style.display = "none";
        }
    });
</script>
</body>
</html>
