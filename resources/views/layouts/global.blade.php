


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("page_title")</title>
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script:wght@700&family=Poppins:ital,wght@0,200;0,400;1,400&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}?v=0.0.1.3" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

</head>
<body>
@include('layouts.header')
<div class="clear">&nbsp;</div>
@yield("page_content")
</body>
<script src="{{ asset('js/app.js') }}?v=0.0.1.3" defer></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZBR8CYZ99N"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-ZBR8CYZ99N');
</script>
</html>
