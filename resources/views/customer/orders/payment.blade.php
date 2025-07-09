<x-customer.layout.layout>
    <section class="container-custom py-20 text-center">
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
    </section>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
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
                    alert("Kamu menutup pembayaran sebelum selesai");
                    redirectToStatus('pending');
                }
            });
        };

        document.getElementById("pay-now").addEventListener("click", startPayment);
        window.addEventListener("load", () => setTimeout(startPayment, 1500));
    </script>

</x-customer.layout.layout>
