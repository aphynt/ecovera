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
                                            <div class="d-inline-flex align-items-center border rounded-pill">
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-icon btn-decrement border-0" 
                                                    data-cart-item-id="{{ $item->cart_item_id }}"
                                                    data-current-quantity="{{ $item->quantity }}"
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                    <i class="ci-minus"></i>
                                                </button>
                                                <input 
                                                    type="text" 
                                                    class="form-control form-control-sm border-0 text-center quantity-input" 
                                                    value="{{ $item->quantity }}" 
                                                    data-cart-item-id="{{ $item->cart_item_id }}"
                                                    data-max-stock="{{ $item->stock }}"
                                                    style="width: 50px;" 
                                                    readonly>
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-icon btn-increment border-0" 
                                                    data-cart-item-id="{{ $item->cart_item_id }}"
                                                    data-current-quantity="{{ $item->quantity }}"
                                                    data-max-stock="{{ $item->stock }}"
                                                    {{ $item->quantity >= $item->stock ? 'disabled' : '' }}>
                                                    <i class="ci-plus"></i>
                                                </button>
                                            </div>
                                            @if($item->stock < 10)
                                                <div class="text-danger fs-xs mt-1">
                                                    Stok tersisa: {{ $item->stock }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-end fw-semibold subtotal-{{ $item->cart_item_id }}">
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
                                    <span class="fw-medium cart-subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </li>
                                <li class="d-flex justify-content-between mb-2">
                                    <span>Ongkir:</span>
                                    <span class="fw-medium text-muted">Dihitung saat checkout</span>
                                </li>
                            </ul>

                            <div class="border-top pt-3 mb-4">
                                <div class="d-flex justify-content-between">
                                    <span class="fs-sm">Total:</span>
                                    <span class="h5 mb-0 cart-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    if (!csrfToken) {
        console.error('CSRF token not found');
        alert('Error: CSRF token tidak ditemukan. Silakan refresh halaman.');
        return;
    }

    console.log('Cart page loaded, CSRF token found');

    // Function to update quantity
    function updateQuantity(cartItemId, newQuantity) {
        console.log('Updating quantity:', { cartItemId, newQuantity });
        
        const decrementBtn = document.querySelector(`.btn-decrement[data-cart-item-id="${cartItemId}"]`);
        const incrementBtn = document.querySelector(`.btn-increment[data-cart-item-id="${cartItemId}"]`);
        
        // Disable buttons during request
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
                const subtotalEl = document.querySelector(`.subtotal-${cartItemId}`);
                if (subtotalEl) {
                    subtotalEl.textContent = data.formatted_subtotal;
                }
                
                // Update cart totals
                document.querySelectorAll('.cart-subtotal, .cart-total').forEach(el => {
                    el.textContent = data.formatted_total;
                });

                // Update quantity input
                const input = document.querySelector(`input[data-cart-item-id="${cartItemId}"]`);
                if (input) {
                    input.value = newQuantity;
                    const maxStock = parseInt(input.getAttribute('data-max-stock'));

                    // Update button states
                    if (decrementBtn) {
                        decrementBtn.disabled = newQuantity <= 1;
                        decrementBtn.setAttribute('data-current-quantity', newQuantity);
                    }
                    
                    if (incrementBtn) {
                        incrementBtn.disabled = newQuantity >= maxStock;
                        incrementBtn.setAttribute('data-current-quantity', newQuantity);
                    }
                }
                
                console.log('Update successful');
            } else {
                console.error('Update failed:', data.message);
                alert(data.message || 'Terjadi kesalahan saat memperbarui jumlah.');
                // Re-enable buttons
                if (decrementBtn) decrementBtn.disabled = false;
                if (incrementBtn) incrementBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Terjadi kesalahan saat memperbarui jumlah. Silakan coba lagi.');
            // Re-enable buttons
            if (decrementBtn) decrementBtn.disabled = false;
            if (incrementBtn) incrementBtn.disabled = false;
        });
    }

    // Handle increment buttons
    document.querySelectorAll('.btn-increment').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const cartItemId = this.getAttribute('data-cart-item-id');
            const currentQuantity = parseInt(this.getAttribute('data-current-quantity'));
            const maxStock = parseInt(this.getAttribute('data-max-stock'));

            console.log('Increment clicked:', { cartItemId, currentQuantity, maxStock });

            if (currentQuantity < maxStock && !this.disabled) {
                updateQuantity(cartItemId, currentQuantity + 1);
            } else {
                console.log('Cannot increment: reached max stock or button disabled');
            }
        });
    });

    // Handle decrement buttons
    document.querySelectorAll('.btn-decrement').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const cartItemId = this.getAttribute('data-cart-item-id');
            const currentQuantity = parseInt(this.getAttribute('data-current-quantity'));

            console.log('Decrement clicked:', { cartItemId, currentQuantity });

            if (currentQuantity > 1 && !this.disabled) {
                updateQuantity(cartItemId, currentQuantity - 1);
            } else {
                console.log('Cannot decrement: already at minimum or button disabled');
            }
        });
    });
    
    console.log('Event listeners attached to', document.querySelectorAll('.btn-increment').length, 'increment buttons and', document.querySelectorAll('.btn-decrement').length, 'decrement buttons');
});
</script>

@include('home.layout.footer')
