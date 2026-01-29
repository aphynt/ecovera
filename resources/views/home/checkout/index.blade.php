@include('home.layout.head')
@include('home.layout.header')
@include('home.layout.categories')

@php
    $defaultAddress = \DB::table('user_addresses')
        ->where('user_id', auth()->id())
        ->where('is_default', true)
        ->first();
@endphp

<main class="content-wrapper">
    <div class="container py-5">
        <div class="row">

            <div class="col-lg-8">

                <h1 class="h3 mb-4">Keranjang Belanja</h1>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="border-bottom">
                            <tr class="text-muted fs-sm">
                                <th>Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Total</th>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <a href="{{ url('/') }}" class="btn btn-link px-0 mt-3">
                    ← Lanjutkan belanja
                </a>

            </div>

            <aside class="col-lg-4">

                <div class="position-sticky" style="top: 100px">

                    <div class="bg-body-tertiary rounded-4 p-4 mb-4">
                        <h6 class="mb-3">Alamat Pengiriman</h6>

                        @if ($defaultAddress)
                            <div class="fs-sm">
                                <div class="fw-semibold mb-1">
                                    {{ $defaultAddress->recipient_name }}
                                </div>
                                <div class="text-muted mb-1">
                                    {{ $defaultAddress->phone }}
                                </div>
                                <div class="text-muted">
                                    {{ $defaultAddress->address_detail }}<br>
                                    {{ $defaultAddress->district }},
                                    {{ $defaultAddress->city }},
                                    {{ $defaultAddress->province }}<br>
                                    {{ $defaultAddress->postal_code }}
                                </div>
                            </div>

                            <a href="{{ route('profile.address') }}"
                               class="d-inline-block mt-2 fs-sm text-decoration-underline">
                                Ubah alamat
                            </a>
                        @else
                            <div class="alert alert-warning fs-sm mb-0">
                                Alamat pengiriman belum diatur
                            </div>

                            <button class="btn btn-sm btn-primary mt-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addAddressModal">
                                Tambah alamat
                            </button>

                        @endif
                    </div>

                    <div class="bg-body-tertiary rounded-4 p-4">

                        <h5 class="mb-4">Ringkasan Pesanan</h5>

                        <ul class="list-unstyled fs-sm mb-4">
                            <li class="d-flex justify-content-between mb-2">
                                Subtotal:
                                <span class="fw-medium">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                Ongkir:
                                <span class="fw-medium">
                                    Dihitung saat checkout
                                </span>
                            </li>
                        </ul>

                        <div class="border-top pt-3 mb-4">
                            <div class="d-flex justify-content-between">
                                <span class="fs-sm">Total:</span>
                                <span class="h5 mb-0">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('admin.checkout.process') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Metode Pembayaran</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="payment_method" value="midtrans" checked>
                                    <label class="form-check-label">
                                        Transfer / E-Wallet / Virtual Account
                                    </label>
                                </div>

                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio"
                                        name="payment_method" value="cod">
                                    <label class="form-check-label">
                                        COD (Bayar di Tempat)
                                    </label>
                                </div>
                            </div>

                            <button type="submit"
                                    class="btn btn-lg btn-primary w-100 rounded-pill">
                                Lanjutkan ke Pembayaran
                            </button>
                        </form>


                    </div>
                </div>

            </aside>

        </div>
    </div>
    @include('home.checkout.modal.addAddress')
</main>

@include('home.layout.footer')
