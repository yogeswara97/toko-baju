<x-auth-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white border border-gray-200 rounded-2xl p-8 sm:p-10">
            <h2 class="text-3xl font-medium text-center text-gray-800 mb-6">Daftar Akun StyleHub</h2>

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                    <strong>Oops!</strong> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full mt-1 px-4 py-2 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                    >
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full mt-1 px-4 py-2 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                    >
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        class="w-full mt-1 px-4 py-2 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                    >
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                    >
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-xl font-semibold transition duration-300"
                >
                    Daftar
                </button>
            </form>

            <p class="mt-6 text-sm text-gray-600 text-center">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login sekarang</a>
            </p>
        </div>
    </div>
</x-auth-layout>
