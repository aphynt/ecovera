@include('home.layout.head')
@include('home.layout.header')

<main class="content-wrapper">
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">

                        <h1 class="h4 mb-3">Pembayaran</h1>
                        <p class="text-muted mb-4">
                            Silakan selesaikan pembayaran Anda melalui metode yang tersedia.
                        </p>

                        <div class="alert alert-info mb-4">
                            Jangan menutup halaman ini sebelum proses pembayaran selesai.
                        </div>

                        <button id="pay-button"
                                class="btn btn-lg btn-primary w-100 rounded-pill">
                            Bayar Sekarang
                        </button>

                        <a href="{{ route('admin.orders.show', $orderId) }}"
                           class="btn btn-link mt-3">
                            Lihat Detail Pesanan
                        </a>

                    </div>
                </div>

            </div>
        </div>

    </div>
</main>

{{-- Midtrans Snap --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
document.getElementById('pay-button').addEventListener('click', function () {

    snap.pay('{{ $snapToken }}', {

        onSuccess: function (result) {
            console.log('SUCCESS', result);
            window.location.href = "{{ route('admin.orders.show', $orderId) }}";
        },

        onPending: function (result) {
            console.log('PENDING', result);
            window.location.href = "{{ route('admin.orders.show', $orderId) }}";
        },

        onError: function (result) {
            console.log('ERROR', result);
            alert('Pembayaran gagal. Silakan coba lagi.');
        },

        onClose: function () {
            alert('Pembayaran belum diselesaikan.');
        }

    });

});
</script>

@include('home.layout.footer')
