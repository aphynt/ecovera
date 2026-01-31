@include('home.layout.head')
@include('home.layout.header')
@include('home.layout.categories')
<!-- Page content -->
<main class="content-wrapper">

    <!-- Hero slider -->
    <section class="position-relative">
        <div class="swiper position-absolute top-0 start-0 w-100 h-100" data-swiper='{
          "effect": "fade",
          "loop": true,
          "speed": 400,
          "pagination": {
            "el": ".swiper-pagination",
            "clickable": true
          },
          "autoplay": {
            "delay": 5500,
            "disableOnInteraction": false
          }
        }' data-bs-theme="dark">
            <div class="swiper-wrapper">

                <!-- Slide -->
                <div class="swiper-slide" style="background-color: #6dafca">
                    <div class="position-absolute d-flex align-items-center w-100 h-100 z-2">
                        <div class="container mt-lg-n4">
                            <div class="row">
                                <div class="col-9 col-sm-8 col-md-7 col-lg-6">
                                    <p class="fs-sm text-white mb-lg-4">🔥 Gratis ongkir untuk area dekat rumah </p>
                                    <h2 class="display-4 pb-2 pb-md-3 pb-lg-4">
                                        Produk Sehat Tersedia untuk Semua Orang
                                    </h2>
                                    <a class="btn btn-lg btn-outline-light rounded-pill" href="#">Belanja sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img src="{{ asset('home') }}/assets/img/home/grocery/hero-slider/01.png"
                        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover rtl-flip" alt="Gambar">
                </div>

                <!-- Slide -->
                <div class="swiper-slide" style="background-color: #5a7978">
                    <div class="position-absolute d-flex align-items-center w-100 h-100 z-2">
                        <div class="container mt-lg-n4">
                            <div class="row">
                                <div class="col-12 col-sm-10 col-md-7 col-lg-6">
                                    <p class="fs-sm text-white mb-lg-4">🥚 Produk organik langsung ke meja Anda</p>
                                    <h2 class="display-4 pb-2 pb-md-3 pb-lg-4">
                                        Produk organik dari sayuran
                                    </h2>
                                    <a class="btn btn-lg btn-outline-light rounded-pill" href="#">Belanja sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img src="{{ asset('home') }}/assets/img/home/grocery/hero-slider/02.png"
                        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover rtl-flip" alt="Gambar">
                </div>

                <!-- Slide -->
                <div class="swiper-slide" style="background-color: #f99c03">
                    <div class="position-absolute d-flex align-items-center w-100 h-100 z-2">
                        <div class="container mt-lg-n4">
                            <div class="row">
                                <div class="col-9 col-sm-8 col-md-7 col-lg-6">
                                    <p class="fs-sm text-white mb-lg-4">🥝 Hanya menggunakan bahan alami</p>
                                    <h2 class="display-4 pb-2 pb-md-3 pb-lg-4">
                                        Barang yang tidak terpakai didaur ulang
                                    </h2>
                                    <a class="btn btn-lg btn-outline-light rounded-pill" href="#">Belanja sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img src="{{ asset('home') }}/assets/img/home/grocery/hero-slider/03.png"
                        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover rtl-flip" alt="Gambar">
                </div>

            </div>

            <!-- Slider pagination (Bullets) -->
            <div class="swiper-pagination pb-sm-2"></div>
        </div>
        <div class="d-md-none" style="height: 380px"></div>
        <div class="d-none d-md-block d-lg-none" style="height: 420px"></div>
        <div class="d-none d-lg-block d-xl-none" style="height: 500px"></div>
        <div class="d-none d-xl-block d-xxl-none" style="height: 560px"></div>
        <div class="d-none d-xxl-block" style="height: 624px"></div>
    </section>


    <!-- Featured categories that turns into carousel on screen < 992px (lg breackpoint) -->
    <section class="container pt-4 pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
        <div class="swiper" data-swiper='{
          "slidesPerView": 1,
          "spaceBetween": 24,
          "pagination": {
            "el": ".swiper-pagination",
            "clickable": true
          },
          "breakpoints": {
            "680": {
              "slidesPerView": 2
            },
            "992": {
              "slidesPerView": 3
            }
          }
        }'>
            {{-- <div class="swiper-wrapper">

                <!-- Category -->
                <div class="swiper-slide h-auto">
                    <div
                        class="position-relative d-flex justify-content-between align-items-center h-100 bg-primary-subtle rounded-5 overflow-hidden ps-2 ps-xl-3">
                        <div class="d-flex flex-column pt-4 px-3 pb-3">
                            <p class="fs-xs pb-2 mb-1">124 products</p>
                            <h2 class="h5 mb-2 mb-xxl-3">Only fresh fish to your table</h2>
                            <div class="nav">
                                <a class="nav-link animate-underline stretched-link text-body-emphasis text-nowrap px-0"
                                    href="shop-catalog-grocery.html">
                                    <span class="animate-target">Shop now</span>
                                    <i class="ci-chevron-right fs-base ms-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ratio w-100 align-self-end rtl-flip"
                            style="max-width: 216px; --cz-aspect-ratio: calc(240 / 216 * 100%)">
                            <img src="{{ asset('home') }}/assets/img/home/grocery/featured/01.png" alt="Image">
                        </div>
                    </div>
                </div>

                <!-- Category -->
                <div class="swiper-slide h-auto">
                    <div
                        class="position-relative d-flex justify-content-between align-items-center h-100 bg-success-subtle rounded-5 overflow-hidden ps-2 ps-xl-3">
                        <div class="d-flex flex-column pt-4 px-3 pb-3">
                            <p class="fs-xs pb-2 mb-1">97 products</p>
                            <h2 class="h5 mb-2 mb-xxl-3">Products for Easter table</h2>
                            <div class="nav">
                                <a class="nav-link animate-underline stretched-link text-body-emphasis text-nowrap px-0"
                                    href="shop-catalog-grocery.html">
                                    <span class="animate-target">Shop now</span>
                                    <i class="ci-chevron-right fs-base ms-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ratio w-100 align-self-end rtl-flip"
                            style="max-width: 216px; --cz-aspect-ratio: calc(240 / 216 * 100%)">
                            <img src="{{ asset('home') }}/assets/img/home/grocery/featured/02.png" alt="Image">
                        </div>
                    </div>
                </div>

                <!-- Category -->
                <div class="swiper-slide h-auto">
                    <div
                        class="position-relative d-flex justify-content-between align-items-center h-100 bg-info-subtle rounded-5 overflow-hidden ps-2 ps-xl-3">
                        <div class="d-flex flex-column pt-4 px-3 pb-3">
                            <p class="fs-xs pb-2 mb-1">28 products</p>
                            <h2 class="h5 mb-2 mb-xxl-3">Berries from the garden</h2>
                            <div class="nav">
                                <a class="nav-link animate-underline stretched-link text-body-emphasis text-nowrap px-0"
                                    href="shop-catalog-grocery.html">
                                    <span class="animate-target">Shop now</span>
                                    <i class="ci-chevron-right fs-base ms-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ratio w-100 align-self-end rtl-flip"
                            style="max-width: 216px; --cz-aspect-ratio: calc(240 / 216 * 100%)">
                            <img src="{{ asset('home') }}/assets/img/home/grocery/featured/03.png" alt="Image">
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Slider pagination (Bullets) -->
            <div class="swiper-pagination position-static mt-3 mt-sm-4"></div>
        </div>
    </section>


    <!-- Categories + Popular products -->
    <section class="container pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
        <div class="row">

            <!-- Categories list -->
            <div class="col-lg-3 pb-2 pb-sm-3 pb-md-4 mb-5 mb-lg-0">
                <h2 class="h3 border-bottom pb-3 pb-md-4 mb-4">Categories</h2>
                <div class="row nav g-3 g-sm-4">
                    @foreach ($data['category'] as $category)
                        <div class="col-sm-6 col-md-4 col-lg-12 d-flex">
                            <div class="position-relative d-flex min-w-0 align-items-center">
                                <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-body-tertiary rounded-circle"
                                    style="width: 56px; height: 56px">
                                    <img src="{{ asset('storage/' . $category->image_url) }}" width="40" alt="Image">
                                </div>
                                <div class="min-w-0 ps-3">
                                    <a class="nav-link animate-underline stretched-link fs-base fw-semibold p-0 mb-1"
                                        href="shop-catalog-grocery.html">
                                        <span class="animate-target text-truncate">{{ $category->name }}</span>
                                    </a>
                                    <div class="fs-xs fw-normal text-body-secondary">{{ $category->products_count }} produk
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="col-lg-9">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4 mb-3 mb-lg-4">
                    <h2 class="h3 mb-0">Produk populer</h2>
                    <div class="nav ms-3">
                        <a class="nav-link animate-underline px-0 py-2" href="shop-catalog-grocery.html">
                            <span class="animate-target">Lihat semua</span>
                            <i class="ci-chevron-right fs-base ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Products grid -->
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-3 row-cols-xl-4 g-4">
                    @foreach ($data['popularProducts'] as $product)
                                    <div class="col">
                                        <div class="card product-card h-100 bg-transparent border-0 shadow-none">

                                            <div class="position-relative z-2">
                                                <button type="button"
                                                    class="btn btn-icon btn-sm btn-secondary animate-pulse fs-sm bg-body border-0 position-absolute top-0 end-0 z-2 mt-1 mt-sm-2 me-1 me-sm-2">
                                                    <i class="ci-heart animate-target"></i>
                                                </button>

                                                <a class="d-block p-2 p-lg-3" href="#">
                                                    <div class="ratio" style="--cz-aspect-ratio: calc(160 / 191 * 100%)">
                                                        <img src="{{ $product->primaryImage
                        ? asset('storage/' . $product->primaryImage->image_url)
                        : asset('logo/logo.png') }}" alt="{{ $product->name }}">
                                                    </div>
                                                </a>

                                                <!-- Button Add to Cart -->
                                                <div class="position-absolute w-100 start-0 bottom-0 px-2 px-lg-3 pb-2 pb-lg-3">
                                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary w-100 btn-sm">
                                                            <i class="ci-cart me-1"></i>
                                                            Masukkan ke Keranjang
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="card-body pt-0 px-1 px-md-2 px-lg-3 pb-2">
                                                <div class="h6 mb-2">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </div>
                                                <h3 class="fs-sm lh-base mb-0">
                                                    <a class="hover-effect-underline fw-normal" href="#">
                                                        {{ $product->name }}
                                                    </a>
                                                </h3>

                                                @if($product->store && $product->store->user_id)
                                                    <div class="mt-2">
                                                        <a href="{{ route('admin.chat.show', $product->store->user_id) }}"
                                                            class="btn btn-sm btn-outline-info w-100">
                                                            <i class="ci-chat me-1"></i> Chat Penjual
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="fs-xs text-body-secondary px-1 px-md-2 px-lg-3 pb-2 pb-md-3">
                                                {{ $product->weight }} g
                                            </div>

                                        </div>
                                    </div>
                    @endforeach
                </div>


            </div>
        </div>
    </section>


    <section class="container pb-5 mb-2 mb-sm-3 mb-lg-4">
        <h2 class="h3 mb-4">Inspirasi Produk Ramah Lingkungan</h2>

        <div class="row" id="eco-articles">
            <div class="text-muted">Memuat produk ramah lingkungan...</div>
        </div>
    </section>


