@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')


<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Toko</h4>
            </div>
            <div class="d-flex align-items-center">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.store.insert') }}" class="btn btn-success btn-sm">
                        <i data-feather="plus" class="icon-xs"></i>
                        Tambah
                    </a>
                @else
                    <a href="{{ route('seller.store.insert') }}" class="btn btn-success btn-sm">
                        <i data-feather="plus" class="icon-xs"></i>
                        Tambah
                    </a>
                @endif
            </div>
        </div>

        <div class="row">

            @forelse ($stores as $store)
                <div class="col-xl-6 col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 store-card">

                        <div class="card-body d-flex flex-column">

                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-semibold mb-1">
                                        {{ $store->store_name }}
                                    </h5>
                                    <span class="text-muted fs-13">
                                        {{ $store->store_slug }}
                                    </span>
                                </div>

                                @if ($store->is_verified)
                                    <span class="badge bg-success">
                                        <i data-feather="check-circle" class="icon-xs me-1"></i>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Belum Verifikasi
                                    </span>
                                @endif
                            </div>

                            <!-- Description -->
                            <p class="text-muted fs-14 mb-3">
                                {{ Str::limit($store->description ?? 'Tidak ada deskripsi.', 550) }}
                            </p>

                            <!-- Info -->
                            <div class="mb-3">
                                <div class="d-flex align-items-center text-muted fs-13 mb-1">
                                    <i data-feather="map-pin" class="icon-xs me-2"></i>
                                    {{ Str::limit($store->address ?? '-', 150) }}
                                </div>

                                <div class="d-flex align-items-center text-muted fs-13">
                                    <i data-feather="star" class="icon-xs me-2 text-warning"></i>
                                    Rating: {{ $store->rating ?? '0.0' }}
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="mt-auto d-flex gap-2">
                                @if (!$store->is_verified)
                                    @if (Auth::user()->role == 'admin')
                                        <button class="btn btn-success btn-sm w-100"
                                            onclick="verifyStore('{{ $store->uuid }}', '{{ $store->store_name }}')">
                                            <i data-feather="check-circle" class="icon-xs me-1"></i>
                                            Verifikasi
                                        </button>
                                    @endif

                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.store.edit', $store->uuid) }}"
                                            class="btn btn-sm btn-primary w-100">
                                            <i data-feather="edit" class="icon-xs me-1"></i>
                                            Edit
                                        </a>
                                    @else
                                        <a href="{{ route('seller.store.edit', $store->uuid) }}"
                                            class="btn btn-sm btn-primary w-100">
                                            <i data-feather="edit" class="icon-xs me-1"></i>
                                            Edit
                                        </a>
                                    @endif
                                @endif

                                @if(Auth::user()->role === 'seller' && $store->is_verified)
                                    <div class="d-flex flex-column w-100 text-center align-items-center">
                                        @if($store->is_subscribed)
                                            <button class="btn btn-success btn-sm w-100" disabled>
                                                Berlangganan Aktif (s/d
                                                {{ \Carbon\Carbon::parse($store->subscription_ends_at)->format('d M Y') }})
                                            </button>
                                        @else
                                            <button class="btn btn-primary btn-sm w-100 text-white fw-bold btn-subscribe"
                                                data-uuid="{{ $store->uuid }}">
                                                Berlangganan (Rp 30.000/Bulan)
                                            </button>
                                        @endif
                                        <a href="#" class="text-primary mt-2 fs-14 fw-semibold text-decoration-underline"
                                            data-bs-toggle="modal" data-bs-target="#benefitModal">Benefit Berlangganan</a>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center">
                        <i data-feather="shopping-bag" class="mb-2"></i>
                        <p class="mb-0">Belum ada data toko.</p>
                    </div>
                </div>
            @endforelse

        </div>



    </div> <!-- container-fluid -->
</div>
<form id="verify-form" method="POST" style="display: none;">
    @csrf
    @method('PUT')
</form>

<!-- Benefit Berlangganan Modal -->
<div class="modal fade" id="benefitModal" tabindex="-1" aria-labelledby="benefitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-primary" id="benefitModalLabel">Mulai Berlangganan Sekarang!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start">
                <div class="text-center mb-3">
                    <i data-feather="trending-up" class="text-primary" style="width: 48px; height: 48px;"></i>
                </div>
                <p class="mb-3 text-muted">Dengan berlangganan fitur ini, Anda akan mendapatkan keuntungan eksklusif:
                </p>
                <ul class="mb-0 text-muted" style="line-height: 1.6;">
                    <li class="mb-2"><strong>Prioritas Pencarian:</strong> Produk dari toko Anda akan selalu tampil di
                        urutan <b>Paling Atas</b> pada halaman Cari Produk dan halaman Kategori.</li>
                    <li class="mb-2"><strong>Meningkatkan Visibilitas:</strong> Toko Anda akan jauh lebih mudah
                        ditemukan oleh para calon pembeli setiap harinya.</li>
                    <li><strong>Meningkatkan Potensi Penjualan:</strong> Posisi produk yang strategis memberikan peluang
                        produk Anda terjual lebih cepat.</li>
                </ul>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"
    src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    function verifyStore(uuid, storeName) {
        const verifyRoute = "{{ route('admin.store.verify', ':uuid') }}";
        Swal.fire({
            title: 'Verifikasi Toko?',
            html: `<strong>${storeName}</strong><br>akan ditandai sebagai <b>Terverifikasi</b>.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Verifikasi',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('verify-form');
                form.action = verifyRoute.replace(':uuid', uuid);
                form.submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const subscribeBtns = document.querySelectorAll('.btn-subscribe');

        subscribeBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const uuid = this.getAttribute('data-uuid');

                // Disable button during process
                this.disabled = true;
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

                fetch(`/seller/store/subscribe/${uuid}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        // Restore button state
                        this.disabled = false;
                        this.innerHTML = originalText;
                        feather.replace();

                        if (data.status === 'success') {
                            snap.pay(data.snap_token, {
                                onSuccess: function (result) {
                                    Swal.fire('Sukses!', 'Pembayaran berhasil. Status langganan akan segera aktif.', 'success')
                                        .then(() => window.location.reload());
                                },
                                onPending: function (result) {
                                    Swal.fire('Menunggu', 'Menunggu pembayaran diselesaikan.', 'info');
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
                        feather.replace();
                        Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
                        console.error('Error:', error);
                    });
            });
        });
    });
</script>
@include('admin.layout.footer')