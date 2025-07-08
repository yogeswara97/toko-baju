<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100 text-gray-800 antialiased font-roboto-condensed">
    {{ $slot }}
</body>

</html>
