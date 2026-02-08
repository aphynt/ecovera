@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Seller Dashboard</h4>
            </div>
        </div>

        <!-- Start Row -->
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div
                                            class="bg-primary-subtle rounded-2 p-1 me-2 border border-dashed border-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-shopping-bag text-primary">
                                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                                            </svg>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Total Orders</p>
                                    </div>
                                    <h3 class="mb-0 fs-24 text-black me-2">{{ number_format($totalOrders) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div
                                            class="bg-secondary-subtle rounded-2 p-1 me-2 border border-dashed border-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-calendar text-secondary">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Monthly Orders</p>
                                    </div>
                                    <h3 class="mb-0 fs-24 text-black me-2">{{ number_format($monthlyOrders) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-info-subtle rounded-2 p-1 me-2 border border-dashed border-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-dollar-sign text-info">
                                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                            </svg>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Revenue</p>
                                    </div>
                                    <h3 class="mb-0 fs-24 text-black me-2">Rp
                                        {{ number_format($totalRevenue, 0, ',', '.') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-first">
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div
                                            class="bg-warning-subtle rounded-2 p-1 me-2 border border-dashed border-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-alert-circle text-warning">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Out of Stock</p>
                                    </div>
                                    <h3 class="mb-0 fs-24 text-black me-2">{{ number_format($outOfStock) }} Items</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Start -->

        <div class="row">
            <!-- Start Products Stock -->
            <div class="col-xl-6">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title text-black mb-0">Latest Products Stock</h5>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-stock mb-0">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productsStock as $product)
                                        <tr>
                                            <td>
                                                @if($product->primaryImage)
                                                    <img src="{{ asset('storage/' . $product->primaryImage->image_url) }}"
                                                        class="avatar rounded-2 bg-primary-subtle p-1"
                                                        style="width: 80px; height: 80px; object-fit: cover;"
                                                        alt="product-image" />
                                                @else
                                                    <div class="avatar rounded-2 bg-primary-subtle d-flex align-items-center justify-content-center"
                                                        style="width: 80px; height: 80px;">
                                                        <i data-feather="box" class="text-primary"
                                                            style="width: 40px; height: 40px;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-14">{{ Str::limit($product->name, 50) }}</p>
                                            </td>
                                            <td class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                @if($product->stock <= 0)
                                                    <span class="badge bg-danger-subtle text-danger fw-semibold fs-13">Out of
                                                        Stock</span>
                                                @elseif($product->stock < 10)
                                                    <span class="badge bg-warning-subtle text-warning fw-semibold fs-13">Low
                                                        Stock</span>
                                                @else
                                                    <span class="badge bg-primary-subtle text-primary fw-semibold fs-13">In
                                                        Stock</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3">Belum ada produk.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Products Stock -->

            <!-- Start Recent Order -->
            <div class="col-xl-6">
                <div class="card overflow-hidden mb-0">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title text-black mb-0">Recent Order</h5>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-traffic mb-0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('seller.orders.show', $order->uuid) }}"
                                                    class="text-primary">#{{ $order->order_code }}</a>
                                            </td>
                                            <td>
                                                <p class="mb-0 fw-medium fs-14">{{ $order->buyer->name ?? 'Guest' }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}-subtle text-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }} fw-semibold">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <p class="mb-0">{{ $order->created_at->format('d M Y') }}</p>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3">Belum ada pesanan terbaru.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Recent Order -->
        </div>

    </div> <!-- container-fluid -->
</div> <!-- content -->

@include('admin.layout.footer')