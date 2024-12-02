<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="#">
<meta name="author" content="#">
<meta name="generator" content="Laravel">

<title>{{ $title }}</title>

@notifyCss
@vite(['resources/css/app.css','resources/js/app.js'])

<link rel="canonical" href="{{ request()->fullUrl() }}">
<link rel="icon" type="icon" href="{{ asset($setting['app_logo']) }}">

@if(isset($page->params['robots']))
    <meta name="robots" content="{{ $page->params['robots'] }}">
@endif

<script>
    // On page load or when changing themes, best to add inline in `head` to avoid FOUC
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark')
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>