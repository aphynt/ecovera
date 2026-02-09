@include('home.layout.head')
@include('home.layout.header')
@include('home.layout.categories')

<main class="content-wrapper">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="h2 mb-4 text-center">Layanan Pengaduan</h1>
                <p class="text-center text-muted mb-5">
                    Sampaikan keluhan, kritik, atau saran Anda kepada kami. Kami menghargai setiap masukan untuk
                    meningkatkan layanan kami.
                </p>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('complaint.store') }}" method="POST">
                            @csrf

                            @auth
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}"
                                        disabled>
                                    <small class="text-muted">Anda login sebagai {{ Auth::user()->name }}</small>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}"
                                        disabled>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Alamat Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endauth

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subjek Pengaduan</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    id="subject" name="subject" value="{{ old('subject') }}" required
                                    placeholder="Contoh: Masalah Pengiriman, Produk Rusak, dll.">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label">Isi Pengaduan</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message"
                                    name="message" rows="5" required
                                    placeholder="Jelaskan detail pengaduan Anda di sini...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Kirim Pengaduan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('home.layout.footer')