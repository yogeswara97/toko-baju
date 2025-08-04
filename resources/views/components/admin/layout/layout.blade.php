<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ strtoupper(config('app.name')) }} | {{ strtoupper($title) }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('quill/quill.css') }}">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <script src="https://unpkg.com/alpinejs" defer></script>


    <span class="uppercase">
        {{ config('app.name') }}
    </span>
    <style>
        /* Menghilangkan panah di input type number untuk browser berbasis Webkit (Chrome, Safari, dll) */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Menghilangkan panah di input type number untuk Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Tambahan CSS opsional untuk memastikan tampilan yang rapi */
        input[type=number] {
            appearance: textfield;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: hidden;
        }

        .no-scrollbar {
            -ms-overflow-style: hidden;
            /* IE and Edge */
            scrollbar-width: hidden;
            /* Firefox */
        }
    </style>

    @stack('head')
    @stack('css')

    @stack('styles')
</head>

<body class="h-full bg-secondary/40 text-slate-800 flex flex-col font-inter-sans">
    {{-- Include CropperJS --}}
    <link href="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.js"></script>

    <div class="flex-grow flex flex-col">
        <x-admin.layout.navbar></x-admin.layout.navbar>
        <x-admin.layout.sidebar></x-admin.layout.sidebar>

        <main class=" sm:mt-10 min-h-[calc(100vh-138px)] ">
            <div class="p-4 sm:ml-52 xl:ml-64">
                <x-alert.default />
                {{ $slot }}
            </div>
        </main>

        {{-- <x-admin.layout.footer></x-admin.layout.footer> --}}
    </div>

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Select all input fields of type number
        const numberInputs = document.querySelectorAll('input[type="number"]');

        // Function to prevent wheel event on number inputs
        function preventWheel(event) {
            event.preventDefault();
        }

        // Add event listener to each number input
        numberInputs.forEach(input => {
            input.addEventListener('wheel', preventWheel);
        });
    </script>
</body>

</html>
