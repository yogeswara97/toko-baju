<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StyleHub - Modern Clothing Store</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" /> --}}
    @stack('css')
</head>

<body class=" text-gray-800 leading-relaxed">

    <x-customer.layout.navbar />


    <main class="">
        @if (session('success'))
        <div class="max-w-2xl mx-auto mb-6 px-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative animate-fade-in">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div class="max-w-2xl mx-auto mb-6 px-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative animate-fade-in">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        {{ $slot }}
    </main>

    <x-customer.layout.footer />

    @stack('scripts')
     <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @vite('resources/js/app.js')
</body>

</html>
