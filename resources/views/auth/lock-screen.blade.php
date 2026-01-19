@include('auth.layout.head')

<h1 class="h2 mt-auto">Selamat datang kembali</h1>
@include('alert')
<!-- Form -->
<form class="needs-validation" action="{{ route('admin.unlock') }}" method="POST">
    @csrf
    <div class="mb-4">
        <div class="password-toggle">
            <input type="password" class="form-control form-control-lg" placeholder="Kata sandi" name="password" required>
            <div class="invalid-tooltip bg-transparent py-0">
                Kata sandi salah!
            </div>
            <label class="password-toggle-button fs-lg" aria-label="Tampilkan/sembunyikan kata sandi">
                <input type="checkbox" class="btn-check">
            </label>
        </div>
    </div>
    <button type="submit" class="btn btn-lg btn-primary w-100">
        Masuk
    </button>
</form>
<div class="d-flex align-items-center justify-content-between mb-4">
        <div class="nav">
            <a class="nav-link animate-underline p-0" href="{{ route('home') }}">
                <span class="animate-target">Kembali ke halaman utama</span>
            </a>
        </div>
    </div>
@include('auth.layout.footer')
