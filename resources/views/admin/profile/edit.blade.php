<x-admin.layout.layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <section class="max-w-2xl px-4 space-y-8">
        <h1 class="text-2xl font-bold text-gray-900">Your profile</h1>
        <p class="text-sm text-gray-500">
            The information you share will be used across the system to help others get to know you!
        </p>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Profile Picture -->
            <div class="space-y-4">
                <label class="block font-medium text-gray-700">Profile Picture</label>
                <div class="flex items-center gap-4">
                    <img id="image-preview" src="{{ $admin->image ? asset($admin->image) : asset('assets/static-images/no-image.jpg') }}"
                        class="w-16 h-16 rounded-full object-cover border border-gray-300" alt="Foto Profil">

                    <label class="bg-gray-900 text-white px-4 py-2 rounded-md cursor-pointer text-sm hover:bg-black transition">
                        Choose File
                        <input type="file" name="image" id="image-input" accept="image/*" class="hidden">
                    </label>
                </div>
            </div>

            <!-- Name -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <!-- Email -->
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Email Address</label>
                <p class="text-xs text-gray-500">Changing your email address will require verification.</p>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <!-- Phone -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $admin->phone_number) }}"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" name="password" placeholder="Leave blank if not changing"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <!-- Password Confirmation -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Repeat new password"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <!-- Action Buttons -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full text-center px-6 py-3 text-white bg-gray-900 rounded-md text-sm hover:bg-black transition">
                    Update my profile
                </button>
            </div>
        </form>

        <x-alert.confirm-modal id="delete-photo"
            title="Hapus Foto Profil?"
            message="Foto profil akan dihapus permanen."
            confirmText="Hapus"
            cancelText="Batal"
            :action="route('admin.profile.delete-image')" method="POST" />

        @push('scripts')
        <script>
            document.getElementById('image-input')?.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    document.getElementById('image-preview').src = URL.createObjectURL(file);
                }
            });
        </script>
        @endpush
    </section>
</x-admin.layout.layout>
