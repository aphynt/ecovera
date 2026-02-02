@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Manajemen Pesanan - Seller</h4>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-primary-subtle rounded">
                                    <i data-feather="shopping-bag" class="avatar-title fs-24 text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $stats['total'] }}</h5>
                                <p class="text-muted mb-0 fs-13">Total Pesanan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-warning-subtle rounded">
                                    <i data-feather="credit-card" class="avatar-title fs-24 text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $stats['paid'] }}</h5>
                                <p class="text-muted mb-0 fs-13">Menunggu Proses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-info-subtle rounded">
                                    <i data-feather="package" class="avatar-title fs-24 text-info"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $stats['processed'] }}</h5>
                                <p class="text-muted mb-0 fs-13">Sedang Diproses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-primary-subtle rounded">
                                    <i data-feather="truck" class="avatar-title fs-24 text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $stats['shipped'] }}</h5>
                                <p class="text-muted mb-0 fs-13">Dalam Pengiriman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-success-subtle rounded">
                                    <i data-feather="check-circle" class="avatar-title fs-24 text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $stats['completed'] }}</h5>
                                <p class="text-muted mb-0 fs-13">Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-danger-subtle rounded">
                                    <i data-feather="x-circle" class="avatar-title fs-24 text-danger"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $stats['cancelled'] }}</h5>
                                <p class="text-muted mb-0 fs-13">Dibatalkan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter Pesanan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('seller.orders.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cari</label>
                        <input type="text" name="search" class="form-control" placeholder="Kode pesanan / nama buyer..." value="{{ request('search') }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="filter" class="icon-xs me-1"></i> Filter
                        </button>
                        <a href="{{ route('seller.orders.index') }}" class="btn btn-secondary">
                            <i data-feather="refresh-cw" class="icon-xs me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kode Pesanan</th>
                                <th>Pembeli</th>
                                <th>Total (Anda)</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $order->order_code }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm bg-light rounded-circle">
                                                <span class="avatar-title text-primary">
                                                    {{ substr($order->buyer->name, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0">{{ $order->buyer->name }}</h6>
                                            <small class="text-muted">{{ $order->buyer->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">
                                        Rp {{ number_format($order->seller_total, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
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
                                            'paid' => 'Paid',
                                            'processed' => 'Processed',
                                            'shipped' => 'Shipped',
                                            'completed' => 'Completed',
                                            'cancelled' => 'Cancelled',
                                            'refunded' => 'Refunded',
                                        ];
                                        
                                        // For COD orders, show different text for paid status
                                        if ($order->status === 'paid' && $order->payment_method === 'cod') {
                                            $statusLabels['paid'] = 'COD';
                                        }
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td>
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </td>
                                <td>
                                    <a href="{{ route('seller.orders.show', $order->uuid) }}" class="btn btn-sm btn-info">
                                        <i data-feather="eye" class="icon-xs"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i data-feather="inbox" class="icon-lg mb-2"></i>
                                        <p>Belum ada pesanan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.layout.footer')
