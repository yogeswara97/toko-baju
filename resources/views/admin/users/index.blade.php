<x-admin.layout.layout :title="'Users'">
    <x-admin.layout.header title="Users"
        :breadcrumbs="[['label' => 'Home', 'url' => route('admin.dashboard')], ['label' => 'Users']]" />

    {{-- TABLE HEADER --}}
    <div class="bg-white rounded-t-lg shadow border border-gray-200">
        <x-admin.table.table-header :dataset="$users" :routeReset="route('admin.users.index')">
            <x-slot:filter>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email"
                    class="input-filter" />
            </x-slot:filter>
        </x-admin.table.table-header>
    </div>

    {{-- TABLE BODY --}}
    <div class="overflow-x-auto rounded-b-lg shadow bg-white">
        <x-admin.table.table :headers="['Name', 'Email', 'Phone', 'Role', 'Status', 'Created At', 'Action']">
            @foreach ($users as $user)
            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                <td class="px-6 py-4">{{ $user->name }}</td>
                <td class="px-6 py-4">{{ $user->email }}</td>
                <td class="px-6 py-4">{{ $user->phone_number ?? '-' }}</td>
                <td class="px-6 py-4 capitalize">{{ $user->role }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs font-semibold
                            {{ $user->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="button-mini-show"
                        title="Lihat detail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="button-mini-edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block"
                        onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button-mini-delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </x-admin.table.table>
    </div>

    {{-- Pagination --}}
    <x-admin.table.table-navigation :dataset="$users" :perPage="10" />
</x-admin.layout.layout>
