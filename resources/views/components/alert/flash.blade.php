@php
    $alerts = [
        'success' => [
            'title' => 'Success!',
            'message' => session('success'),
            'icon' => 'fas fa-check-circle',
        ],
        'error' => [
            'title' => 'Oops!',
            'message' => session('error'),
            'icon' => 'fas fa-times-circle',
        ],
        'warning' => [
            'title' => 'Warning!',
            'message' => session('warning'),
            'icon' => 'fas fa-exclamation-triangle',
        ],
        'info' => [
            'title' => 'FYI',
            'message' => session('info'),
            'icon' => 'fas fa-info-circle',
        ],
    ];

    foreach ($alerts as $type => $alert) {
        if (!empty($alert['message'])) {
            $activeType = $type;
            $activeAlert = $alert;
            break;
        }
    }

    $colors = [
        'success' => [
            'bg' => 'bg-green-100',
            'text' => 'text-green-800',
            'border' => 'border-green-200',
        ],
        'error' => [
            'bg' => 'bg-red-100',
            'text' => 'text-red-800',
            'border' => 'border-red-200',
        ],
        'warning' => [
            'bg' => 'bg-yellow-100',
            'text' => 'text-yellow-800',
            'border' => 'border-yellow-200',
        ],
        'info' => [
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-800',
            'border' => 'border-blue-200',
        ],
    ];
@endphp

@if (!empty($activeAlert ?? null))
    @php $color = $colors[$activeType]; @endphp

    <div id="top-alert"
        class="fixed top-0 left-1/2 transform -translate-x-1/2 z-50 mt-20 w-full max-w-xl px-4 animate-slide-down">
        <div class="flex items-center justify-between p-4 rounded-lg shadow-md border {{ $color['bg'] }} {{ $color['text'] }} {{ $color['border'] }}"
            role="alert">
            <div class="flex items-center gap-2">
                <i class="{{ $activeAlert['icon'] }} text-lg"></i>
                <span class="font-medium">{{ $activeAlert['title'] }}</span> {{ $activeAlert['message'] }}
            </div>
            <button type="button" class="ml-2 hover:text-black"
                onclick="document.getElementById('top-alert').classList.add('hidden')">✕</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const alert = document.getElementById('top-alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.add('hidden');
                }, 3000);
            }
        });
    </script>
@endif
