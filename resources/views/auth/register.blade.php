@include('auth.layout.head')


<h1 class="h2 mt-auto">Buat akun</h1>
<div class="nav fs-sm mb-3 mb-lg-4">
    Saya sudah punya akun
    <a class="nav-link text-decoration-underline p-0 ms-2" href="{{ route('login') }}">
        Masuk
    </a>
</div>
<div class="nav fs-sm mb-4 d-lg-none">
    <span class="me-2">Masih ragu untuk membuat akun?</span>
    <a class="nav-link text-decoration-underline p-0"
       href="#benefits"
       data-bs-toggle="offcanvas"
       aria-controls="benefits">
        Lihat manfaatnya
    </a>
</div>

<form class="needs-validation" novalidate>

    <!-- Nama -->
    <div class="position-relative mb-4">
        <label for="register-name" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control form-control-lg" id="register-name" required>
        <div class="invalid-tooltip bg-transparent py-0">
            Nama wajib diisi!
        </div>
    </div>

    <!-- NIM -->
    <div class="position-relative mb-4">
        <label for="register-nim" class="form-label">NIM</label>
        <input type="text" class="form-control form-control-lg" id="register-nim" required>
        <div class="invalid-tooltip bg-transparent py-0">
            NIM wajib diisi!
        </div>
    </div>

    <!-- Instansi -->
    <div class="position-relative mb-4">
        <label for="register-instansi" class="form-label">Instansi</label>
        <input type="text" class="form-control form-control-lg" id="register-instansi" required>
        <div class="invalid-tooltip bg-transparent py-0">
            Instansi wajib diisi!
        </div>
    </div>

    <!-- Email -->
    <div class="position-relative mb-4">
        <label for="register-email" class="form-label">Email</label>
        <input type="email" class="form-control form-control-lg" id="register-email" required>
        <div class="invalid-tooltip bg-transparent py-0">
            Masukkan alamat email yang valid!
        </div>
    </div>

    <!-- Password -->
    <div class="mb-4">
        <label for="register-password" class="form-label">Kata sandi</label>
        <div class="password-toggle">
            <input type="password"
                   class="form-control form-control-lg"
                   id="register-password"
                   minlength="8"
                   placeholder="Minimal 8 karakter"
                   required>
            <div class="invalid-tooltip bg-transparent py-0">
                Kata sandi tidak memenuhi kriteria yang ditentukan!
            </div>
            <label class="password-toggle-button fs-lg" aria-label="Tampilkan/sembunyikan kata sandi">
                <input type="checkbox" class="btn-check">
            </label>
        </div>
    </div>

    <!-- Options -->
    <div class="d-flex flex-column gap-2 mb-4">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="save-pass" required checked>
            <label for="save-pass" class="form-check-label">
                Simpan kata sandi
            </label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="privacy" required>
            <label for="privacy" class="form-check-label">
                Saya telah membaca dan menyetujui
                <a class="text-dark-emphasis" href="#!">Kebijakan Privasi</a>
            </label>
        </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-lg btn-primary w-100">
        Buat akun
        <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
    </button>

</form>



@include('auth.layout.footer')
