<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('storage/'.$setting->favicon) }}">
    @include('partials.meta')
    @include('layouts.front.style')
    @yield('styles')
</head>

<body>

@include('layouts.front.header')

<main>
    @yield('content')
</main>

@include('layouts.front.footer')

@include('layouts.front.scripts')
@stack('scripts')

</body>
</html>
