@auth
@php
    $addresses = \DB::table('user_addresses')
        ->where('user_id', auth()->id())
        ->orderByDesc('is_default')
        ->get();
@endphp
@endauth

<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="deliveryOptions" tabindex="-1"
    aria-labelledby="deliveryOptionsLabel" style="width: 500px">

    <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
        <div class="d-flex align-items-center justify-content-between w-100 mb-4">
            <h4 class="offcanvas-title" id="deliveryOptionsLabel">Alamat Pengiriman</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
    </div>

    <div class="offcanvas-body py-2">

        @guest
            <div class="alert alert-warning">
                Silakan login terlebih dahulu untuk memilih alamat pengiriman.
            </div>
        @endguest

        @auth
            @forelse ($addresses as $address)
                <div class="form-check border-bottom py-3">
                    <input type="radio"
                           class="form-check-input"
                           name="address_id"
                           value="{{ $address->id }}"
                           {{ $address->is_default ? 'checked' : '' }}>

                    <label class="form-check-label w-100">
                        <strong>{{ $address->recipient_name }}</strong><br>
                        {{ $address->phone }}<br>
                        {{ $address->address_detail }},
                        {{ $address->district }},
                        {{ $address->city }},
                        {{ $address->province }} {{ $address->postal_code }}

                        @if ($address->is_default)
                            <span class="badge bg-success ms-2">Utama</span>
                        @endif
                    </label>
                </div>
            @empty
                <div class="alert alert-info">
                    Anda belum memiliki alamat.
                </div>
            @endforelse

            <button type="button"
                    class="btn btn-outline-primary w-100 mt-4"
                    data-bs-toggle="modal"
                    data-bs-target="#addAddressModal">
                + Tambah Alamat Baru
            </button>
        @endauth

    </div>

    <div class="offcanvas-footer p-3">
        @auth
            <button type="button" class="btn btn-primary w-100 rounded-pill">
                Konfirmasi Alamat
            </button>
        @endauth
    </div>
</div>
@include('home.checkout.modal.addAddress')
