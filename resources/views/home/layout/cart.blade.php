@php
    $cartItems = collect();
    $subtotal = 0;

    if (Auth::check()) {
        $cartItems = DB::table('cart_items')
            ->join('carts', 'carts.id', '=', 'cart_items.cart_id')
            ->join('products', 'products.id', '=', 'cart_items.product_id')
            ->leftJoin('product_images', function ($join) {
                $join->on('product_images.product_id', '=', 'products.id')
                     ->where('product_images.is_primary', 1);
            })
            ->where('carts.user_id', Auth::id())
            ->select(
                'cart_items.id as cart_item_id',
                'cart_items.quantity',
                'cart_items.price',
                'products.name',
                'products.weight',
                'products.uuid',
                'product_images.image_url'
            )
            ->get();

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
    }
@endphp
@if(Auth::check())
<div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1"
    aria-labelledby="shoppingCartLabel" style="width: 500px">

    <!-- Header -->
    <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
        <div class="d-flex align-items-center justify-content-between w-100 mb-3">
            <h4 class="offcanvas-title" id="shoppingCartLabel">Keranjang Belanja</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        @if($cartItems->isEmpty())
            <div class="alert alert-secondary fs-sm border-0 rounded-4 mb-0 w-100">
                Keranjang masih kosong
            </div>
        @endif
    </div>

    <!-- Items -->
    <div class="offcanvas-body d-flex flex-column gap-4 pt-2">

        @foreach ($cartItems as $item)
        <div class="d-flex align-items-center">
            <a class="flex-shrink-0" href="#">
                <img src="{{ asset('storage/'.$item->image_url) }}"
                     width="110"
                     class="rounded"
                     alt="{{ $item->name }}">
            </a>

            <div class="w-100 ps-3">
                <h5 class="fs-sm fw-medium lh-base mb-1">
                    {{ $item->name }}
                </h5>

                <div class="fs-xs text-muted mb-1">
                    @if ($item->weight >= 1000)
                        {{ number_format($item->weight / 1000, 2, ',', '.') }} kg × {{ $item->quantity }}
                    @else
                        {{ $item->weight }} gram × {{ $item->quantity }}
                    @endif
                </div>

                <div class="h6 mb-2">
                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                </div>

                <div class="d-flex justify-content-end">
                    <form action="{{ route('cart.remove', $item->cart_item_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger rounded-pill">
                            <i class="ci-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <!-- Footer -->
    @if($cartItems->isNotEmpty())
    <div class="offcanvas-header flex-column align-items-start">
        <div class="d-flex align-items-center justify-content-between w-100 mb-3">
            <span class="text-light-emphasis">Subtotal</span>
            <span class="h6 mb-0">
                Rp {{ number_format($subtotal, 0, ',', '.') }}
            </span>
        </div>

        <div class="d-flex w-100 gap-3">
            <a class="btn btn-lg btn-secondary w-100 rounded-pill" href="{{ route('cart') }}">
                Lihat Keranjang
            </a>
            <a class="btn btn-lg btn-primary w-100 rounded-pill" href="{{ route('checkout') }}">
                Checkout
            </a>
        </div>
    </div>
    @endif
</div>
@endif

