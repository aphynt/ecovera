@include('home.layout.head')
@include('home.layout.header')

<!-- Page content -->
<main class="content-wrapper">
    
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('buyer.my.orders') }}">Pesanan Saya</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pesanan</li>
        </ol>
    </nav>

    <section class="container pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
        <div class="row">
            
            <!-- Order Details -->
            <div class="col-lg-8 mb-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Detail Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted">Kode Pesanan</small>
                                <p class="mb-0 fw-semibold">{{ $data['order']->order_code }}</p>
                            </div>
                            <div class="col-6 text-end">
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
                                <span class="badge bg-{{ $statusClasses[$data['order']->status] ?? 'secondary' }}">
                                    {{ $statusTexts[$data['order']->status] ?? $data['order']->status }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted">Tanggal Pemesanan</small>
                                <p class="mb-0">{{ $data['order']->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Pembeli</small>
                                <p class="mb-0">{{ $data['order']->buyer->name }}</p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="mb-3">Produk yang Dibeli</h6>
                        @foreach($data['order']->items as $item)
                        <div class="d-flex mb-3 pb-3 border-bottom">
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
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Ringkasan Pesanan</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($data['order']->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkir</span>
                            <span>Rp {{ number_format($data['order']->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong class="text-primary">Rp {{ number_format($data['order']->grand_total, 0, ',', '.') }}</strong>
                        </div>

                        @if($data['order']->status === 'pending')
                        <a href="{{ route('buyer.orders.payment', $data['order']->uuid) }}" class="btn btn-primary w-100 mb-2">
                            <i class="ci-credit-card me-2"></i>Bayar Sekarang
                        </a>
                        @elseif($data['order']->status === 'shipped')
                        <form action="{{ route('buyer.orders.complete', $data['order']->uuid) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100 mb-2">
                                <i class="ci-check me-2"></i>Pesanan Diterima
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('buyer.my.orders') }}" class="btn btn-outline-secondary w-100">
                            <i class="ci-arrow-left me-2"></i>Kembali ke Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

@include('home.layout.footer')
