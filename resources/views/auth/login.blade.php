<x-auth-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white border border-gray-200 rounded-2xl p-8 sm:p-10">
            <h2 class="text-3xl font-medium text-center text-gray-800 mb-6">Login ke StyleHub</h2>

            {{-- Error Handling --}}
            @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                <strong>Oops!</strong> {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full mt-1 px-4 py-2 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded-xl focus:ring focus:ring-blue-300 focus:outline-none">
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full mt-1 px-4 py-2 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded-xl focus:ring focus:ring-blue-300 focus:outline-none">
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between text-sm">
                    <label class="inline-flex items-center text-gray-600">
                        <input type="checkbox" name="remember" class="form-checkbox rounded text-blue-600" {{
                            old('remember') ? 'checked' : '' }}>
                        <span class="ml-2">Ingat saya</span>
                    </label>
                    {{-- <a href="#" class="text-blue-500 hover:underline">Lupa password?</a> --}}
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl font-semibold transition duration-300">
                    Masuk
                </button>
            </form>

            {{-- Link ke Dashboard --}}
            <div class="mt-4 text-center">
                <a href="{{ route('home') }}"
                    class="inline-block mt-2 text-sm text-gray-700 hover:text-blue-600 underline transition">
                    Kembali ke Dashboard
                </a>
            </div>


            <p class="mt-6 text-sm text-gray-600 text-center">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar sekarang</a>
            </p>
        </div>
    </div>
</x-auth-layout>
