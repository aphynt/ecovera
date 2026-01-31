@include('home.layout.head')
@include('home.layout.header')

<!-- Page content -->
<main class="content-wrapper">
    
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('buyer.my.orders') }}">Pesanan Saya</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
        </ol>
    </nav>

    <section class="container pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="text-primary mb-3">Rp {{ number_format($data['order']->grand_total, 0, ',', '.') }}</h4>
                            <p class="text-muted mb-0">Order ID: {{ $data['order']->order_code }}</p>
                            <small class="text-muted">Klik untuk melihat detail pesanan dan biaya yang akan dibayar</small>
                        </div>

                        <div class="mb-4">
                            <h6 class="mb-3">Detail Pesanan</h6>
                            @foreach($data['order']->items as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($data['order']->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkir</span>
                                <span>Rp {{ number_format($data['order']->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total</strong>
                                <strong>Rp {{ number_format($data['order']->grand_total, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <button id="pay-button" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="ci-credit-card me-2"></i>PAY
                        </button>

                        <div class="text-center">
                            <p class="text-muted mb-0">All Payment Method</p>
                            <div class="d-flex justify-content-center gap-2 mt-2">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/200px-Logo_dana_blue.svg.png" height="30" alt="DANA">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/200px-Logo_ovo_purple.svg.png" height="30" alt="OVO">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" height="30" alt="GoPay">
                                <span class="text-muted">+2</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('buyer.my.orders') }}" class="btn btn-outline-secondary w-100">
                                <i class="ci-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- Midtrans Snap Script -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $data['snapToken'] }}', {
            onSuccess: function(result){
                window.location.href = '{{ route('buyer.my.orders') }}';
            },
            onPending: function(result){
                window.location.href = '{{ route('buyer.my.orders') }}';
            },
            onError: function(result){
                alert('Pembayaran gagal!');
            },
            onClose: function(){
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    };
</script>

@include('home.layout.footer')
