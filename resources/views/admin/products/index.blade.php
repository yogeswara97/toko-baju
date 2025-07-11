<x-admin.layout.layout :title="'Products'">
    <x-admin.layout.header title="Products" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('admin.dashboard')],
        ['label' => 'Products'],
    ]" />

    <x-admin.table.table-search
        :dataset="$products"
        :routeReset="route('admin.products.index')"
        :routeCreate="route('admin.products.create')"
        create="Add Product">
        {{-- slot untuk form search --}}
    </x-admin.table.table-search>

    <div class="overflow-x-auto rounded-lg shadow mt-4 bg-white">
        <x-admin.table.table :headers="['image','Name', 'Category', 'Price', 'Stock', 'Action']">
             @foreach ($products as $product)
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">

                    <td class="px-6 py-4">
                        <img src="{{ $product->image ? asset($product->image) : asset('assets/static-images/no-image.jpg') }}"
                            class="w-20 h-28 rounded object-cover" />
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $product->name }}
                    </td>
                    <td class="px-6 py-4">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $product->qty }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            {{ $product->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="button-mini-edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure to delete {{ $product->name }}?')"
                                    class="button-mini-delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table.table>
    </div>

    {{-- Pagination --}}
    <x-admin.table.table-navigation :dataset="$products" :perPage="10" />
</x-admin.layout.layout>
