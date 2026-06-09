@php
    // Fetch global defaults from the database
    $defaultTitle       = setting('meta_title', config('app.name'));
    $defaultDescription = setting('meta_description', '');
    $defaultKeywords    = setting('meta_keywords', '');
    $defaultAuthor      = setting('meta_author', 'White Transportation LLC');
    $defaultImage       = setting('logo_url');
    $favicon            = setting('favicon_url');
@endphp


<title>@yield('meta_title', $defaultTitle)</title>
<meta name="description" content="@yield('meta_description', $defaultDescription)">
<meta name="keywords" content="@yield('meta_keywords', $defaultKeywords)">
<meta name="author" content="@yield('meta_author', $defaultAuthor)">
<meta name="robots" content="@yield('meta_robots', 'index, follow')">

<link rel="icon" type="image/png" href="{{ $favicon }}">

{{-- Open Graph --}}
<meta property="og:title" content="@yield('meta_title', $defaultTitle)">
<meta property="og:description" content="@yield('meta_description', $defaultDescription)">
<meta property="og:image" content="@yield('meta_image', $defaultImage)">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ setting('system_name') }}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('meta_title', $defaultTitle)">
<meta name="twitter:description" content="@yield('meta_description', $defaultDescription)">
<meta name="twitter:image" content="@yield('meta_image', $defaultImage)">