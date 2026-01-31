@include('home.layout.head')
@include('home.layout.header')

<!-- Page content -->
<main class="content-wrapper">
    
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.profile') }}">Profil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pesanan Saya</li>
        </ol>
    </nav>

    <section class="container pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
        <div class="row">
            
            <!-- Sidebar -->
            @include('home.profile.sidebar')

            <!-- Main Content -->
            <div class="col-lg-9">
                <h2 class="h3 mb-4">Pesanan Saya</h2>

                @if($data['orders']->count() > 0)
                    @foreach($data['orders'] as $order)
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <small class="text-muted">Kode Pesanan:</small>
                                    <strong class="d-block">{{ $order->order_code }}</strong>
                                    <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'warning',
                                            'paid' => 'info',
                                            'processed' => 'primary',
                                            'shipped' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                            'refunded' => 'secondary'
                                        ];
                                        $statusTexts = [
                                            'pending' => 'Menunggu Pembayaran',
                                            'paid' => 'Sudah Dibayar',
                                            'processed' => 'Diproses',
                                            'shipped' => 'Dikirim',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                            'refunded' => 'Dikembalikan'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusClasses[$order->status] ?? 'secondary' }}">
                                        {{ $statusTexts[$order->status] ?? $order->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="cursor: pointer;" onclick="window.location='{{ route('admin.orders.detail', $order->uuid) }}'">
                            @foreach($order->items as $item)
                            <div class="d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <img src="{{ $item->product->primaryImage 
                                            ? asset('storage/'.$item->product->primaryImage->image_url) 
                                            : asset('logo/logo.png') }}"
                                     class="rounded me-3"
                                     style="width: 80px; height: 80px; object-fit: cover;"
                                     alt="{{ $item->product->name }}">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item->product->name }}</h6>
                                    <p class="text-muted mb-1">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-end">
                                    <strong>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                            @endforeach

                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <div>
                                    <span class="text-muted">Total Belanja:</span>
                                    <strong class="h5 mb-0 ms-2">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</strong>
                                    <br>
                                    <span class="badge bg-secondary mt-2">
                                        Metode: 
                                        @if($order->payment_method === 'cod')
                                            COD
                                        @elseif($order->payment_method === 'midtrans' || $order->payment_method === 'transfer')
                                            Transfer Bank / E-Wallet
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div onclick="event.stopPropagation();">
                                    @if($order->status === 'pending' && $order->payment_method === 'midtrans')
                                    <a href="{{ route('admin.orders.payment', $order->uuid) }}" class="btn btn-primary">
                                        <i class="ci-credit-card me-2"></i>Lakukan Pembayaran
                                    </a>
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $order->id }}">
                                        <i class="ci-close me-2"></i>Batalkan Pesanan
                                    </button>
                                    @elseif($order->status === 'pending' && $order->payment_method === 'cod')
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $order->id }}">
                                        <i class="ci-close me-2"></i>Batalkan Pesanan
                                    </button>
                                    @elseif($order->status === 'shipped')
                                    <form action="{{ route('admin.orders.complete', $order->uuid) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">
                                            <i class="ci-check me-2"></i>Pesanan Diterima
                                        </button>
                                    </form>
                                    @elseif(in_array($order->status, ['paid', 'completed']))
                                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#returnModal{{ $order->id }}">
                                        <i class="ci-undo me-2"></i>Ajukan Pengembalian
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cancel Modal -->
                    <div class="modal fade" id="cancelModal{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.orders.cancel', $order->uuid) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pembatalan Pesanan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-3">Pilih alasan pembatalan:</p>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason1{{ $order->id }}" value="Salah dalam memilih produk" required>
                                            <label class="form-check-label" for="reason1{{ $order->id }}">
                                                Salah dalam memilih produk
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason2{{ $order->id }}" value="Ingin mengubah atau membuat pesanan baru">
                                            <label class="form-check-label" for="reason2{{ $order->id }}">
                                                Ingin mengubah atau membuat pesanan baru
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason3{{ $order->id }}" value="Ingin menggunakan metode pembayaran lain">
                                            <label class="form-check-label" for="reason3{{ $order->id }}">
                                                Ingin menggunakan metode pembayaran lain
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason4{{ $order->id }}" value="Lainnya / Berubah pikiran">
                                            <label class="form-check-label" for="reason4{{ $order->id }}">
                                                Lainnya / Berubah pikiran
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Catatan Tambahan (Opsional)</label>
                                            <textarea name="cancel_note" class="form-control" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-danger">Konfirmasi Pembatalan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Return Modal -->
                    <div class="modal fade" id="returnModal{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.orders.return', $order->uuid) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ajukan Pengembalian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-3">Alasan pengembalian:</p>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="return_reason" id="return1{{ $order->id }}" value="Produk cacat/rusak" required>
                                            <label class="form-check-label" for="return1{{ $order->id }}">
                                                Produk cacat/rusak
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="return_reason" id="return2{{ $order->id }}" value="Produk tidak sesuai deskripsi">
                                            <label class="form-check-label" for="return2{{ $order->id }}">
                                                Produk tidak sesuai deskripsi
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="return_reason" id="return3{{ $order->id }}" value="Produk tidak lengkap">
                                            <label class="form-check-label" for="return3{{ $order->id }}">
                                                Produk tidak lengkap
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="return_reason" id="return4{{ $order->id }}" value="Lainnya">
                                            <label class="form-check-label" for="return4{{ $order->id }}">
                                                Lainnya
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi Masalah</label>
                                            <textarea name="return_description" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Upload Foto Bukti (Opsional)</label>
                                            <input type="file" name="return_image" class="form-control" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Pagination -->
                    @if($data['orders']->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $data['orders']->links() }}
                    </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="ci-package fs-1 text-muted mb-3 d-block"></i>
                        <h5 class="mb-2">Belum ada pesanan</h5>
                        <p class="text-muted mb-4">Anda belum memiliki pesanan apapun</p>
                        <a href="{{ route('products.all') }}" class="btn btn-primary">
                            <i class="ci-cart me-2"></i>
                            Mulai Belanja
                        </a>
                    </div>
                @endif

                <p class="text-muted mt-4">
                    <strong>Tampilan ketika pembeli sudah memesan barang</strong>
                </p>

            </div>
        </div>
    </section>

</main>

@include('home.layout.footer')
