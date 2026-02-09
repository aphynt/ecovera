<footer class="footer bg-dark pt-5 pb-4" data-bs-theme="dark">
    <div class="container pt-2 pb-3">
        <div class="row">
            <!-- About -->
            <div class="col-md-4 col-lg-4 mb-4">
                <a class="navbar-brand d-inline-block text-white mb-3" href="{{ route('home') }}">
                    <img src="{{ asset('logo/logo.png') }}" alt="{{ config('app.name') }}" width="50"
                        class="d-inline-block align-text-top">
                </a>
                <p class="text-body fs-sm mb-4">
                    EcoVera adalah platform e-commerce yang berdedikasi untuk menyediakan produk ramah lingkungan dan
                    organik berkualitas tinggi demi masa depan yang lebih hijau.
                </p>
                <div class="d-flex gap-2">
                    <a class="btn btn-icon btn-sm btn-secondary rounded-circle" href="#" aria-label="Instagram">
                        <i class="ci-instagram"></i>
                    </a>
                    <a class="btn btn-icon btn-sm btn-secondary rounded-circle" href="#" aria-label="Facebook">
                        <i class="ci-facebook"></i>
                    </a>
                    <a class="btn btn-icon btn-sm btn-secondary rounded-circle" href="#" aria-label="YouTube">
                        <i class="ci-youtube"></i>
                    </a>
                    <a class="btn btn-icon btn-sm btn-secondary rounded-circle" href="#" aria-label="Telegram">
                        <i class="ci-telegram"></i>
                    </a>
                </div>
            </div>

            <!-- Links -->
            <div class="col-md-4 col-lg-4 mb-4">
                <h6 class="fs-base text-white mb-3">Tautan Cepat</h6>
                <ul class="nav flex-column fs-sm">
                    <li class="nav-item mb-2">
                        <a class="nav-link p-0 animate-underline" href="{{ route('home') }}">
                            <span class="animate-target">Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link p-0 animate-underline" href="{{ route('products.all') }}">
                            <span class="animate-target">Semua Produk</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link p-0 animate-underline" href="{{ route('about') }}">
                            <span class="animate-target">Tentang Kami</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link p-0 animate-underline" href="{{ route('complaint.index') }}">
                            <span class="animate-target">Layanan Pengaduan</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-md-4 col-lg-4 mb-4">
                <h6 class="fs-base text-white mb-3">Hubungi Kami</h6>
                <ul class="nav flex-column fs-sm">
                    <li class="nav-item mb-2">
                        <span class="text-body">Alamat:</span><br>
                        <span class="text-white">Jl. Mawar Melati Indah No. 123, Jakarta, Indonesia</span>
                    </li>
                    <li class="nav-item mb-2">
                        <span class="text-body">Email:</span><br>
                        <a href="mailto:support@ecovera.com"
                            class="nav-link p-0 text-white animate-underline d-inline-block">
                            <span class="animate-target">support@ecovera.com</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <span class="text-body">Telepon:</span><br>
                        <a href="tel:+6281234567890" class="nav-link p-0 text-white animate-underline d-inline-block">
                            <span class="animate-target">+62 812 3456 7890</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="text-body opacity-25 my-4">

        <div class="d-md-flex align-items-center justify-content-between text-center text-md-start">
            <p class="fs-xs text-body mb-0">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
            <div class="mt-2 mt-md-0">
                <p class="fs-xs text-body mb-0">
                    Dibuat dengan <i class="ci-heart text-danger"></i> oleh <a href="https://ahmadfadillah.my.id"
                        target="_blank" class="text-white animate-underline text-decoration-none"><span
                            class="animate-target">IT Team</span></a>
                </p>
            </div>
        </div>
    </div>
</footer>


<!-- Back to top button -->
<div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4">
    <a class="btn-scroll-top btn btn-sm bg-body border-0 rounded-pill shadow animate-slide-end" href="#top">
        Top
        <i class="ci-arrow-right fs-base ms-1 me-n1 animate-target"></i>
        <span class="position-absolute top-0 start-0 w-100 h-100 border rounded-pill z-0"></span>
        <svg class="position-absolute top-0 start-0 w-100 h-100 z-1" viewBox="0 0 62 32" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <rect x=".75" y=".75" width="60.5" height="30.5" rx="15.25" stroke="currentColor" stroke-width="1.5"
                stroke-miterlimit="10" />
        </svg>
    </a>
</div>


<!-- Vendor scripts -->
<script src="{{ asset('home') }}/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="{{ asset('home') }}/assets/vendor/simplebar/dist/simplebar.min.js"></script>
<script src="{{ asset('home') }}/assets/scripts/choices.min.js"></script>

<!-- Bootstrap + Theme scripts -->
<script src="{{ asset('home') }}/assets/js/theme.min.js"></script>
</body>

</html>