@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Order Details</h4>
            </div>
            <div class="text-end">
                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">Order {{ $order->order_code }}</h5>
                            <div class="flex-shrink-0">
                                @php
                                    $statusClass = match ($order->status) {
                                        'pending' => 'warning',
                                        'paid' => 'info',
                                        'processing' => 'primary',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'completed' => 'success',
                                        'cancelled' => 'danger',
                                        'refunded' => 'secondary',
                                        default => 'light'
                                    };
                                @endphp
                                <span
                                    class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} fs-12">{{ ucfirst($order->status) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <h6 class="text-muted text-uppercase fs-13">Customer Details</h6>
                                <p class="fw-medium mb-0 fs-14">{{ $order->buyer->name ?? 'Guest' }}</p>
                                <p class="text-muted mb-0">{{ $order->buyer->email ?? '-' }}</p>
                                <p class="text-muted mb-0">{{ $order->buyer->phone ?? '-' }}</p>
                            </div>

                            <div class="col-xl-4">
                                <h6 class="text-muted text-uppercase fs-13">Payment Info</h6>
                                <p class="mb-0">Method: <span
                                        class="fw-medium">{{ ucfirst($order->payment_method) }}</span></p>
                                <p class="mb-0">Status: <span
                                        class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}-subtle text-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment_status) }}</span>
                                </p>
                            </div>

                            <div class="col-xl-4">
                                <h6 class="text-muted text-uppercase fs-13">Order Summary</h6>
                                <p class="mb-0">Date: <span
                                        class="fw-medium">{{ $order->created_at->format('d M Y, H:i') }}</span></p>
                                <p class="mb-0">Total: <span class="fw-medium text-primary">Rp
                                        {{ number_format($order->grand_total, 0, ',', '.') }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body border-top border-dashed">
                        <h6 class="text-muted text-uppercase fs-13 mb-3">Order Items</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col" class="text-center">Quantity</th>
                                        <th scope="col" class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if(isset($item->product_image))
                                                        <img src="{{ asset('storage/' . $item->product_image) }}" alt=""
                                                            class="rounded me-2"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                                            style="width: 80px; height: 80px;">
                                                            <i class="mdi mdi-image text-muted" style="font-size: 30px;"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="fs-14 mb-0"><a href="javascript:void(0);"
                                                                class="text-reset">{{ $item->product_name }}</a></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="border-top border-dashed">
                                        <td colspan="3" class="text-end fw-medium">Total Amount</td>
                                        <td class="text-end fw-bold">Rp
                                            {{ number_format($order->grand_total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div> <!-- content -->

@include('admin.layout.footer')