@include('home.layout.head')
@include('home.layout.header')

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
                    <span class="badge bg-warning text-dark">
                        {{ strtoupper($order->status) }}
                    </span>
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
