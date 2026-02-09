@include('home.layout.head')
@include('home.layout.header')

<style>
    .chat-container {
        height: 500px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
    }

    .message-bubble {
        max-width: 75%;
        padding: 12px 16px;
        border-radius: 18px;
        margin-bottom: 15px;
        position: relative;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        line-height: 1.4;
    }

    .message-sent {
        align-self: flex-end;
        background: linear-gradient(135deg, #0d6efd 0%, #0052cc 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .message-received {
        align-self: flex-start;
        background-color: #ffffff;
        color: #212529;
        border: 1px solid #e9ecef;
        border-bottom-left-radius: 4px;
    }

    .message-time {
        font-size: 0.7rem;
        opacity: 0.8;
        display: block;
        margin-top: 5px;
    }

    /* Custom scrollbar */
    .chat-container::-webkit-scrollbar {
        width: 6px;
    }

    .chat-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .chat-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .chat-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Message hover effects */
    .message-bubble:hover {
        transform: translateY(-1px);
        transition: transform 0.2s ease;
    }

    /* Product card hover effects */
    .border.rounded.p-2.bg-white:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    /* Product card inside message bubble */
    .message-bubble a .border.rounded {
        transition: all 0.2s ease;
    }

    .message-bubble a .border.rounded:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        transform: scale(1.02);
    }

    .message-sent a .border.rounded:hover {
        box-shadow: 0 2px 8px rgba(255,255,255,0.3);
    }

    /* Order card styles */
    .order-card {
        transition: all 0.2s ease;
    }

    a:has(.order-card):hover .order-card {
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transform: translateY(-2px);
    }

    .message-sent a:has(.order-card):hover .order-card {
        box-shadow: 0 4px 12px rgba(255,255,255,0.3);
    }

    .products-grid {
        max-height: 200px;
        overflow-y: auto;
    }

    .products-grid::-webkit-scrollbar {
        width: 4px;
    }

    .products-grid::-webkit-scrollbar-track {
        background: rgba(0,0,0,0.05);
        border-radius: 4px;
    }

    .products-grid::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.2);
        border-radius: 4px;
    }
</style>

