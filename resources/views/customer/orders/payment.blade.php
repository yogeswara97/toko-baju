<x-customer.layout.layout>
    <section class="container-custom py-20 text-center">
        <h2 class="text-2xl font-bold mb-4">Membuka Pembayaran...</h2>
        <p class="text-gray-600 mb-8">Tunggu sebentar ya, kami sedang menyiapkan metode pembayaran kamu.</p>

        <div class="text-sm text-gray-400 italic">Jika tidak otomatis, klik tombol di bawah ini.</div>
        <button id="pay-now" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
            Bayar Sekarang
        </button>
    </section>

    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        const snapToken = "{{ $snapToken }}";

        function startPayment() {
            window.snap.pay(snapToken, {
                onSuccess: function(result) {
                    window.location.href = "/checkout/success";
                },
                onPending: function(result) {
                    window.location.href = "/checkout/pending";
                },
                onError: function(result) {
                    alert("Gagal memproses pembayaran. Coba lagi.");
                },
                onClose: function() {
                    alert("Kamu menutup pembayaran sebelum selesai.");
                }
            });
        }

        document.getElementById('pay-now').addEventListener('click', startPayment);

        // Auto open Snap
        window.onload = () => setTimeout(startPayment, 1000);
    </script>
</x-customer.layout.layout>
