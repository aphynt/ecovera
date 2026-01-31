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

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit" class="btn btn-lg btn-primary w-100 mb-3">
        Kirim Ulang Email Verifikasi
    </button>
</form>

<div class="text-center">
    <a href="{{ route('logout') }}" class="btn btn-link w-100 text-decoration-none">
        Keluar
    </a>
</div>

@include('auth.layout.footer')