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
                'products.id as product_id',
                'products.name',
                'products.weight',
                'products.stock',
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
                        {{ number_format($item->weight / 1000, 2, ',', '.') }} kg
                    @else
                        {{ $item->weight }} gram
                    @endif
                </div>

                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="d-inline-flex align-items-center border rounded-pill">
                        <button 
                            type="button" 
                            class="btn btn-sm btn-icon btn-decrement-sidebar border-0" 
                            data-cart-item-id="{{ $item->cart_item_id }}"
                            data-current-quantity="{{ $item->quantity }}"
                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                            <i class="ci-minus"></i>
                        </button>
                        <span class="px-2 quantity-text-{{ $item->cart_item_id }}" style="min-width: 30px; text-align: center;">{{ $item->quantity }}</span>
                        <button 
                            type="button" 
                            class="btn btn-sm btn-icon btn-increment-sidebar border-0" 
                            data-cart-item-id="{{ $item->cart_item_id }}"
                            data-current-quantity="{{ $item->quantity }}"
                            data-max-stock="{{ $item->stock }}"
                            {{ $item->quantity >= $item->stock ? 'disabled' : '' }}>
                            <i class="ci-plus"></i>
                        </button>
                    </div>
                    @if($item->stock < 10)
                        <span class="badge bg-warning text-dark fs-xs">Stok: {{ $item->stock }}</span>
                    @endif
                </div>

                <div class="h6 mb-2 subtotal-sidebar-{{ $item->cart_item_id }}">
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
            <span class="h6 mb-0 sidebar-total">
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

<script>
// Use event delegation for dynamically loaded cart items
document.addEventListener('click', function(e) {
    // Check if CSRF token exists
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('CSRF token not found');
        alert('Error: CSRF token tidak ditemukan. Silakan refresh halaman.');
        return;
    }

    // Handle increment button
    if (e.target.closest('.btn-increment-sidebar')) {
        e.preventDefault();
        const button = e.target.closest('.btn-increment-sidebar');
        const cartItemId = button.getAttribute('data-cart-item-id');
        const currentQuantity = parseInt(button.getAttribute('data-current-quantity'));
        const maxStock = parseInt(button.getAttribute('data-max-stock'));

        console.log('Increment clicked:', { cartItemId, currentQuantity, maxStock });

        if (currentQuantity < maxStock && !button.disabled) {
            updateQuantitySidebar(cartItemId, currentQuantity + 1, csrfToken);
        } else {
            console.log('Cannot increment: reached max stock or button disabled');
        }
        return;
    }

    // Handle decrement button
    if (e.target.closest('.btn-decrement-sidebar')) {
        e.preventDefault();
        const button = e.target.closest('.btn-decrement-sidebar');
        const cartItemId = button.getAttribute('data-cart-item-id');
        const currentQuantity = parseInt(button.getAttribute('data-current-quantity'));

        console.log('Decrement clicked:', { cartItemId, currentQuantity });

        if (currentQuantity > 1 && !button.disabled) {
            updateQuantitySidebar(cartItemId, currentQuantity - 1, csrfToken);
        } else {
            console.log('Cannot decrement: already at minimum or button disabled');
        }
        return;
    }
});

function updateQuantitySidebar(cartItemId, newQuantity, csrfToken) {
    console.log('Updating quantity:', { cartItemId, newQuantity });
    
    // Show loading state
    const decrementBtn = document.querySelector(`.btn-decrement-sidebar[data-cart-item-id="${cartItemId}"]`);
    const incrementBtn = document.querySelector(`.btn-increment-sidebar[data-cart-item-id="${cartItemId}"]`);
    
    if (decrementBtn) decrementBtn.disabled = true;
    if (incrementBtn) incrementBtn.disabled = true;

    const url = `/cart/item/${cartItemId}/update-quantity`;
    console.log('Making PATCH request to:', url);

    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            // Update subtotal for this item
            const subtotalEl = document.querySelector(`.subtotal-sidebar-${cartItemId}`);
            if (subtotalEl) {
                subtotalEl.textContent = data.formatted_subtotal;
            }
            
            // Update quantity text
            const quantityEl = document.querySelector(`.quantity-text-${cartItemId}`);
            if (quantityEl) {
                quantityEl.textContent = newQuantity;
            }
            
            // Update total
            const totalEl = document.querySelector('.sidebar-total');
            if (totalEl) {
                totalEl.textContent = data.formatted_total;
            }

            // Update button states
            const maxStock = parseInt(incrementBtn.getAttribute('data-max-stock'));

            if (decrementBtn) {
                decrementBtn.disabled = newQuantity <= 1;
                decrementBtn.setAttribute('data-current-quantity', newQuantity);
            }
            
            if (incrementBtn) {
                incrementBtn.disabled = newQuantity >= maxStock;
                incrementBtn.setAttribute('data-current-quantity', newQuantity);
            }

            console.log('Update successful');
        } else {
            console.error('Update failed:', data.message);
            alert(data.message || 'Terjadi kesalahan saat memperbarui jumlah.');
            // Re-enable buttons on error
            if (decrementBtn) decrementBtn.disabled = false;
            if (incrementBtn) incrementBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Terjadi kesalahan saat memperbarui jumlah. Silakan coba lagi.');
        // Re-enable buttons on error
        if (decrementBtn) decrementBtn.disabled = false;
        if (incrementBtn) incrementBtn.disabled = false;
    });
}
</script>
@endif

