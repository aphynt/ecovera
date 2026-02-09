@include('auth.layout.head')

<h1 class="h2 mt-auto">Verifikasi Email Anda</h1>
<p class="fs-sm mb-4">
    Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengeklik tautan
    yang baru saja kami kirimkan ke email Anda? Jika Anda tidak menerima email tersebut, kami akan dengan senang hati
    mengirimkan yang baru.
</p>

@if (session('message'))
    <div class="alert alert-success" role="alert">
        {{ session('message') }}
    </div>
@endif

<form method="POST" action="{{ route('verification.send') }}" id="resend-form">
    @csrf
    <input type="hidden" name="email" value="{{ session('email') }}">
    <button type="submit" class="btn btn-lg btn-primary w-100 mb-3" id="resend-btn">
        <span id="btn-text">Kirim Ulang Email Verifikasi</span>
    </button>
</form>

<div class="text-center">
    <a href="{{ route('logout') }}" class="btn btn-link w-100 text-decoration-none">
        Keluar
    </a>
</div>

<script>
    const resendBtn = document.getElementById('resend-btn');
    const btnText = document.getElementById('btn-text');
    const form = document.getElementById('resend-form');
    const COOLDOWN_TIME = 30; // seconds
    const STORAGE_KEY = 'resend_cooldown_end';

    function startCountdown(seconds) {
        resendBtn.disabled = true;
        resendBtn.classList.add('disabled');
        
        let remaining = seconds;
        const interval = setInterval(() => {
            remaining--;
            btnText.textContent = `Tunggu ${remaining} detik untuk kirim ulang`;
            
            if (remaining <= 0) {
                clearInterval(interval);
                resendBtn.disabled = false;
                resendBtn.classList.remove('disabled');
                btnText.textContent = 'Kirim Ulang Email Verifikasi';
                localStorage.removeItem(STORAGE_KEY);
            }
        }, 1000);
    }

    // Check if there's an active cooldown
    const cooldownEnd = localStorage.getItem(STORAGE_KEY);
    if (cooldownEnd) {
        const now = Date.now();
        const remaining = Math.ceil((cooldownEnd - now) / 1000);
        
        if (remaining > 0) {
            startCountdown(remaining);
        } else {
            localStorage.removeItem(STORAGE_KEY);
        }
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        if (!resendBtn.disabled) {
            const cooldownEnd = Date.now() + (COOLDOWN_TIME * 1000);
            localStorage.setItem(STORAGE_KEY, cooldownEnd);
            
            // Start countdown after a short delay to allow form submission
            setTimeout(() => {
                startCountdown(COOLDOWN_TIME);
            }, 100);
        }
    });
</script>

@include('auth.layout.footer')