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
    <a class="nav-link text-decoration-underline p-0" href="#benefits" data-bs-toggle="offcanvas"
        aria-controls="benefits">
        Lihat manfaatnya
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi kesalahan!</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form class="needs-validation" novalidate action="{{ route('register.process') }}" method="POST">
    @csrf

    <!-- Nama -->
    <div class="position-relative mb-4">
        <label for="register-name" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
               id="register-name" name="name" value="{{ old('name') }}" required>
        @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @else
            <div class="invalid-tooltip bg-transparent py-0">
                Nama wajib diisi!
            </div>
        @enderror
    </div>

    <!-- NIM -->
    <div class="position-relative mb-4">
        <label for="register-nim" class="form-label">NIM</label>
        <input type="text" class="form-control form-control-lg @error('nim') is-invalid @enderror" 
               id="register-nim" name="nim" value="{{ old('nim') }}" required>
        @error('nim')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @else
            <div class="invalid-tooltip bg-transparent py-0">
                NIM wajib diisi!
            </div>
        @enderror
    </div>

    <!-- Instansi -->
    <div class="position-relative mb-4">
        <label for="register-instansi" class="form-label">Instansi</label>
        <input type="text" class="form-control form-control-lg @error('instansi') is-invalid @enderror" 
               id="register-instansi" name="instansi" value="{{ old('instansi') }}" required>
        @error('instansi')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @else
            <div class="invalid-tooltip bg-transparent py-0">
                Instansi wajib diisi!
            </div>
        @enderror
    </div>

    <!-- Email -->
    <div class="position-relative mb-4">
        <label for="register-email" class="form-label">Email</label>
        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
               id="register-email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @else
            <div class="invalid-tooltip bg-transparent py-0">
                Masukkan alamat email yang valid!
            </div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-4">
        <label for="register-password" class="form-label">Kata sandi</label>
        <div class="password-toggle">
            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                   id="register-password" name="password" minlength="8" placeholder="Minimal 8 karakter" required>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @else
                <div class="invalid-tooltip bg-transparent py-0">
                    Kata sandi tidak memenuhi kriteria yang ditentukan!
                </div>
            @enderror
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
                <a class="text-dark-emphasis" href="#" data-bs-toggle="modal"
                    data-bs-target="#privacyPolicyModal">Kebijakan Privasi</a>
            </label>
        </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-lg btn-primary w-100">
        Buat akun
        <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
    </button>

</form>

<!-- Privacy Policy Modal -->
<div class="modal fade" id="privacyPolicyModal" tabindex="-1" aria-labelledby="privacyPolicyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0 d-flex flex-column align-items-center">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 mb-3 text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        <circle cx="12" cy="11" r="3" />
                        <path d="M12 14v1" />
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                    </svg>
                </div>
                <h5 class="modal-title fw-bold" id="privacyPolicyModalLabel">Kebijakan Privasi Platform</h5>
            </div>
            <div class="modal-body text-justify" style="max-height: 400px; overflow-y: auto;">
                <p class="text-body-secondary mb-3" style="text-align: justify;">
                    Selamat datang di platform marketplace mahasiswa. Dengan mengakses atau menggunakan layanan ini,
                    Anda dianggap telah membaca, memahami, dan menyetujui seluruh kebijakan berikut. Marketplace ini
                    dibuat untuk memfasilitasi jual beli barang kebutuhan mahasiswa secara aman, praktis dan terpercaya.
                </p>
                <ol class="text-body-secondary small ps-3" style="text-align: justify;">
                    <li class="mb-2">Pengguna adalah seluruh mahasiswa yang mengakses, menjual atau membeli barang
                        melalui platform.</li>
                    <li class="mb-2">Barang mencakup barang kebutuhan kuliah, Perlengkapan pribadi kost elektronik
                        ringan atau barang relevan lainnya.</li>
                    <li class="mb-2">Setiap barang yang diperjualkan di platform ini diwajibkan memiliki masa pemakaian
                        tidak lebih dari 4-5 tahun demi menjaga kualitas, kelayakan dan keamanan bagi pengguna.</li>
                    <li class="mb-2">Data tidak akan diperjual belikan dan hanya dibagikan kepada mitra pembayaran
                        ataupun logistik jika diperlukan.</li>
                    <li class="mb-2">Platform kami berhak menonaktifkan akun yang diduga menggunakan identitas palsu dan
                        melakukan penipuan.</li>
                    <li class="mb-2">Untuk menjaga keamanan website, pengguna hanya boleh menjual barang yang bersifat
                        legal, aman dan relevan untuk mahasiswa, seperti buku kuliah, alat tulis, elektronik, Furnitur
                        kost, perlengkapan kamar, pakaian dan perlengkapan pribadi.</li>
                    <li class="mb-2">Pembeli wajib membaca deskripsi produk secara teliti sebelum membeli.</li>
                    <li class="mb-2">Semua transaksi yang dilakukan merupakan persetujuan final antara pembeli dan
                        penjual.</li>
                    <li class="mb-2">Pembeli bertanggung jawab memasukkan alamat atau titik temu yang benar.</li>
                    <li class="mb-2">Penjual yang terbukti melakukan penipuan akan dikenakan sanksi pemblokiran akun.
                    </li>
                    <li class="mb-2">Pembeli dianjurkan untuk melakukan COD (Cash On Delivery) secara langsung dengan
                        penjual sebelum melakukan pembayaran, guna memastikan keamanan dan keaslian barang.</li>
                </ol>
                <p class="text-body-secondary mb-3" style="text-align: justify;">
                    Dengan menggunakan marketplace ini, Anda menyatakan telah membaca, memahami dan menyetujui
                    seluruh
                    Kebijakan Penggunaan & Privasi yang berlaku.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Saya Mengerti</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Set cooldown saat form registrasi disubmit
    const registerForm = document.querySelector('form.needs-validation');
    const COOLDOWN_TIME = 30; // seconds
    const STORAGE_KEY = 'resend_cooldown_end';
    
    registerForm.addEventListener('submit', function(e) {
        // Set cooldown untuk tombol resend email
        const cooldownEnd = Date.now() + (COOLDOWN_TIME * 1000);
        localStorage.setItem(STORAGE_KEY, cooldownEnd);
    });
</script>

@include('auth.layout.footer')