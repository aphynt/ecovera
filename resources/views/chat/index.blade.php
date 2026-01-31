@include('home.layout.head')
@include('home.layout.header')

<main class="content-wrapper">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Daftar Percakapan</h4>
                    </div>
                    <div class="card-body p-0">
                        @if($users->isEmpty())
                            <div class="p-4 text-center text-muted">
                                <p>Belum ada percakapan.</p>
                            </div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach($users as $user)
                                    <a href="{{ route('admin.chat.show', $user->id) }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center p-3">
                                        {{-- Avatar Placeholder --}}
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px; font-size: 20px;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-0">{{ $user->name }}</h5>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                        <div>
                                            <i class="ci-arrow-right"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('home.layout.footer')