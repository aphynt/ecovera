@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Detail Pengajuan Pengembalian</h4>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('admin.returns.index') }}" class="btn btn-secondary btn-sm">
                    <i data-feather="arrow-left" class="icon-xs me-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Pengembalian</h5>
            </div>
            <div class="card-body">
                <div class="position-relative m-4">
                    <div class="progress" style="height: 2px;">
                        @php
                            $statusOrder = ['requested', 'approved', 'item_sent_back', 'item_received', 'refunded'];
                            $currentIndex = array_search($return->return_status, $statusOrder);
                            $progressPercent = $return->return_status == 'rejected' ? 0 : (($currentIndex / (count($statusOrder) - 1)) * 100);
                        @endphp
                        <div class="progress-bar" role="progressbar" style="width: {{ $progressPercent }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between position-absolute w-100" style="top: -12px;">
                        <div class="text-center" style="width: 20%;">
                            <div class="badge rounded-pill {{ in_array($return->return_status, ['requested','approved','item_sent_back','item_received','refunded']) ? 'bg-success' : 'bg-secondary' }}" style="width: 24px; height: 24px; line-height: 16px;">1</div>
                            <small class="d-block mt-1">Diajukan</small>
                            <small class="text-muted">{{ $return->created_at ? $return->created_at->format('d M') : '-' }}</small>
                        </div>
                        <div class="text-center" style="width: 20%;">
                            <div class="badge rounded-pill {{ in_array($return->return_status, ['approved','item_sent_back','item_received','refunded']) ? 'bg-success' : ($return->return_status == 'rejected' ? 'bg-danger' : 'bg-secondary') }}" style="width: 24px; height: 24px; line-height: 16px;">
                                {{ $return->return_status == 'rejected' ? '✕' : '2' }}
                            </div>
                            <small class="d-block mt-1">{{ $return->return_status == 'rejected' ? 'Ditolak' : 'Disetujui' }}</small>
                            <small class="text-muted">{{ $return->approved_at ? $return->approved_at->format('d M') : ($return->rejected_at ? $return->rejected_at->format('d M') : '-') }}</small>
                        </div>
                        <div class="text-center" style="width: 20%;">
                            <div class="badge rounded-pill {{ in_array($return->return_status, ['item_sent_back','item_received','refunded']) ? 'bg-success' : 'bg-secondary' }}" style="width: 24px; height: 24px; line-height: 16px;">3</div>
                            <small class="d-block mt-1">Dikirim</small>
                            <small class="text-muted">{{ $return->shipment && $return->shipment->shipped_at ? $return->shipment->shipped_at->format('d M') : '-' }}</small>
                        </div>
                        <div class="text-center" style="width: 20%;">
                            <div class="badge rounded-pill {{ in_array($return->return_status, ['item_received','refunded']) ? 'bg-success' : 'bg-secondary' }}" style="width: 24px; height: 24px; line-height: 16px;">4</div>
                            <small class="d-block mt-1">Diterima</small>
                            <small class="text-muted">{{ $return->shipment && $return->shipment->received_at ? $return->shipment->received_at->format('d M') : '-' }}</small>
                        </div>
                        <div class="text-center" style="width: 20%;">
                            <div class="badge rounded-pill {{ $return->return_status == 'refunded' ? 'bg-success' : 'bg-secondary' }}" style="width: 24px; height: 24px; line-height: 16px;">5</div>
                            <small class="d-block mt-1">Refund</small>
                            <small class="text-muted">{{ $return->refund && $return->refund->refunded_at ? $return->refund->refunded_at->format('d M') : '-' }}</small>
                        </div>
                    </div>
                </div>
                <div style="height: 40px;"></div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Order & Return Info -->
            <div class="col-lg-8">
                <!-- Order Information -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i data-feather="shopping-bag" class="icon-xs me-1"></i> Informasi Order
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted" width="40%">Kode Order</td>
                                        <td class="fw-semibold">{{ $return->order->order_code ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tanggal Order</td>
                                        <td>{{ $return->order->created_at ? $return->order->created_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Total Order</td>
                                        <td class="fw-semibold text-primary">Rp {{ number_format($return->order->grand_total ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted" width="40%">Status Order</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($return->order->status ?? '-') }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Metode Pembayaran</td>
                                        <td>{{ ucfirst($return->order->payment_method ?? '-') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Return Details -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i data-feather="refresh-cw" class="icon-xs me-1"></i> Detail Pengembalian
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small">Alasan Pengembalian</label>
                                <p class="fw-semibold">{{ $return->reason }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Status</label>
                                <p>
                                    <span class="badge bg-{{ $return->status_badge_color }} fs-6">
                                        {{ $return->status_label }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Deskripsi</label>
                            <p>{{ $return->description ?: 'Tidak ada deskripsi' }}</p>
                        </div>
                        @if($return->image)
                        <div class="mb-3">
                            <label class="text-muted small">Bukti Foto</label>
                            <div class="mt-2">
                                <a href="{{ asset('storage/'.$return->image) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$return->image) }}" alt="Bukti" class="img-thumbnail" style="max-height: 200px;">
                                </a>
                            </div>
                        </div>
                        @endif
                        @if($return->admin_note)
                        <div class="alert alert-info">
                            <label class="text-muted small mb-1">Catatan Admin</label>
                            <p class="mb-0">{{ $return->admin_note }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Items to Return -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i data-feather="package" class="icon-xs me-1"></i> Item yang Dikembalikan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Kondisi</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($return->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->primaryImage)
                                                <img src="{{ asset('storage/'.$item->product->primaryImage->image) }}" alt="" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i data-feather="image" class="text-muted"></i>
                                                </div>
                                                @endif
                                                <div class="ms-2">
                                                    <span class="fw-semibold">{{ $item->product->name ?? 'Produk' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>
                                            <span class="badge bg-{{ $item->condition == 'new' ? 'success' : ($item->condition == 'used' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($item->condition) }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}</td>
                                        <td class="fw-semibold">Rp {{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Tidak ada item</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Shipment Info -->
                @if($return->shipment)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i data-feather="truck" class="icon-xs me-1"></i> Informasi Pengiriman Kembali
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted" width="40%">Kurir</td>
                                        <td class="fw-semibold">{{ $return->shipment->courier }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">No. Resi</td>
                                        <td>{{ $return->shipment->tracking_number ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted" width="40%">Tanggal Kirim</td>
                                        <td>{{ $return->shipment->shipped_at ? $return->shipment->shipped_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tanggal Terima</td>
                                        <td>{{ $return->shipment->received_at ? $return->shipment->received_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Customer Info & Actions -->
            <div class="col-lg-4">
                <!-- Customer Info -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i data-feather="user" class="icon-xs me-1"></i> Informasi Pembeli
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="avatar-lg bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center">
                                    <span class="fs-24 text-primary">
                                        {{ substr($return->buyer->name ?? 'U', 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $return->buyer->name ?? '-' }}</h5>
                                <p class="text-muted mb-0">{{ $return->buyer->email ?? '-' }}</p>
                            </div>
                        </div>
                        <hr>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="text-muted">Telepon</td>
                                <td>{{ $return->buyer->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Bergabung</td>
                                <td>{{ $return->buyer->created_at ? $return->buyer->created_at->format('d M Y') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Seller Info -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i data-feather="user-check" class="icon-xs me-1"></i> Informasi Seller
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar bg-info-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span class="fs-16 text-info">
                                        {{ substr($return->seller->name ?? 'S', 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $return->seller->name ?? '-' }}</h6>
                                <small class="text-muted">{{ $return->seller->email ?? '' }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Processing Info -->
                @if($return->processor)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i data-feather="user-check" class="icon-xs me-1"></i> Refund Diproses Oleh
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar bg-success-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span class="fs-16 text-success">
                                        {{ substr($return->processor->name ?? 'A', 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $return->processor->name }}</h6>
                                <small class="text-muted">{{ $return->refund && $return->refund->refunded_at ? 'Refund: ' . $return->refund->refunded_at->format('d M Y H:i') : '' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Refund Info -->
                @if($return->refund)
                <div class="card mb-4 border-success">
                    <div class="card-header bg-success-subtle">
                        <h5 class="card-title mb-0">
                            <i data-feather="dollar-sign" class="icon-xs me-1"></i> Informasi Refund
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h3 class="text-success mb-0">Rp {{ number_format($return->refund->refund_amount, 0, ',', '.') }}</h3>
                            <small class="text-muted">Jumlah Refund</small>
                        </div>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="text-muted">Status</td>
                                <td>
                                    <span class="badge bg-{{ $return->refund->refund_status == 'success' ? 'success' : ($return->refund->refund_status == 'failed' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($return->refund->refund_status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal Refund</td>
                                <td>{{ $return->refund->refunded_at ? $return->refund->refunded_at->format('d M Y H:i') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i data-feather="settings" class="icon-xs me-1"></i> Aksi
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($return->return_status == 'approved')
                        <div class="alert alert-info">
                            <i data-feather="info" class="icon-xs me-1"></i>
                            Menunggu pembeli mengirimkan barang kembali.
                        </div>

                        @elseif($return->return_status == 'item_sent_back')
                        <div class="alert alert-warning">
                            <i data-feather="truck" class="icon-xs me-1"></i>
                            Barang sedang dalam pengiriman kembali. Menunggu seller menerima barang.
                        </div>

                        @elseif($return->return_status == 'item_received')
                        <div class="alert alert-success">
                            <i data-feather="check-circle" class="icon-xs me-1"></i>
                            Barang telah diterima. Silakan proses refund.
                        </div>
                        <form method="POST" action="{{ route('admin.returns.process-refund', $return->uuid) }}" class="mt-3">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Jumlah Refund <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="refund_amount" class="form-control" value="{{ $return->order->grand_total ?? 0 }}" min="0" step="100" required>
                                </div>
                                <small class="text-muted">Maksimal: Rp {{ number_format($return->order->grand_total ?? 0, 0, ',', '.') }}</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Refund</label>
                                <textarea name="admin_note" class="form-control" rows="2" placeholder="Catatan untuk refund..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Apakah Anda yakin ingin memproses refund?')">
                                <i data-feather="dollar-sign" class="icon-xs me-1"></i> Proses Refund
                            </button>
                        </form>

                        @elseif($return->return_status == 'refunded')
                        <div class="alert alert-success">
                            <i data-feather="check-circle" class="icon-xs me-1"></i>
                            Pengembalian telah selesai. Dana sudah dikembalikan ke pembeli.
                        </div>
                        <form method="POST" action="{{ route('admin.returns.cancel-refund', $return->uuid) }}" class="mt-3">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Alasan Pembatalan (jika perlu)</label>
                                <textarea name="admin_note" class="form-control" rows="2" placeholder="Catatan pembatalan refund..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Apakah Anda yakin ingin membatalkan refund ini?')">
                                <i data-feather="rotate-ccw" class="icon-xs me-1"></i> Batalkan Refund
                            </button>
                        </form>

                        @elseif($return->return_status == 'rejected')
                        <div class="alert alert-danger">
                            <i data-feather="x-circle" class="icon-xs me-1"></i>
                            Pengajuan pengembalian telah ditolak.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.layout.footer')
