@props([
    'id' => 'confirm-modal',
    'title' => 'Yakin?',
    'message' => 'Tindakan ini tidak dapat dibatalkan.',
    'confirmText' => 'Ya',
    'cancelText' => 'Batal',
    'action' => '#',
    'method' => 'POST',
])

<style>
    [x-cloak] { display: none !important; }

    @keyframes slide-from-top {
        0% {
            opacity: 0;
            transform: translateY(-100px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-slide-top {
        animation: slide-from-top 0.2s ease-out both;
    }
</style>

<div
    x-data="{ open: false }"
    x-show="open"
    @open-modal.window="if ($event.detail.id === '{{ $id }}') open = true"
    @click.self="open = false"
    class="fixed inset-0 z-50 bg-black/20 px-4 overflow-y-auto min-h-screen"
    x-cloak
>
    <div class="modal-slide-top bg-white rounded-xl shadow-lg max-w-md w-full p-6 mt-10 mx-auto">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $title }}</h2>
        <p class="text-sm text-gray-600">{{ $message }}</p>

        <div class="flex justify-end gap-3 mt-6">
            <button @click="open = false"
                class="px-4 py-2 text-sm rounded bg-gray-100 text-gray-700 hover:bg-gray-200">
                {{ $cancelText }}
            </button>

            <form method="POST" action="{{ $action }}">
                @csrf
                @if (strtoupper($method) !== 'POST')
                    @method($method)
                @endif
                <button type="submit"
                    class="px-4 py-2 text-sm rounded bg-red-600 text-white hover:bg-red-700">
                    {{ $confirmText }}
                </button>
            </form>
        </div>
    </div>
</div>
