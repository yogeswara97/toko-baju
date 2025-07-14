<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? config('app.name') . ' - Modern Clothing Store' }}</title>


    @vite('resources/css/app.css')
    <script src="https://unpkg.com/alpinejs" defer></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    @stack('css')
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="text-gray-800 bg-secondary font-roboto-condensed">

    {{-- Navbar --}}
    <x-customer.layout.navbar />

    {{-- Main Content --}}
    <main class="bg-secondary">
        {{-- Flash Success --}}
        <x-alert.flash />

        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-customer.layout.footer />

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite('resources/js/app.js')
</body>

</html>
