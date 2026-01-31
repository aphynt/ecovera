@include('home.layout.head')
@include('home.layout.header')

<!-- Page content -->
<main class="content-wrapper">
    
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            @if($data['categoryName'])
                <li class="breadcrumb-item"><a href="{{ route('products.all') }}">Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data['categoryName'] }}</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Semua Produk</li>
            @endif
        </ol>
    </nav>

    <!-- Products Section -->
    <section class="container pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
        <div class="row">

            <!-- Categories Sidebar -->
            <div class="col-lg-3 pb-2 pb-sm-3 pb-md-4 mb-5 mb-lg-0">
                <h2 class="h3 border-bottom pb-3 pb-md-4 mb-4">Categories</h2>
                <div class="row nav g-3 g-sm-4">
                    <!-- View All Link -->
                    <div class="col-sm-6 col-md-4 col-lg-12 d-flex">
                        <div class="position-relative d-flex min-w-0 align-items-center w-100">
                            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-body-tertiary rounded-circle"
                                style="width: 56px; height: 56px">
                                <i class="ci-grid fs-xl"></i>
                            </div>
                            <div class="min-w-0 ps-3">
                                <a class="nav-link animate-underline stretched-link fs-base fw-semibold p-0 mb-1 {{ !$data['categoryName'] ? 'text-primary' : '' }}"
                                    href="{{ route('products.all') }}">
                                    <span class="animate-target text-truncate">Lihat Semua</span>
                                </a>
                                <div class="fs-xs fw-normal text-body-secondary">
                                    @php
                                        $totalProducts = \App\Models\Products::where('status', 'active')->count();
                                    @endphp
                                    {{ $totalProducts }} produk
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Links -->
                    @foreach ($data['categories'] as $category)
                    <div class="col-sm-6 col-md-4 col-lg-12 d-flex">
                        <div class="position-relative d-flex min-w-0 align-items-center w-100">
                            <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-body-tertiary rounded-circle"
                                style="width: 56px; height: 56px">
                                <img src="{{ asset('storage/'.$category->image_url) }}" width="40"
                                    alt="{{ $category->name }}">
                            </div>
                            <div class="min-w-0 ps-3">
                                <a class="nav-link animate-underline stretched-link fs-base fw-semibold p-0 mb-1 {{ $data['categoryName'] == $category->name ? 'text-primary' : '' }}"
                                    href="{{ route('products.category', $category->slug) }}">
                                    <span class="animate-target text-truncate">{{ $category->name }}</span>
                                </a>
                                <div class="fs-xs fw-normal text-body-secondary">{{ $category->products_count }} produk</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <div class="border-bottom pb-3 pb-md-4 mb-3 mb-lg-4">
                    <h2 class="h3 mb-2">{{ $data['pageTitle'] }}</h2>
                    <p class="text-muted mb-0">
                        @if($data['categoryName'] && isset($data['categoryDescription']))
                            {{ $data['categoryDescription'] }}
                        @else
                            Temukan Peralatan dan Kebutuhan Yang Kamu Inginkan
                        @endif
                    </p>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3 mb-lg-4">
                    <div class="text-muted">
                        {{ $data['products']->total() }} produk ditemukan
                    </div>
                </div>

                @if($data['products']->count() > 0)
                    <!-- Products Grid -->
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-3 row-cols-xl-4 g-4">
                        @foreach ($data['products'] as $product)
                            <div class="col">
                                <div class="card product-card h-100 bg-transparent border-0 shadow-none">

                                    <div class="position-relative z-2">
                                        <button type="button"
                                            class="btn btn-icon btn-sm btn-secondary animate-pulse fs-sm bg-body border-0 position-absolute top-0 end-0 z-2 mt-1 mt-sm-2 me-1 me-sm-2">
                                            <i class="ci-heart animate-target"></i>
                                        </button>

                                        <a class="d-block p-2 p-lg-3" href="{{ route('product.detail', $product->uuid) }}">
                                            <div class="ratio" style="--cz-aspect-ratio: calc(160 / 191 * 100%)">
                                                <img
                                                    src="{{ $product->primaryImage
                                                            ? asset('storage/'.$product->primaryImage->image_url)
                                                            : asset('logo/logo.png') }}"
                                                    alt="{{ $product->name }}">
                                            </div>
                                        </a>

                                        <!-- Button Add to Cart -->
                                        <div class="position-absolute w-100 start-0 bottom-0 px-2 px-lg-3 pb-2 pb-lg-3">
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-primary w-100 btn-sm">
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
                                            <a class="hover-effect-underline fw-normal" href="{{ route('product.detail', $product->uuid) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                    </div>

                                    <div class="fs-xs text-body-secondary px-1 px-md-2 px-lg-3 pb-2 pb-md-3">
                                        {{ $product->weight }} g
                                    </div>

                                    @if($product->category)
                                        <div class="fs-xs text-muted px-1 px-md-2 px-lg-3 pb-2">
                                            <i class="ci-tag me-1"></i>{{ $product->category->name }}
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($data['products']->hasPages())
                        <div class="d-flex justify-content-center mt-4 pt-3">
                            <nav aria-label="Product pagination">
                                {{ $data['products']->links() }}
                            </nav>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="ci-package fs-1 text-muted"></i>
                        </div>
                        <h3 class="h5 mb-2">Tidak ada produk ditemukan</h3>
                        <p class="text-muted mb-4">Maaf, tidak ada produk dalam kategori ini saat ini.</p>
                        <a href="{{ route('products.all') }}" class="btn btn-primary">
                            Lihat Semua Produk
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </section>

</main>

@include('home.layout.footer')
