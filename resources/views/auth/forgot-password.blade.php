@include('auth.layout.head')

<h1 class="h2 mt-auto">Lupa kata sandi?</h1>
<p class="pb-2 pb-md-3">
    Masukkan alamat email yang Anda gunakan saat mendaftar, dan kami akan mengirimkan instruksi untuk mengatur ulang kata sandi Anda.
</p>
@include('alert')
<!-- Form -->
<form class="needs-validation pb-4 mb-3 mb-lg-4" action="{{ route('sendResetLink') }}" method="POST">
    @csrf
    <div class="position-relative mb-4">
        <i class="ci-mail position-absolute top-50 start-0 translate-middle-y fs-lg ms-3"></i>
        <input type="email" class="form-control form-control-lg form-icon-start" placeholder="Alamat email" name="email" required>
        <div class="invalid-tooltip bg-transparent py-0">
            Silakan masukkan alamat email yang valid!
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="nav">
            <a class="nav-link animate-underline p-0" href="{{ route('login') }}">
                <span class="animate-target">Kembali ke halaman login?</span>
            </a>
        </div>
    </div>
    <button type="submit" class="btn btn-lg btn-primary w-100">
        Atur ulang kata sandi
    </button>
</form>

@include('auth.layout.footer')
