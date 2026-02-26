@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Detail Pesanan</h4>
            </div>
            <div class="text-end mt-3 mt-sm-0">
                <a href="{{ route('seller.orders.index') }}" class="btn btn-secondary">
                    <i data-feather="arrow-left" class="icon-xs me-1"></i> Kembali
                </a>
            </div>
        </div>

        @include('alert')

        <!-- Order Info Card -->
        <div class="row">
            <div class="col-lg-8">
                <!-- Order Details -->
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Informasi Pesanan</h5>
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'paid' => 'info',
                                    'processed' => 'primary',
                                    'shipped' => 'primary',
                                    'completed' => 'success',
                                    'cancelled' => 'danger',
                                    'refunded' => 'secondary',
                                ];
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'paid' => 'Paid - Menunggu Proses',
                                    'processed' => 'Processed - Sedang Diproses',
                                    'shipped' => 'Shipped - Dalam Pengiriman',
                                    'completed' => 'Completed - Selesai',
                                    'cancelled' => 'Cancelled - Dibatalkan',
                                    'refunded' => 'Refunded - Dikembalikan',
                                ];
                                
                                // For COD orders, show different text for paid status
                                if ($order->status === 'paid' && $order->payment_method === 'cod') {
                                    $statusLabels['paid'] = 'COD - Menunggu Proses';
                                }
                            @endphp
                            <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} fs-6">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted">Kode Pesanan</td>
                                        <td class="fw-bold">{{ $order->order_code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tanggal Pesanan</td>
                                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Metode Pembayaran</td>
                                        <td class="text-uppercase">{{ $order->payment_method ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted">Total Pesanan</td>
                                        <td class="fw-bold">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Total Anda</td>
                                        <td class="fw-bold text-primary">Rp {{ number_format($order->seller_total, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Ongkir</td>
                                        <td>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @if($order->payment_method === 'cod' && $order->status === 'completed' && !$order->buyer_confirmed_at)
                        <div class="alert alert-warning mt-3 mb-0">
                            <i data-feather="alert-triangle" class="icon-xs me-1"></i>
                            <strong>Info Auto-Complete:</strong> Pesanan ini diselesaikan otomatis oleh sistem karena pembeli tidak mengkonfirmasi dalam 3 hari. Dana telah dicairkan.
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Produk yang Dibeli (Dari Anda)</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->seller_items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    @if($item->product && $item->product->primaryImage)
                                                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_url) }}" 
                                                             alt="{{ $item->product->name }}"
                                                             class="rounded" style="width: 100%; max-width: 100px; height: 100px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                             style="width: 100px; height: 100px;">
                                                            <i data-feather="image" class="text-muted" style="width: 40px; height: 40px;"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $item->product->name ?? 'Produk tidak tersedia' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total Anda:</td>
                                        <td class="text-end fw-bold text-primary fs-5">
                                            Rp {{ number_format($order->seller_total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Pengiriman</h5>
                    </div>
                    <div class="card-body">
                        @if($order->shipment)
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted">Kurir</td>
                                            <td class="fw-bold">{{ $order->shipment->courier }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Nomor Resi</td>
                                            <td class="fw-bold text-primary">{{ $order->shipment->tracking_number ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-muted">Status Pengiriman</td>
                                            <td>
                                                <span class="badge bg-{{ $order->shipment->shipping_status == 'delivered' ? 'success' : ($order->shipment->shipping_status == 'shipped' ? 'primary' : 'warning') }}">
                                                    {{ ucfirst($order->shipment->shipping_status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Tanggal Kirim</td>
                                            <td>{{ $order->shipment->shipped_at ? $order->shipment->shipped_at->format('d M Y H:i') : '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i data-feather="truck" class="icon-lg mb-2"></i>
                                <p>Belum ada informasi pengiriman</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Buyer Info -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Pembeli</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="avatar-lg bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center">
                                    <span class="fs-3 text-primary">{{ substr($order->buyer->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $order->buyer->name }}</h5>
                                <p class="text-muted mb-0">{{ $order->buyer->email }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-2">
                            <small class="text-muted">Telepon</small>
                            <p class="mb-0">{{ $order->buyer->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aksi</h5>
                    </div>
                    <div class="card-body">
                        @if($order->status == 'paid')
                            <div class="alert alert-info">
                                <i data-feather="info" class="icon-xs me-1"></i>
                                Pesanan sudah dibayar. Silakan proses dan kirim barang.
                            </div>
                            <form action="{{ route('seller.orders.process', $order->uuid) }}" method="POST" class="mb-2">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary w-100">
                                    <i data-feather="package" class="icon-xs me-1"></i> Proses Pesanan
                                </button>
                            </form>
                        @elseif($order->status == 'processed' && $order->payment_method === 'cod')
                            <div class="alert alert-info">
                                <i data-feather="info" class="icon-xs me-1"></i>
                                <strong>Pesanan COD.</strong> Chat pembeli untuk ketemuan. Menunggu konfirmasi dari pembeli setelah cek barang.
                            </div>
                        @elseif($order->status == 'processed')
                            <div class="alert alert-warning">
                                <i data-feather="alert-circle" class="icon-xs me-1"></i>
                                Pesanan sedang diproses. Silakan kirim barang dan masukkan nomor resi.
                            </div>
                            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#shipModal">
                                <i data-feather="truck" class="icon-xs me-1"></i> Kirim Pesanan
                            </button>
                        @elseif($order->status == 'shipped' && $order->payment_method === 'cod' && $order->buyer_confirmed_at)
                            <div class="alert alert-success mb-3">
                                <i data-feather="check-circle" class="icon-xs me-1"></i>
                                <strong>Pembeli sudah konfirmasi barang diterima!</strong> Silakan finalisasi pesanan untuk mencairkan dana.
                            </div>
                            <form action="{{ route('seller.orders.finalize-cod', $order->uuid) }}" method="POST" 
                                onsubmit="return confirm('Finalisasi pesanan COD ini? Dana akan siap dicairkan.')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100 mb-2">
                                    <i data-feather="check-circle" class="icon-xs me-1"></i> Finalisasi Pesanan COD
                                </button>
                            </form>
                        @elseif($order->status == 'shipped')
                            <div class="alert alert-primary">
                                <i data-feather="truck" class="icon-xs me-1"></i>
                                Pesanan sudah dikirim. Menunggu konfirmasi dari pembeli.
                            </div>
                            <button type="button" class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#updateTrackingModal">
                                <i data-feather="edit" class="icon-xs me-1"></i> Update Nomor Resi
                            </button>
                        @elseif($order->status == 'completed')
                            @if($order->payment_method === 'cod' && !$order->buyer_confirmed_at)
                            <div class="alert alert-warning">
                                <i data-feather="clock" class="icon-xs me-1"></i>
                                <strong>Pesanan diselesaikan otomatis oleh sistem.</strong><br>
                                Pembeli tidak mengkonfirmasi dalam 3 hari, sehingga pesanan otomatis selesai dan dana telah dicairkan.
                            </div>
                            @else
                            <div class="alert alert-success">
                                <i data-feather="check-circle" class="icon-xs me-1"></i>
                                Pesanan telah selesai.
                            </div>
                            @endif
                        @elseif($order->status == 'cancelled')
                            <div class="alert alert-danger">
                                <i data-feather="x-circle" class="icon-xs me-1"></i>
                                Pesanan dibatalkan.
                            </div>
                        @elseif($order->status == 'pending')
                            <div class="alert alert-warning">
                                <i data-feather="clock" class="icon-xs me-1"></i>
                                Menunggu pembayaran dari pembeli.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ship Modal -->
@if($order->status == 'processed' || $order->status == 'paid')
<div class="modal fade" id="shipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kirim Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('seller.orders.ship', $order->uuid) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Kurir <span class="text-danger">*</span></label>
                        <select name="courier" class="form-select @error('courier') is-invalid @enderror" required>
                            <option value="">-- Pilih Kurir --</option>
                            @foreach($couriers as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('courier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Resi <span class="text-danger">*</span></label>
                        <input type="text" name="tracking_number" class="form-control @error('tracking_number') is-invalid @enderror" 
                               placeholder="Masukkan nomor resi" required>
                        @error('tracking_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Masukkan nomor resi pengiriman dari kurir</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i data-feather="truck" class="icon-xs me-1"></i> Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Update Tracking Modal -->
@if($order->status == 'shipped')
<div class="modal fade" id="updateTrackingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Nomor Resi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('seller.orders.update-tracking', $order->uuid) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kurir <span class="text-danger">*</span></label>
                        <select name="courier" class="form-select @error('courier') is-invalid @enderror" required>
                            <option value="">-- Pilih Kurir --</option>
                            @foreach($couriers as $key => $value)
                                <option value="{{ $key }}" {{ $order->shipment && $order->shipment->courier == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('courier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Resi <span class="text-danger">*</span></label>
                        <input type="text" name="tracking_number" class="form-control @error('tracking_number') is-invalid @enderror" 
                               value="{{ $order->shipment->tracking_number ?? '' }}" placeholder="Masukkan nomor resi" required>
                        @error('tracking_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">
                        <i data-feather="save" class="icon-xs me-1"></i> Update Resi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@include('admin.layout.footer')
