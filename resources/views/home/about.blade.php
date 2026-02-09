@include('home.layout.head')
@include('home.layout.header')
@include('home.layout.categories')

<main class="content-wrapper">
    <!-- Hero Section -->
    <section class="position-relative bg-dark py-5">
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-50"
            style="background-image: url('{{ asset('home/assets/img/home/grocery/hero-slider/02.png') }}'); background-size: cover; background-position: center;">
        </div>
        <div class="container position-relative z-2 py-5 text-center text-white">
            <h1 class="display-3 fw-bold mb-4 text-white">Tentang EcoVera</h1>
            <p class="lead fs-3 mb-0 text-white">Membangun Masa Depan yang Lebih Hijau Melalui Pilihan Berkelanjutan</p>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="container py-5 my-4 my-md-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="{{ asset('home/assets/img/home/grocery/hero-slider/01.png') }}"
                    class="img-fluid rounded-5 shadow-lg" alt="Our Story">
            </div>
            <div class="col-md-6 ps-md-5">
                <h2 class="h1 mb-4">Cerita Kami</h2>
                <p class="fs-lg text-body-secondary mb-4">
                    EcoVera lahir dari sebuah keinginan sederhana: membuat gaya hidup ramah lingkungan dapat diakses
                    oleh semua orang. Kami percaya bahwa setiap pilihan kecil yang kita buat setiap hari memiliki dampak
                    besar bagi planet ini.
                </p>
                <p class="fs-lg text-body-secondary">
                    Dimulai sebagai inisiatif komunitas kecil, kini kami telah berkembang menjadi platform yang
                    menghubungkan produsen lokal yang sadar lingkungan dengan konsumen yang peduli. Kami tidak hanya
                    menjual produk; kami membangun gerakan untuk bumi yang lebih baik.
                </p>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Cards -->
    <section class="bg-body-tertiary py-5">
        <div class="container py-md-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                        <div class="card-body p-4 p-lg-5 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="ci-eye fs-1"></i>
                            </div>
                            <h3 class="h2 mb-3">Visi Kami</h3>
                            <p class="fs-lg text-body-secondary mb-0">
                                Menjadi platform terdepan di Indonesia untuk produk-produk berkelanjutan, di mana
                                keberlanjutan bukan lagi pilihan, melainkan standar kehidupan sehari-hari.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                        <div class="card-body p-4 p-lg-5">
                            <div class="text-center">
                                <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle mb-4"
                                    style="width: 80px; height: 80px;">
                                    <i class="ci-rocket fs-1"></i>
                                </div>
                                <h3 class="h2 mb-3">Misi Kami</h3>
                            </div>
                            <ol class="fs-lg text-body-secondary mb-0 " style="text-align: justify;">
                                <li class="mb-2">Menyediakan produk ramah lingkungan yang berkualitas tinggi dan
                                    terjangkau bagi seluruh lapisan masyarakat.</li>
                                <li class="mb-2">Memberdayakan UMKM dan petani lokal melalui akses pasar digital yang
                                    adil dan inklusif.</li>
                                <li class="mb-2">Mengurangi jejak karbon logistik dengan mengoptimalkan rantai pasok dan
                                    menggunakan kemasan berkelanjutan.</li>
                                <li class="mb-2">Mengedukasi konsumen tentang dampak lingkungan dari pola konsumsi
                                    sehari-hari.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="container py-5 my-4 my-md-5">
        <h2 class="text-center h1 mb-5">Mengapa Memilih EcoVera?</h2>
        <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-lg-4">
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="mb-4">
                            <i class="ci-leaf fs-1 text-success"></i>
                        </div>
                        <h4 class="h5 mb-3">100% Organik</h4>
                        <p class="text-body-secondary mb-0">Produk kami dijamin bebas dari bahan kimia berbahaya dan
                            pestisida
                            sintetis.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="mb-4">
                            <i class="ci-package fs-1 text-info"></i>
                        </div>
                        <h4 class="h5 mb-3">Ramah Lingkungan</h4>
                        <p class="text-body-secondary mb-0">Kemasan yang dapat didaur ulang dan proses produksi yang
                            minim limbah.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="mb-4">
                            <i class="ci-heart fs-1 text-danger"></i>
                        </div>
                        <h4 class="h5 mb-3">Dedikasi Komunitas</h4>
                        <p class="text-body-secondary mb-0">Kami mendukung petani dan pengrajin lokal untuk tumbuh
                            bersama.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="mb-4">
                            <i class="ci-delivery fs-1 text-warning"></i>
                        </div>
                        <h4 class="h5 mb-3">Pengiriman Cepat</h4>
                        <p class="text-body-secondary mb-0">Layanan pengiriman yang efisien dan ramah lingkungan ke
                            seluruh wilayah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Join Us CTA -->
    <section class="position-relative bg-body-secondary py-5 overflow-hidden">
        <div class="container position-relative z-2 text-center py-4">
            <h2 class="h1 text-dark mb-4">Bergabunglah dalam Perjalanan Hijau Ini</h2>
            <p class="fs-xl text-dark opacity-100 mb-5 mx-auto" style="max-width: 600px;">
                Mulailah perubahan kecil hari ini untuk masa depan yang lebih baik. Temukan produk-produk pilihan kami.
            </p>
            <a href="{{ route('products.all') }}" class="btn btn-lg btn-success rounded-pill px-5">Belanja Sekarang</a>
        </div>
    </section>

</main>

@include('home.layout.footer')