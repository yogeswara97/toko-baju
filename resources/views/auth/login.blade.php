<x-auth-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="min-h-screen flex flex-col lg:flex-row bg-secondary">
        <!-- Gambar (sembunyi di layar kecil) -->
        <div class="hidden lg:block lg:w-[40%] relative">
            <div class="absolute inset-0 bg-cover bg-center z-0"
                style="background-image: url('{{ asset('assets/static-images/category/man.png') }}');"></div>
            <!-- Optional overlay, tapi set opacity-nya tipis banget atau hapus kalau mau full terlihat -->
            <div class="absolute inset-0 bg-primary-light/5 z-10"></div>
        </div>


        <!-- Form Login -->
        <div class="flex items-center justify-center w-full lg:w-[60%] px-4  min-h-screen">

            <div class="w-full max-w-lg p-8 sm:p-10 ">
                <h2 class="text-3xl font-medium text-gray-800 mb-6">Login ke</h2>
                <h2 class="text-7xl font-medium text-gray-800 mb-6"> StyleHub</h2>

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
                            class="w-full mt-1 px-4 py-2 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded-xl focus:ring focus:ring-primary focus:outline-none">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" required
                            class="w-full mt-1 px-4 py-2 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded-xl focus:ring focus:ring-primary focus:outline-none">
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center text-gray-600">
                            <input type="checkbox" name="remember" class="form-checkbox rounded text-primary" {{
                                old('remember') ? 'checked' : '' }}>
                            <span class="ml-2">Ingat saya</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full bg-primary hover:bg-green-800 text-white py-2 rounded-xl font-semibold transition duration-300">
                        Masuk
                    </button>
                </form>

                <div class="mt-4 ">
                    <a href="{{ route('customer.home') }}"
                        class="inline-block mt-2 text-sm text-gray-700 hover:text-primary underline transition">
                        Kembali ke Dashboard
                    </a>
                </div>

                <p class="mt-6 text-sm text-gray-600 ">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-primary hover:underline">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</x-auth-layout>