</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const ACCESS_KEY = 'anWyMYZz3lw4T-5lJdU9_Ed4zi-EOsIY6GI-gPSpPEc';
        const container = document.getElementById('eco-articles');

        fetch(`https://api.unsplash.com/search/photos?query=recycled%20eco%20product&per_page=4&client_id=${ACCESS_KEY}`)
            .then(res => res.json())
            .then(data => {
                container.innerHTML = '';

                data.results.forEach(item => {
                    container.innerHTML += `
                    <div class="col-md-6 col-lg-3 mb-4">
                        <article class="h-100">
                            <a href="${item.links.html}" target="_blank" class="d-block mb-3">
                                <img src="${item.urls.small}"
                                     class="img-fluid rounded-4"
                                     alt="${item.alt_description ?? 'Eco product'}">
                            </a>

                            <h3 class="fs-base fw-semibold lh-base mb-1">
                                <a href="${item.links.html}"
                                   target="_blank"
                                   class="text-decoration-none hover-effect-underline">
                                   ${item.alt_description ?? 'Produk Ramah Lingkungan'}
                                </a>
                            </h3>

                            <div class="fs-xs text-muted">
                                Foto oleh
                                <a href="${item.user.links.html}"
                                   target="_blank"
                                   class="text-decoration-underline">
                                   ${item.user.name}
                                </a>
                                di Unsplash
                            </div>
                        </article>
                    </div>
                `;
                });
            })
            .catch(err => {
                console.error(err);
                container.innerHTML = `<p class="text-muted">Gagal memuat konten.</p>`;
            });

    });
</script>



@include('home.layout.footer')