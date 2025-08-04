<x-customer.layout.layout>
    <section class="container-custom py-10 space-y-10">
        <x-customer.page-header title="Edit Profile" description="Perbarui informasi akunmu di sini." />

        <x-alert.default />
        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                <!-- Kolom Gambar -->
                <div class="flex flex-col items-center gap-4">
                    <!-- Foto Preview -->
                    <img id="image-preview"
                        src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/static-images/no-image.jpg') }}"
                        class="w-32 h-32 rounded-full object-cover ring-2 ring-gray-300" alt="Profile Picture">

                    <!-- Upload Foto -->
                    <label
                        class="inline-flex items-center px-4 py-2 text-sm text-white bg-primary rounded-md cursor-pointer hover:bg-primary-dark transition">
                        Pilih Foto
                        <input type="file" name="image" id="image-input" accept="image/*" class="hidden">
                    </label>

                    <!-- Tombol Hapus -->
                    @if (auth()->user()->image)
                        <button
                            onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: { id: 'delete-photo' } }))"
                            type="button" class="text-sm text-red-600 hover:underline transition">
                            Hapus Foto
                        </button>
                    @endif
                </div>

                <!-- Kolom Form -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary outline-none"
                            required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary outline-none"
                            required>
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                        <input type="text" name="phone_number"
                            value="{{ old('phone_number', auth()->user()->phone_number) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary outline-none">
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary outline-none"
                            placeholder="Kosongkan jika tidak ingin mengganti">
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary outline-none"
                            placeholder="Ulangi password baru">
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end gap-3 pt-6">
                        <a href="{{ route('customer.profile.index') }}"
                            class="px-4 py-2 text-sm text-gray-700 hover:text-gray-900 hover:underline transition">
                            Batal
                        </a>
                        <!-- Ganti tombol ini -->
                        <!-- Ganti tombol ini -->
                        <button type="submit"
                            class="px-5 py-2 text-sm rounded-md bg-primary text-white hover:bg-primary-dark transition">
                            Simpan Perubahan
                        </button>


                    </div>
                </div>
            </div>
        </form>
        <!-- Cropper Modal -->
        <div id="cropper-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
            <div class="bg-white p-4 rounded shadow-lg max-w-lg w-full">
                <h2 class="font-bold mb-4 text-lg">Crop Gambar Profil</h2>
                <div>
                    <img id="cropper-image" class="max-w-full max-h-[500px]" />
                </div>
                <div class="mt-4 flex justify-end gap-2">
                    <button id="cancel-crop" class="px-4 py-2 text-sm bg-gray-300 rounded">Batal</button>
                    <button id="confirm-crop" class="px-4 py-2 text-sm bg-primary text-white rounded">Crop &
                        Simpan</button>
                </div>
            </div>
        </div>


        <!-- Modal konfirmasi hapus foto -->
        <x-alert.confirm-modal id="delete-photo" title="Hapus Foto Profil?"
            message="Foto profilmu akan dihapus secara permanen." confirmText="Hapus" cancelText="Batal"
            :action="route('customer.profile.delete-image')" method="POST" />

        <!-- Modal konfirmasi simpan perubahan -->
        <x-alert.confirm-modal id="save-confirm" title="Simpan Perubahan?"
            message="Pastikan semua informasi sudah benar sebelum menyimpan." confirmText="Ya, Simpan"
            cancelText="Batal" action="{{ route('customer.profile.update') }}" method="PUT" />

        @push('scripts')
            <script>
                const input = document.getElementById('image-input');
                const preview = document.getElementById('image-preview');

                input.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        preview.src = URL.createObjectURL(file);
                    }
                });
            </script>
        @endpush

        @push('scripts')
            <script>
                let cropper;
                const imageInput = document.getElementById('image-input');
                const imagePreview = document.getElementById('image-preview');
                const cropperModal = document.getElementById('cropper-modal');
                const cropperImage = document.getElementById('cropper-image');
                const confirmCrop = document.getElementById('confirm-crop');
                const cancelCrop = document.getElementById('cancel-crop');

                imageInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = () => {
                        cropperImage.src = reader.result;
                        cropperModal.classList.remove('hidden');

                        if (cropper) cropper.destroy();
                        cropper = new Cropper(cropperImage, {
                            aspectRatio: 1,
                            viewMode: 1,
                            background: false
                        });
                    };
                    reader.readAsDataURL(file);
                });

                confirmCrop.addEventListener('click', () => {
                    const canvas = cropper.getCroppedCanvas({ width: 300, height: 300 });
                    canvas.toBlob(blob => {
                        const croppedFile = new File([blob], 'profile.jpg', { type: 'image/jpeg' });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(croppedFile);
                        imageInput.files = dataTransfer.files;

                        // Preview langsung
                        const reader = new FileReader();
                        reader.onload = () => {
                            imagePreview.src = reader.result;
                            cropperModal.classList.add('hidden');
                        };
                        reader.readAsDataURL(croppedFile);
                    });
                });

                cancelCrop.addEventListener('click', () => {
                    cropperModal.classList.add('hidden');
                    cropper?.destroy();
                });
            </script>
        @endpush

    </section>
</x-customer.layout.layout>
