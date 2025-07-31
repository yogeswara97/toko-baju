<x-admin.layout.layout :title="'Edit User: ' . $user->name">
    <x-admin.layout.header
        :title="'Edit User'"
        :breadcrumbs="[['label' => 'Home', 'url' => route('admin.dashboard')], ['label' => 'Users', 'url' => route('admin.users.index')], ['label' => $user->name, 'url' => route('admin.users.show', $user)], ['label' => 'Edit']]"
    />

    <div class="bg-white rounded shadow p-6 max-w-md">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="email" class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="input w-full" required>
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary">Update Email</button>
            <a href="{{ route('admin.users.show', $user) }}" class="btn-secondary ml-2">Cancel</a>
        </form>
    </div>
</x-admin.layout.layout>
