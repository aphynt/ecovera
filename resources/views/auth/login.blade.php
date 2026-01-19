@include('auth.layout.head')

<h1 class="h2 mt-auto">Selamat datang kembali</h1>
<div class="nav fs-sm mb-4">
    Belum punya akun?
    <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('register') }}">
        Buat akun
    </a>
</div>
@include('alert')
<!-- Form -->
<form class="needs-validation" action="{{ route('login.process') }}" method="POST">
    @csrf
    <div class="position-relative mb-4">
        <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" required>
        <div class="invalid-tooltip bg-transparent py-0">
            Masukkan alamat email yang valid!
        </div>
    </div>
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
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="form-check me-2">
            <input type="checkbox" class="form-check-input" id="remember-30" checked>
            <label for="remember-30" class="form-check-label">
                Ingat saya!
            </label>
        </div>
        <div class="nav">
            <a class="nav-link animate-underline p-0" href="{{ route('forgotPassword') }}">
                <span class="animate-target">Lupa kata sandi?</span>
            </a>
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
