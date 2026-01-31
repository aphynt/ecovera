@include('home.layout.head')
@include('home.layout.header')

<main class="content-wrapper">
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.profile') }}">Profil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengembalian</li>
        </ol>
    </nav>

    <section class="container pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
        <div class="row">
            @include('home.profile.sidebar')
            <div class="col-lg-9">
                <h2 class="h3 mb-4">Pengembalian Barang/Dana</h2>
                
                @if($data['returns']->isEmpty())
                    <div class="alert alert-info">Belum ada riwayat pengembalian barang/dana.</div>
                @else
                    @foreach($data['returns'] as $return)
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-semibold">Order: {{ $return->order->order_code ?? '-' }}</span>
                                <span class="badge bg-{{ $return->status_badge_color }} ms-2">{{ $return->status_label }}</span>
                            </div>
                            <small class="text-muted">{{ $return->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <div class="card-body">
                            <!-- Timeline -->
                            <div class="position-relative mb-4">
                                <div class="progress" style="height: 3px;">
                                    @php
                                        $statusOrder = ['requested', 'approved', 'item_sent_back', 'item_received', 'refunded'];
                                        $currentIndex = array_search($return->return_status, $statusOrder);
                                        $progressPercent = $return->return_status == 'rejected' ? 0 : (($currentIndex / (count($statusOrder) - 1)) * 100);
                                    @endphp
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progressPercent }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between position-absolute w-100" style="top: -8px;">
                                    <div class="text-center" style="width: 20%;">
                                        <div class="badge rounded-pill {{ in_array($return->return_status, ['requested','approved','item_sent_back','item_received','refunded']) ? 'bg-success' : 'bg-secondary' }}" style="width: 18px; height: 18px; line-height: 10px; font-size: 10px;">1</div>
                                        <small class="d-block mt-1" style="font-size: 10px;">Diajukan</small>
                                    </div>
                                    <div class="text-center" style="width: 20%;">
                                        <div class="badge rounded-pill {{ in_array($return->return_status, ['approved','item_sent_back','item_received','refunded']) ? 'bg-success' : ($return->return_status == 'rejected' ? 'bg-danger' : 'bg-secondary') }}" style="width: 18px; height: 18px; line-height: 10px; font-size: 10px;">
                                            {{ $return->return_status == 'rejected' ? '✕' : '2' }}
                                        </div>
                                        <small class="d-block mt-1" style="font-size: 10px;">{{ $return->return_status == 'rejected' ? 'Ditolak' : 'Disetujui' }}</small>
                                    </div>
                                    <div class="text-center" style="width: 20%;">
                                        <div class="badge rounded-pill {{ in_array($return->return_status, ['item_sent_back','item_received','refunded']) ? 'bg-success' : 'bg-secondary' }}" style="width: 18px; height: 18px; line-height: 10px; font-size: 10px;">3</div>
                                        <small class="d-block mt-1" style="font-size: 10px;">Dikirim</small>
                                    </div>
                                    <div class="text-center" style="width: 20%;">
                                        <div class="badge rounded-pill {{ in_array($return->return_status, ['item_received','refunded']) ? 'bg-success' : 'bg-secondary' }}" style="width: 18px; height: 18px; line-height: 10px; font-size: 10px;">4</div>
                                        <small class="d-block mt-1" style="font-size: 10px;">Diterima</small>
                                    </div>
                                    <div class="text-center" style="width: 20%;">
                                        <div class="badge rounded-pill {{ $return->return_status == 'refunded' ? 'bg-success' : 'bg-secondary' }}" style="width: 18px; height: 18px; line-height: 10px; font-size: 10px;">5</div>
                                        <small class="d-block mt-1" style="font-size: 10px;">Refund</small>
                                    </div>
                                </div>
                            </div>
                            <div style="height: 30px;"></div>

                            <!-- Return Info -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Alasan</label>
                                    <p class="mb-1">{{ $return->reason }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Produk</label>
                                    <p class="mb-1">
                                        @if($return->items->count() > 0)
                                            {{ $return->items->first()->product->name ?? 'Produk' }}
                                            @if($return->items->count() > 1)
                                                +{{ $return->items->count() - 1 }} lainnya
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @if($return->description)
                            <div class="mb-3">
                                <label class="text-muted small">Deskripsi</label>
                                <p class="mb-1">{{ $return->description }}</p>
                            </div>
                            @endif

                            @if($return->image)
                            <div class="mb-3">
                                <label class="text-muted small">Bukti Foto</label>
                                <div class="mt-1">
                                    <a href="{{ asset('storage/'.$return->image) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$return->image) }}" alt="Bukti" class="img-thumbnail" style="max-height: 150px;">
                                    </a>
                                </div>
                            </div>
                            @endif

                            <!-- Return Address (if approved) -->
                            @if($return->return_address && in_array($return->return_status, ['approved', 'item_sent_back', 'item_received', 'refunded']))
                            <div class="alert alert-success">
                                <label class="text-muted small mb-1">Alamat Pengembalian</label>
                                <p class="mb-0">{{ $return->return_address }}</p>
                            </div>
                            @endif

                            <!-- Shipment Info (if item_sent_back or later) -->
                            @if($return->shipment && in_array($return->return_status, ['item_sent_back', 'item_received', 'refunded']))
                            <div class="alert alert-info">
                                <label class="text-muted small mb-1">Informasi Pengiriman Kembali</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <small class="text-muted">Kurir</small>
                                        <p class="mb-0">{{ $return->shipment->courier }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">No. Resi</small>
                                        <p class="mb-0">{{ $return->shipment->tracking_number ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Tanggal Kirim</small>
                                        <p class="mb-0">{{ $return->shipment->shipped_at ? $return->shipment->shipped_at->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Refund Info -->
                            @if($return->refund)
                            <div class="alert alert-success border-success">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <label class="text-muted small mb-1">Refund Berhasil</label>
                                        <h5 class="mb-0 text-success">Rp {{ number_format($return->refund->refund_amount, 0, ',', '.') }}</h5>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block">Tanggal</small>
                                        <span>{{ $return->refund->refunded_at ? $return->refund->refunded_at->format('d M Y H:i') : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Action for Buyer -->
                            @if($return->return_status == 'approved')
                            <div class="alert alert-warning">
                                <i data-feather="info" class="icon-xs me-1"></i>
                                Silakan kirimkan barang ke alamat yang telah diberikan oleh seller.
                            </div>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#shipmentModal{{ $return->id }}">
                                <i data-feather="truck" class="icon-xs me-1"></i> Input Resi Pengiriman
                            </button>

                            <!-- Shipment Modal -->
                            <div class="modal fade" id="shipmentModal{{ $return->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Input Resi Pengiriman</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('buyer.returns.submit-shipment', $return->uuid) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Kurir <span class="text-danger">*</span></label>
                                                    <input type="text" name="courier" class="form-control" placeholder="Contoh: JNE, J&T, SiCepat" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nomor Resi <span class="text-danger">*</span></label>
                                                    <input type="text" name="tracking_number" class="form-control" placeholder="Masukkan nomor resi" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($return->seller_note)
                            <div class="alert alert-secondary mt-3">
                                <label class="text-muted small mb-1">Catatan Seller</label>
                                <p class="mb-0">{{ $return->seller_note }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif
                
                <div class="mt-4">
                    <small class="text-muted">Estimasi paling lambat 30 hari, tergantung pada pengiriman dan pembayaran yang terkait.</small>
                </div>
            </div>
        </div>
    </section>
</main>

@include('home.layout.footer')
