


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("page_title")</title>
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script:wght@700&family=Poppins:ital,wght@0,200;0,400;1,400&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
@include('layouts.header')


@yield("page_content")
</body>

</html>
