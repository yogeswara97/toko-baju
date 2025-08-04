@props(['subtotal', 'shipping', 'discount', 'total'])

@php
    $items = [
        ['label' => 'Subtotal', 'value' => $subtotal],
        ['label' => 'Shipping', 'value' => $shipping],
        ['label' => 'Tax', 'value' => null],
    ];
@endphp

<div class="space-y-3 mb-6 border-t border-gray-200 pt-4">
    @foreach ($items as $item)
        <div class="flex justify-between">
            <span class="text-gray-600">{{ $item['label'] }}</span>
            <span class="font-semibold {{ $item['label'] === 'Shipping' ? 'text-gray-700' : '' }}"
                id="{{ $item['label'] === 'Shipping' ? 'summary-shipping' : '' }}">
                @if (!is_null($item['value']))
                    Rp{{ number_format($item['value'], 0, ',', '.') }}
                @else
                    -
                @endif
            </span>
        </div>
    @endforeach

    @if ($discount > 0)
        <div class="flex justify-between">
            <span class="text-gray-600">Discount</span>
            <span class="font-semibold text-red-500">-Rp{{ number_format($discount, 0, ',', '.') }}</span>
        </div>
    @endif

    <div class="border-t border-gray-200 pt-3">
        <div class="flex justify-between">
            <span class="text-lg font-semibold">Total</span>
            <span class="text-lg font-semibold text-primary" id="total-amount"
                data-subtotal="{{ $subtotal }}" data-discount="{{ $discount }}">
                Rp{{ number_format($total, 0, ',', '.') }}
            </span>
        </div>
    </div>
</div>
