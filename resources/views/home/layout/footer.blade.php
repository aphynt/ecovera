<footer class="footer bg-dark pb-4" data-bs-theme="dark">

        <!-- Subscription -->
        <div class="border-bottom py-5">
            <div class="container py-sm-1 py-md-2 py-lg-3">
                <div class="text-center mx-auto" style="max-width: 580px">
                    <h3 class="pb-1 mb-2">Tetap terhubung dengan kami</h3>
                    <p class="fs-sm text-body">
                        Dapatkan pembaruan terbaru tentang produk kami
                    </p>
                    <form class="needs-validation position-relative d-flex flex-column flex-sm-row gap-2 pt-3"
                        novalidate>
                        <input type="email" class="form-control form-control-lg rounded-pill text-start"
                            placeholder="Email Anda" aria-label="Alamat email Anda" required>
                        <div class="invalid-tooltip bg-transparent p-0">
                            Silakan masukkan alamat email Anda!
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary rounded-pill">
                            Berlangganan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Hak Cipta -->
        <p class="container fs-xs text-body text-center pb-md-3 mb-0">
            &copy; Semua hak dilindungi undang-undang. Dibuat oleh
            <span class="animate-underline">
                <a class="animate-target text-white text-decoration-none"
                    href="https://ahmadfadillah.my.id" target="_blank"
                    rel="noreferrer">IT</a>
            </span>
        </p>

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
