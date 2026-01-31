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
                            <a href="{{ route('admin.chat.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                                <i class="ci-arrow-left"></i> Kembali
                            </a>
                            <h5 class="mb-0">{{ $otherUser->name }}</h5>
                        </div>
                    </div>

                    <div class="card-body">
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
                        <form action="{{ route('admin.chat.store', $otherUser->id) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="message" class="form-control" placeholder="Tulis pesan..."
                                    required autofocus>
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