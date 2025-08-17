<x-admin.layout.layout :title="'Edit ' . ucfirst($user->role_label) . ': ' . $user->name">
    <x-admin.layout.header :title="'Edit ' . ucfirst($user->role_label)"
        :breadcrumbs="[
            ['label' => 'Home', 'url' => route('admin.dashboard')],
            ['label' => ucfirst($user->role_label) . 's', 'url' => $user->role === 'customer' ? route('admin.customers.index') : route('admin.admin.index')],
            ['label' => 'Edit'],
        ]"
    />

    <form action="{{ $user->role === 'customer' ? route('admin.customers.update', $user->id) : route('admin.admin.update', $user->id) }}"
        method="POST" enctype="multipart/form-data"
        class="bg-white rounded-xl shadow-md p-6 max-w-3xl space-y-6 text-sm">
        @csrf
        @method('PUT')

        <!-- Profile Image -->
        <div class="space-y-2 text-center">
            <h3 class="font-semibold text-base mb-2">Profile Image</h3>
            <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border border-gray-300 shadow-sm">
                <img id="preview-image"
                    src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/static-images/no-image.jpg') }}"
                    alt="User Image" class="w-full h-full object-cover">
            </div>
            <input type="file" name="image" id="image-input" class="mt-3 text-sm">
            <input type="hidden" name="cropped_image" id="cropped-image">
        </div>

        {{-- Input Fields --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <label for="name" class="block font-semibold mb-1 text-xs">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="input w-full text-xs">
            </div>
            <div>
                <label for="email" class="block font-semibold mb-1 text-xs">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="input w-full text-xs">
            </div>
            <div>
                <label for="phone_number" class="block font-semibold mb-1 text-xs">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number"
                    value="{{ old('phone_number', $user->phone_number) }}" class="input w-full text-xs">
            </div>
            <div>
                <label for="role" class="block font-semibold mb-1 text-xs">Role</label>
                <select name="role" id="role" class="input w-full text-xs">
                    <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div>
                <label for="is_active" class="block font-semibold mb-1 text-xs">Status</label>
                <select name="is_active" id="is_active" class="input w-full text-xs">
                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <label for="password" class="block font-semibold mb-1 text-xs">Password (kosongkan jika tidak ingin
                    ubah)</label>
                <input type="password" name="password" id="password" class="input w-full text-xs">
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end mt-4">
            <a href="{{ $user->role === 'customer' ? route('admin.customers.index') : route('admin.admin.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm mr-2">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500 text-sm">Update User</button>
        </div>
    </form>

    <!-- Cropper Modal -->
    <div id="cropper-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-4 rounded shadow-lg max-w-lg w-full">
            <h2 class="font-bold mb-4">Crop Profile Image</h2>
            <div>
                <img id="cropper-image" class="max-w-full max-h-[500px]">
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button id="cancel-crop" class="px-4 py-2 text-sm bg-gray-300 rounded">Cancel</button>
                <button id="confirm-crop" class="px-4 py-2 text-sm bg-blue-600 text-white rounded">Crop &
                    Preview</button>
            </div>
        </div>
    </div>

    <!-- Include CropperJS -->
    <link href="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.js"></script>

    <script>
        let cropper;
        const imageInput = document.getElementById('image-input');
        const cropperModal = document.getElementById('cropper-modal');
        const cropperImage = document.getElementById('cropper-image');
        const previewImage = document.getElementById('preview-image');
        const croppedImageInput = document.getElementById('cropped-image');

        imageInput.addEventListener('change', e => {
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
                    background: false,
                });
            };
            reader.readAsDataURL(file);
        });

        document.getElementById('confirm-crop').addEventListener('click', () => {
            const canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300
            });

            canvas.toBlob(blob => {
                const file = new File([blob], 'cropped.jpg', { type: 'image/jpeg' });

                // Buat DataTransfer agar bisa inject ke input file
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                imageInput.files = dataTransfer.files;

                // Ganti preview
                const reader = new FileReader();
                reader.onloadend = () => {
                    previewImage.src = reader.result;
                    cropperModal.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            });

        });

        document.getElementById('cancel-crop').addEventListener('click', () => {
            cropperModal.classList.add('hidden');
            cropper.destroy();
        });
    </script>
</x-admin.layout.layout>
