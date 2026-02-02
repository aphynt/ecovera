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
        max-width: 70%;
        padding: 10px 15px;
        border-radius: 20px;
        margin-bottom: 15px;
        position: relative;
    }

    .message-sent {
        align-self: flex-end;
        background-color: #0d6efd;
        /* Primary color */
        color: white;
        border-bottom-right-radius: 2px;
    }

    .message-received {
        align-self: flex-start;
        background-color: #e9ecef;
        /* Light gray */
        color: #212529;
        border-bottom-left-radius: 2px;
    }

    .message-time {
        font-size: 0.75rem;
        opacity: 0.8;
        display: block;
        margin-top: 5px;
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

                        {{-- Chat Area --}}
                        <div class="chat-container mb-3" id="chatContainer">
                            @foreach($messages as $msg)
                                <div
                                    class="message-bubble {{ $msg->sender_id == Auth::id() ? 'message-sent' : 'message-received' }}">
                                    <div>{{ $msg->message }}</div>
                                    <span class="message-time {{ $msg->sender_id == Auth::id() ? 'text-end' : '' }}">
                                        {{ $msg->created_at->format('H:i') }}
                                        @if($msg->sender_id == Auth::id())
                                            <i class="ci-check {{ $msg->is_read ? 'text-info' : '' }}"></i>
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Input Form --}}
                        <form action="{{ route('chat.store', $otherUser->id) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="message" class="form-control"
                                    value="{{ isset($product) && $product ? 'Halo, apakah stok ' . $product->name . ' masih ada? ' . route('product.detail', $product->uuid) : '' }}"
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

<script>
    // Auto scroll to bottom
    document.addEventListener('DOMContentLoaded', function () {
        const chatContainer = document.getElementById('chatContainer');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    });
</script>

@include('home.layout.footer')