<main class="content-wrapper">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white d-flex align-items-center justify-content-between p-3">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('chat.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                                <i class="ci-arrow-left"></i> Kembali
                            </a>
                            <h5 class="mb-0">{{ $otherUser->name }}</h5>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- Product Context (If initiated from product page) --}}
                        @if(isset($product) && $product)
                            <div class="alert alert-light border d-flex align-items-center mb-3 p-2" role="alert">
                                <div class="flex-shrink-0" style="width: 50px; height: 50px;">
                                    <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_url) : asset('logo/logo.png') }}"
                                        alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover rounded">
                                </div>
                                <div class="ms-3 flex-grow-1 overflow-hidden">
                                    <h6 class="mb-0 text-truncate">{{ $product->name }}</h6>
                                    <div class="small text-primary fw-medium">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Recent Order Context (If coming from COD order) --}}
                        @if(isset($recentOrder) && $recentOrder && session('cod_success'))
                            <div class="alert alert-success border-0 mb-3" role="alert">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ci-package text-success me-2"></i>
                                    <h6 class="mb-0 text-success">Pesanan Baru - COD</h6>
                                </div>
                                <div class="row g-2">
                                    @foreach($recentOrder as $item)
                                        <div class="col-12">
                                            <div class="d-flex align-items-center bg-white rounded p-2 border">
                                                <div class="flex-shrink-0" style="width: 40px; height: 40px;">
                                                    <img src="{{ $item->image_url ? asset('storage/' . $item->image_url) : asset('logo/logo.png') }}"
                                                         alt="{{ $item->product_name }}" class="w-100 h-100 object-fit-cover rounded">
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <div class="small fw-medium text-truncate">{{ $item->product_name }}</div>
                                                    <div class="small text-muted">{{ $item->quantity }}x • Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="small text-success mt-2">
                                    <i class="ci-info-circle me-1"></i>
                                    Pesan otomatis telah dikirim dengan detail pesanan
                                </div>
                            </div>
                        @endif

                        {{-- Chat Area --}}
                        <div class="chat-container mb-3" id="chatContainer">
                            @foreach($messages as $msg)
                                <div
                                    class="message-bubble {{ $msg->sender_id == Auth::id() ? 'message-sent' : 'message-received' }}">
                                    
                                    {{-- Product Card in Message (if has product) --}}
                                    @if($msg->product)
                                        <a href="{{ route('product.detail', $msg->product->uuid) }}" 
                                           class="text-decoration-none d-block mb-2" 
                                           target="_blank"
                                           onclick="event.stopPropagation();">
                                            <div class="border rounded p-2" 
                                                 style="background-color: {{ $msg->sender_id == Auth::id() ? 'rgba(255,255,255,0.2)' : '#f8f9fa' }}; max-width: 250px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-2" style="width: 50px; height: 50px;">
                                                        <img src="{{ $msg->product->primaryImage ? asset('storage/' . $msg->product->primaryImage->image_url) : asset('logo/logo.png') }}"
                                                            alt="{{ $msg->product->name }}" 
                                                            class="w-100 h-100 object-fit-cover rounded border">
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <div class="small fw-medium text-truncate {{ $msg->sender_id == Auth::id() ? 'text-white' : 'text-dark' }}">
                                                            {{ $msg->product->name }}
                                                        </div>
                                                        <div class="small fw-bold {{ $msg->sender_id == Auth::id() ? 'text-white opacity-90' : 'text-primary' }}">
                                                            Rp {{ number_format($msg->product->price, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                    <div class="ms-1 {{ $msg->sender_id == Auth::id() ? 'text-white' : 'text-muted' }}">
                                                        <i class="ci-arrow-right" style="font-size: 0.8rem;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endif

                                    {{-- Order Card in Message (if has order) --}}
                                    @if($msg->order)
                                        @php
                                            $order = $msg->order;
                                            $statusColors = [
                                                'pending' => ['bg' => '#ffc107', 'text' => '#000', 'label' => 'Menunggu Pembayaran'],
                                                'processed' => ['bg' => '#17a2b8', 'text' => '#fff', 'label' => 'Diproses'],
                                                'paid' => ['bg' => '#28a745', 'text' => '#fff', 'label' => 'Sudah Dibayar'],
                                                'shipped' => ['bg' => '#007bff', 'text' => '#fff', 'label' => 'Dikirim'],
                                                'delivered' => ['bg' => '#28a745', 'text' => '#fff', 'label' => 'Selesai'],
                                                'cancelled' => ['bg' => '#dc3545', 'text' => '#fff', 'label' => 'Dibatalkan'],
                                            ];
                                            $statusInfo = $statusColors[$order->status] ?? ['bg' => '#6c757d', 'text' => '#fff', 'label' => ucfirst($order->status)];
                                            
                                            // Determine route based on user role
                                            $isBuyer = Auth::id() == $order->buyer_id;
                                            $orderRoute = $isBuyer 
                                                ? route('buyer.orders.detail', $order->uuid)
                                                : route('seller.orders.show', $order->uuid);
                                        @endphp
                                        
                                        <a href="{{ $orderRoute }}" 
                                           class="text-decoration-none d-block mb-2" 
                                           target="_blank"
                                           onclick="event.stopPropagation();">
                                        <div class="order-card border rounded p-2" 
                                             style="background-color: {{ $msg->sender_id == Auth::id() ? 'rgba(255,255,255,0.15)' : '#ffffff' }}; max-width: 320px; cursor: pointer;">
                                            
                                            {{-- Order Header --}}
                                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                                <div class="d-flex align-items-center">
                                                    <i class="ci-package {{ $msg->sender_id == Auth::id() ? 'text-white' : 'text-primary' }} me-2"></i>
                                                    <span class="small fw-bold {{ $msg->sender_id == Auth::id() ? 'text-white' : 'text-dark' }}">
                                                        {{ $order->order_code }}
                                                    </span>
                                                </div>
                                                <span class="badge rounded-pill" style="background-color: {{ $statusInfo['bg'] }}; color: {{ $statusInfo['text'] }}; font-size: 0.7rem;">
                                                    {{ $statusInfo['label'] }}
                                                </span>
                                            </div>

                                            {{-- Products Grid --}}
                                            <div class="products-grid mb-2">
                                                @foreach($order->orderItems->take(3) as $item)
                                                    <div class="d-flex align-items-center mb-2 p-2 rounded" 
                                                         style="background-color: {{ $msg->sender_id == Auth::id() ? 'rgba(255,255,255,0.1)' : '#f8f9fa' }};">
                                                        <div class="flex-shrink-0 me-2" style="width: 45px; height: 45px;">
                                                            <img src="{{ $item->product->primaryImage ? asset('storage/' . $item->product->primaryImage->image_url) : asset('logo/logo.png') }}"
                                                                alt="{{ $item->product->name }}" 
                                                                class="w-100 h-100 object-fit-cover rounded border">
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <div class="small text-truncate {{ $msg->sender_id == Auth::id() ? 'text-white' : 'text-dark' }}" style="font-size: 0.8rem;">
                                                                {{ $item->product->name }}
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="small {{ $msg->sender_id == Auth::id() ? 'text-white opacity-75' : 'text-muted' }}" style="font-size: 0.75rem;">
                                                                    {{ $item->quantity }}x
                                                                </span>
                                                                <span class="small fw-bold {{ $msg->sender_id == Auth::id() ? 'text-white' : 'text-primary' }}" style="font-size: 0.75rem;">
                                                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                
                                                @if($order->orderItems->count() > 3)
                                                    <div class="text-center small {{ $msg->sender_id == Auth::id() ? 'text-white opacity-75' : 'text-muted' }}" style="font-size: 0.75rem;">
                                                        +{{ $order->orderItems->count() - 3 }} produk lainnya
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Order Summary --}}
                                            <div class="border-top pt-2">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="small {{ $msg->sender_id == Auth::id() ? 'text-white opacity-75' : 'text-muted' }}" style="font-size: 0.75rem;">
                                                        <i class="ci-package me-1"></i>{{ $order->orderItems->count() }} Produk
                                                    </span>
                                                    <span class="small {{ $msg->sender_id == Auth::id() ? 'text-white opacity-75' : 'text-muted' }}" style="font-size: 0.75rem;">
                                                        <i class="ci-time me-1"></i>{{ $order->created_at->format('d/m/Y H:i') }}
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="small fw-medium {{ $msg->sender_id == Auth::id() ? 'text-white' : 'text-dark' }}">
                                                        Total Pesanan
                                                    </span>
                                                    <span class="fw-bold {{ $msg->sender_id == Auth::id() ? 'text-white' : 'text-danger' }}" style="font-size: 1rem;">
                                                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                                <div class="text-center mt-2 pt-2 border-top">
                                                    <small class="small {{ $msg->sender_id == Auth::id() ? 'text-white opacity-75' : 'text-primary' }}" style="font-size: 0.7rem;">
                                                        <i class="ci-arrow-right me-1"></i>Klik untuk lihat detail pesanan
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                    @endif

                                    {{-- Message Text --}}
                                    <div style="white-space: pre-line; word-wrap: break-word;">{!! nl2br(e($msg->message)) !!}</div>
                                    
                                    <span class="message-time {{ $msg->sender_id == Auth::id() ? 'text-end' : '' }}">
                                        {{ $msg->created_at->format('H:i') }}
                                        @if($msg->sender_id == Auth::id())
                                            <i class="ci-check {{ $msg->is_read ? 'text-info' : '' }}"></i>
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Product Card (If asking about specific product) --}}
                        @if(isset($product) && $product)
                            <a href="{{ route('product.detail', $product->uuid) }}" class="text-decoration-none mb-3 d-block" target="_blank">
                                <div class="border rounded p-2 bg-white" style="max-width: 300px; transition: all 0.2s ease;">
                                    <div class="d-flex align-items-center" style="cursor: pointer;">
                                        <div class="flex-shrink-0 me-3" style="width: 60px; height: 60px;">
                                            <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_url) : asset('logo/logo.png') }}"
                                                alt="{{ $product->name }}" 
                                                class="w-100 h-100 object-fit-cover rounded border">
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h6 class="mb-1 text-dark text-truncate" style="font-size: 0.9rem;">{{ $product->name }}</h6>
                                            <div class="text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="ms-2 text-muted">
                                            <i class="ci-arrow-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endif

                        {{-- Input Form --}}
                        <form action="{{ route('chat.store', $otherUser->id) }}" method="POST">
                            @csrf
                            @if(isset($product) && $product)
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @endif
                            <div class="input-group">
                                <input type="text" name="message" class="form-control"
                                    value="{{ isset($product) && $product ? 'Halo, apakah stok produk ini masih ada?' : '' }}"
                                    placeholder="Tulis pesan..." required autofocus>
                                <button class="btn btn-primary" type="submit">
                                    <i class="ci-send me-1"></i> Kirim
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- COD Success Popup Modal -->
@if(session('popup_message'))
<div class="modal fade" id="codSuccessModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i class="ci-check text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <h5 class="modal-title mb-2">Pesanan COD Berhasil! 🎉</h5>
                <p class="text-body-secondary mb-3">{{ session('popup_message') }}</p>
                @if(session('order_code'))
                    <div class="alert alert-light d-inline-block">
                        <small class="text-muted">Kode Pesanan:</small><br>
                        <strong>{{ session('order_code') }}</strong>
                    </div>
                @endif
                <div class="mt-3">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                        <i class="ci-thumbs-up me-1"></i> OK, Terima Kasih!
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    // Auto scroll to bottom
    document.addEventListener('DOMContentLoaded', function () {
        const chatContainer = document.getElementById('chatContainer');
        chatContainer.scrollTop = chatContainer.scrollHeight;
        
        // Show COD success popup if exists
        @if(session('popup_message'))
            const codModal = new bootstrap.Modal(document.getElementById('codSuccessModal'));
            codModal.show();
        @endif
    });
</script>

@include('home.layout.footer')