<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome & Swiper CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @php
        $siteSetting = $page['props']['setting'] ?? null;
    @endphp

    <title>{{ $siteSetting['meta_title'] ?? ($siteSetting['system_name'] ?? 'Ez Property') }}</title>
    
    @if(!empty($siteSetting['favicon_url']))
        <link rel="icon" type="image/x-icon" href="{{ $siteSetting['favicon_url'] }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    @if(!empty($siteSetting['meta_description']))
        <meta name="description" content="{{ $siteSetting['meta_description'] }}">
    @endif
    @if(!empty($siteSetting['meta_keywords']))
        <meta name="keywords" content="{{ $siteSetting['meta_keywords'] }}">
    @endif

    @viteReactRefresh
    @vite(['resources/js/app.jsx', 'resources/css/app.css'])
    @inertiaHead
</head>
<body class="antialiased text-slate-800 bg-white">
    @inertia
</body>
</html>