<x-customer.layout.layout>
    <section class="container-custom">
        <x-customer.page-header title="Payment" description="Please wait..." />
        <x-customer.orders.checkout-progress :current="3" />

        <div class="py-20 text-center">
            <h2 class="text-2xl font-bold mb-4">Menyiapkan Pembayaran...</h2>
            <p class="text-gray-600 mb-6">Harap tunggu sebentar, kami sedang menghubungkan kamu ke Midtrans.</p>

            <div class="text-sm text-gray-500 italic">Jika pembayaran tidak muncul dalam beberapa detik, klik tombol di
                bawah ini.</div>
            <button id="pay-now"
                class="mt-6 inline-flex items-center justify-center bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                🔁 Bayar Sekarang
            </button>
            {{-- {{ $snapToken }} --}}
            <div class="mt-4 text-xs text-gray-400">Dibantu oleh Midtrans. Aman, cepat, dan terpercaya ✨</div>
        </div>
    </section>

    @if (config('midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
    @endif
    </script>
    <script>
        const snapToken = "{{ $snapToken }}";
        const orderCode = "{{ $order->order_code }}";

        // route dari Laravel (pakai dummy value biar nanti bisa diganti)
        const statusRouteTemplate = "{{ route('customer.checkout.status', ['status' => ':status', 'order_code' => ':orderCode']) }}";

        function redirectToStatus(status) {
            const redirectUrl = statusRouteTemplate
                .replace(':status', status)
                .replace(':orderCode', orderCode);

            window.location.href = redirectUrl;
        }

        const startPayment = () => {
            window.snap.pay(snapToken, {
                onSuccess: function (result) {
                    console.log("Pembayaran sukses", result);
                    redirectToStatus('success');
                },
                onPending: function (result) {
                    console.log("Pembayaran pending", result);
                    redirectToStatus('pending');
                },
                onError: function (result) {
                    console.error("Error pembayaran", result);
                    redirectToStatus('failed');
                },
                onClose: function () {
                    // Redirect ke route 'pending' tapi juga kasih pesan warning via query string (biar bisa ditampung jadi session)
                    const warningUrl = statusRouteTemplate
                        .replace(':status', 'pending')
                        .replace(':orderCode', orderCode) + '?closed=true';

                    window.location.href = warningUrl;
                }

            });
        };

        document.getElementById("pay-now").addEventListener("click", startPayment);
        window.addEventListener("load", () => setTimeout(startPayment, 1500));
    </script>

</x-customer.layout.layout>
