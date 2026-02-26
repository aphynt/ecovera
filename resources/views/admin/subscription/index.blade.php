@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')


<div class="content">

    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Berlangganan Premium</h4>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center p-4">
                        <div class="mb-4">
                            <i data-feather="award" class="text-primary" style="width: 64px; height: 64px;"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Mulai Berlangganan Sekarang!</h4>
                        <p class="text-muted mb-4 text-start">
                            Dengan berlangganan fitur premium, Anda akan mendapatkan keuntungan eksklusif:
                        </p>
                        <ul class="text-muted text-start mb-4" style="line-height: 1.8;">
                            <li><strong>Prioritas Pencarian:</strong> Produk dari Anda akan selalu tampil di urutan
                                <b>Paling Atas</b> pada halaman Cari Produk dan halaman Kategori.</li>
                            <li><strong>Meningkatkan Visibilitas:</strong> Produk Anda akan jauh lebih mudah ditemukan
                                oleh para calon pembeli setiap harinya.</li>
                            <li><strong>Meningkatkan Potensi Penjualan:</strong> Posisi produk yang strategis memberikan
                                peluang produk Anda terjual lebih cepat.</li>
                        </ul>

                        @if(Auth::user()->is_subscribed)
                            <div class="alert alert-success fw-bold">
                                Berlangganan Aktif! Produk Anda sedang diprioritaskan.
                            </div>
                        @else
                            <button class="btn btn-primary btn-lg w-100 fw-bold btn-subscribe">
                                Berlangganan (Rp 30.000/Bulan)
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript"
    src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const subscribeBtn = document.querySelector('.btn-subscribe');

        if (subscribeBtn) {
            subscribeBtn.addEventListener('click', function () {
                this.disabled = true;
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

                fetch("{{ route('seller.subscription.process') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        this.disabled = false;
                        this.innerHTML = originalText;
                        if (typeof feather !== 'undefined') feather.replace();

                        if (data.status === 'success') {
                            snap.pay(data.snap_token, {
                                onSuccess: function (result) {
                                    Swal.fire('Sukses!', 'Pembayaran berhasil. Status langganan akan segera aktif.', 'success')
                                        .then(() => window.location.reload());
                                },
                                onPending: function (result) {
                                    Swal.fire('Menunggu', 'Menunggu pembayaran diselesaikan.', 'info')
                                        .then(() => window.location.reload());
                                },
                                onError: function (result) {
                                    Swal.fire('Error', 'Pembayaran gagal. Silakan coba lagi.', 'error');
                                },
                                onClose: function () {
                                    // User closed popup
                                }
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Terjadi kesalahan.', 'error');
                        }
                    })
                    .catch(error => {
                        this.disabled = false;
                        this.innerHTML = originalText;
                        if (typeof feather !== 'undefined') feather.replace();
                        Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
                        console.error('Error:', error);
                    });
            });
        }
    });
</script>
@include('admin.layout.footer')