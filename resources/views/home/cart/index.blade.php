@include('home.layout.head')
@include('home.layout.header')
@include('home.layout.categories')

<main class="content-wrapper">
    <div class="container py-5">
        <h1 class="h3 mb-4">Keranjang Belanja</h1>

        @if($items->isEmpty())
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="ci-shopping-cart" style="font-size: 4rem; color: #dee2e6;"></i>
                </div>
                <h5 class="text-muted mb-3">Keranjang Anda kosong</h5>
                <p class="text-muted mb-4">Yuk, tambahkan produk ke keranjang Anda!</p>
                <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="ci-shopping-bag me-2"></i>Mulai Belanja
                </a>
            </div>
        @else
            <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="border-bottom">
                                <tr class="text-muted fs-sm">
                                    <th>Produk</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    @php
                                        $primaryImage = \DB::table('product_images')
                                            ->where('product_id', $item->id)
                                            ->where('is_primary', true)
                                            ->value('image_url');
                                    @endphp
                                    <tr class="border-bottom">
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ asset('storage/'.$primaryImage) }}" width="72" class="rounded">
                                                <div>
                                                    <div class="fw-semibold">{{ $item->name }}</div>
                                                    <div class="fs-xs text-muted">
                                                        @if ($item->weight >= 1000)
                                                            {{ number_format($item->weight / 1000, 2, ',', '.') }} kg
                                                        @else
                                                            {{ $item->weight }} gram
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="text-end fw-semibold">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ route('cart.remove', $item->cart_item_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus produk ini dari keranjang?')">
                                                    <i class="ci-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ url('/') }}" class="btn btn-link px-0 mt-3">
                        ← Lanjutkan belanja
                    </a>
                </div>

                <div class="col-lg-4">
                    <div class="position-sticky" style="top: 100px">
                        <div class="bg-body-tertiary rounded-4 p-4">
                            <h5 class="mb-4">Ringkasan Pesanan</h5>

                            <ul class="list-unstyled fs-sm mb-4">
                                <li class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span class="fw-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </li>
                                <li class="d-flex justify-content-between mb-2">
                                    <span>Ongkir:</span>
                                    <span class="fw-medium text-muted">Dihitung saat checkout</span>
                                </li>
                            </ul>

                            <div class="border-top pt-3 mb-4">
                                <div class="d-flex justify-content-between">
                                    <span class="fs-sm">Total:</span>
                                    <span class="h5 mb-0">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <a href="{{ route('checkout') }}" class="btn btn-lg btn-primary w-100 rounded-pill">
                                Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>

@include('home.layout.footer')
