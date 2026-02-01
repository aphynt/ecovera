@include('home.layout.head')
@include('home.layout.header')

<!-- Modal Popup Pesanan Berhasil -->
@if(session('cod_success'))
<div class="modal fade" id="codSuccessModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-body text-center p-5">
                <!-- Success Animation -->
                <div class="mb-4">
                    <div class="success-animation">
                        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                        </svg>
                    </div>
                </div>

                <h3 class="fw-bold text-success mb-2">Pesanan Diterima!</h3>
                <p class="text-muted mb-2">Terima kasih telah berbelanja.</p>
                <div class="alert alert-info border-0 rounded-3 mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="ci-delivery text-primary me-2"></i>
                        <span class="fw-medium">Barang akan segera dikirim</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="ci-money text-success me-2"></i>
                        <span class="fw-medium">Mohon siapkan uang pas</span>
                    </div>
                </div>

                <div class="bg-light rounded-4 p-3 mb-4">
                    <div class="small text-muted mb-1">Nomor Pesanan</div>
                    <div class="fw-bold text-primary fs-5">{{ $order->order_code }}</div>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ url('/') }}" class="btn btn-primary rounded-pill py-2">
                        <i class="ci-shopping-bag me-2"></i>Lanjutkan Belanja
                    </a>
                    <a href="{{ route('buyer.my.orders') }}" class="btn btn-outline-secondary rounded-pill py-2">
                        <i class="ci-list me-2"></i>Lihat Pesanan Saya
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .success-animation {
        width: 100px;
        height: 100px;
        margin: 0 auto;
    }

    .checkmark {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #fff;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #28a745;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }

    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #28a745;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke: #28a745;
        stroke-width: 3;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
        100% { stroke-dashoffset: 0; }
    }

    @keyframes scale {
        0%, 100% { transform: none; }
        50% { transform: scale3d(1.1, 1.1, 1); }
    }

    @keyframes fill {
        100% { box-shadow: inset 0px 0px 0px 50px #28a745; }
    }

    .checkmark__check {
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards, checkColor 0.1s ease-in-out 1s forwards;
    }

    @keyframes checkColor {
        to { stroke: #fff; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('codSuccessModal'));
        modal.show();
    });
</script>
@endif

<main class="content-wrapper">
    <div class="container py-5">

        <h1 class="h4 mb-4">Detail Pesanan</h1>

        <div class="card rounded-4 border-0 shadow-sm mb-4">
            <div class="card-body">

                <div class="mb-2">
                    <strong>No Pesanan:</strong> {{ $order->order_code }}
                </div>

                <div class="mb-2">
                    <strong>Status:</strong>
                    @php
                        $statusLabels = [
                            'pending' => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-warning text-dark'],
                            'paid' => ['label' => 'Sudah Dibayar', 'class' => 'bg-success'],
                            'processing' => ['label' => 'Diproses', 'class' => 'bg-info text-dark'],
                            'shipped' => ['label' => 'Dikirim', 'class' => 'bg-primary'],
                            'delivered' => ['label' => 'Diterima', 'class' => 'bg-success'],
                            'completed' => ['label' => 'Selesai', 'class' => 'bg-success'],
                            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-danger'],
                            'refunded' => ['label' => 'Dikembalikan', 'class' => 'bg-secondary'],
                        ];
                        $statusInfo = $statusLabels[$order->status] ?? ['label' => strtoupper($order->status), 'class' => 'bg-secondary'];
                    @endphp
                    <span class="badge {{ $statusInfo['class'] }}">
                        {{ $statusInfo['label'] }}
                    </span>
                </div>

                <div class="mb-2">
                    <strong>Metode Pembayaran:</strong>
                    @if($order->payment_method === 'cod')
                        <span class="badge bg-dark">COD (Bayar di Tempat)</span>
                    @elseif($order->payment_method === 'midtrans')
                        <span class="badge bg-primary">Transfer / E-Wallet</span>
                    @else
                        <span class="badge bg-secondary">{{ strtoupper($order->payment_method) }}</span>
                    @endif
                </div>

                <div class="mb-2">
                    <strong>Total:</strong>
                    Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                </div>

            </div>
        </div>

        <h5 class="mb-3">Produk</h5>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ url('/') }}" class="btn btn-primary mt-3">
            Kembali ke Beranda
        </a>

    </div>
</main>

@include('home.layout.footer')
