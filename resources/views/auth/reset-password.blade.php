@include('auth.layout.head')

<h1 class="h2 mt-auto">Atur Ulang Kata Sandi</h1>
<p class="pb-2 pb-md-3">
    Silakan masukkan kata sandi baru untuk akun Anda.
</p>

<!-- Form Reset Password -->
<form class="needs-validation pb-4 mb-3 mb-lg-4"
      action="{{ route('updatePassword') }}"
      method="POST" novalidate>
    @csrf

    <!-- Token & Email -->
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ request('email') }}">

    <!-- Password Baru -->
    <div class="position-relative mb-4">
        <i class="ci-lock position-absolute top-50 start-0 translate-middle-y fs-lg ms-3"></i>
        <input type="password"
               name="password"
               class="form-control form-control-lg form-icon-start @error('password') is-invalid @enderror"
               placeholder="Password baru"
               required
               minlength="8">

        @error('password')
            <div class="invalid-tooltip bg-transparent py-0">
                {{ $message }}
            </div>
        @else
            <div class="invalid-tooltip bg-transparent py-0">
                Password minimal 8 karakter
            </div>
        @enderror
    </div>

    <!-- Konfirmasi Password -->
    <div class="position-relative mb-4">
        <i class="ci-lock position-absolute top-50 start-0 translate-middle-y fs-lg ms-3"></i>
        <input type="password"
               name="password_confirmation"
               class="form-control form-control-lg form-icon-start"
               placeholder="Konfirmasi password"
               required>

        <div class="invalid-tooltip bg-transparent py-0">
            Konfirmasi password harus sama
        </div>
    </div>

    <!-- Navigasi -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="nav">
            <a class="nav-link animate-underline p-0" href="{{ route('login') }}">
                <span class="animate-target">Kembali ke halaman login</span>
            </a>
        </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-lg btn-primary w-100">
        Reset Password
    </button>
</form>

@include('auth.layout.footer')
