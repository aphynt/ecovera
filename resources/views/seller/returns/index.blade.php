@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Manajemen Pengembalian Barang - Seller</h4>
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
                                    <i data-feather="inbox" class="avatar-title fs-24 text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $stats['total'] }}</h5>
                                <p class="text-muted mb-0 fs-13">Total Pengajuan</p>
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
                                    <i data-feather="clock" class="avatar-title fs-24 text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $stats['requested'] }}</h5>
                                <p class="text-muted mb-0 fs-13">Menunggu</p>
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
                                <h5 class="mb-1">{{ $stats['approved'] }}</h5>
                                <p class="text-muted mb-0 fs-13">Disetujui</p>
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
                                <h5 class="mb-1">{{ $stats['rejected'] }}</h5>
                                <p class="text-muted mb-0 fs-13">Ditolak</p>
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
                                    <i data-feather="truck" class="avatar-title fs-24 text-info"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $stats['item_sent_back'] }}</h5>
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
                                <div class="avatar-sm bg-secondary-subtle rounded">
                                    <i data-feather="refresh-cw" class="avatar-title fs-24 text-secondary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $stats['refunded'] }}</h5>
                                <p class="text-muted mb-0 fs-13">Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter Pengajuan</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('seller.returns.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="requested" {{ request('status') == 'requested' ? 'selected' : '' }}>Diajukan</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                <option value="item_sent_back" {{ request('status') == 'item_sent_back' ? 'selected' : '' }}>Barang Dikirim</option>
                                <option value="item_received" {{ request('status') == 'item_received' ? 'selected' : '' }}>Barang Diterima</option>
                                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Dana Dikembalikan</option>
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
                            <label class="form-label">Pencarian</label>
                            <input type="text" name="search" class="form-control" placeholder="Kode order / Nama pembeli" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="filter" class="icon-xs me-1"></i> Filter
                            </button>
                            <a href="{{ route('seller.returns.index') }}" class="btn btn-secondary">
                                <i data-feather="refresh-cw" class="icon-xs me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Returns Table -->
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Pengajuan Pengembalian</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Order</th>
                                <th>Pembeli</th>
                                <th>Produk</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($returns as $i => $return)
                            <tr>
                                <td>{{ $returns->firstItem() + $i }}</td>
                                <td>
                                    <span class="text-primary fw-semibold">
                                        {{ $return->order->order_code ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm bg-light rounded-circle">
                                                <span class="avatar-title text-dark fs-14">
                                                    {{ substr($return->buyer->name ?? 'U', 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0 fs-14">{{ $return->buyer->name ?? '-' }}</h6>
                                            <small class="text-muted">{{ $return->buyer->email ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($return->items->count() > 0)
                                        <span class="badge bg-light text-dark">
                                            {{ $return->items->first()->product->name ?? 'Produk' }}
                                            @if($return->items->count() > 1)
                                                +{{ $return->items->count() - 1 }}
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $return->reason }}">
                                        {{ Str::limit($return->reason, 30) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $return->status_badge_color }}">
                                        {{ $return->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ $return->created_at->format('d M Y H:i') }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('seller.returns.show', $return->uuid) }}" class="btn btn-sm btn-primary">
                                        <i data-feather="eye" class="icon-xs"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i data-feather="inbox" class="icon-lg mb-2"></i>
                                        <p class="mb-0">Belum ada pengajuan pengembalian.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $returns->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.layout.footer')