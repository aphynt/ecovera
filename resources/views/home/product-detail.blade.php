@include('home.layout.head')
@include('home.layout.header')

<!-- Page content -->
<main class="content-wrapper">
    
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.all') }}">Produk</a></li>
            @if($data['product']->category)
                <li class="breadcrumb-item"><a href="{{ route('products.category', $data['product']->category->slug) }}">{{ $data['product']->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $data['product']->name }}</li>
        </ol>
    </nav>

    <!-- Product details -->
    <section class="container pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
        <div class="row">
            
            <!-- Product gallery -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="product-gallery">
                    <!-- Main image -->
                    <div class="mb-3">
                        <div class="ratio rounded-4 overflow-hidden bg-body-tertiary" style="--cz-aspect-ratio: calc(500 / 500 * 100%)">
                            <img id="mainImage" 
                                 src="{{ $data['product']->primaryImage 
                                         ? asset('storage/'.$data['product']->primaryImage->image_url) 
                                         : asset('logo/logo.png') }}" 
                                 alt="{{ $data['product']->name }}"
                                 class="object-fit-contain">
                        </div>
                    </div>

                    <!-- Thumbnail images -->
                    @if($data['product']->images && $data['product']->images->count() > 1)
                    <div class="d-flex gap-2 overflow-auto pb-2">
                        @foreach($data['product']->images as $image)
                        <button type="button" 
                                class="btn btn-outline-secondary p-1 rounded-3 {{ $image->is_primary ? 'active' : '' }}"
                                style="min-width: 80px; height: 80px;"
                                onclick="changeMainImage('{{ asset('storage/'.$image->image_url) }}', this)">
                            <img src="{{ asset('storage/'.$image->image_url) }}" 
                                 alt="{{ $data['product']->name }}"
                                 class="w-100 h-100 object-fit-contain">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product info -->
            <div class="col-lg-6">
                <div class="ps-lg-4 ps-xl-5">
                    
                    <!-- Category badge -->
                    @if($data['product']->category)
                    <div class="mb-3">
                        <a href="{{ route('products.category', $data['product']->category->slug) }}" 
                           class="badge bg-secondary text-decoration-none">
                            {{ $data['product']->category->name }}
                        </a>
                    </div>
                    @endif

                    <!-- Product name -->
                    <h1 class="h3 mb-3">{{ $data['product']->name }}</h1>

                    <!-- Price -->
                    <div class="h4 text-primary mb-4">
                        Rp {{ number_format($data['product']->price, 0, ',', '.') }}
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h2 class="h6 mb-3">DESKRIPSI</h2>
                        <div class="text-body-secondary">
                            {!! nl2br(e($data['product']->description)) !!}
                        </div>
                    </div>

                    <!-- Product details -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <span class="text-body-secondary me-2">Berat:</span>
                            <span class="fw-medium">{{ $data['product']->weight }} g</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="text-body-secondary me-2">Stok:</span>
                            <span class="fw-medium">{{ $data['product']->stock }} unit</span>
                        </div>
                        @if($data['product']->store)
                        <div class="d-flex align-items-center mb-2">
                            <span class="text-body-secondary me-2">Pemilik:</span>
                            <span class="fw-medium">{{ $data['product']->store->owner_name ?? 'Pyo' }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Add to cart button -->
                    <div class="d-flex gap-2 mb-4">
                        <form action="{{ route('cart.add', $data['product']->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="ci-cart me-2"></i>
                                PESAN SEKARANG
                            </button>
                        </form>
                    </div>

                    <!-- Additional info -->
                    <div class="border-top pt-4">
                        <p class="fs-sm text-muted mb-0">
                            <i class="ci-delivery fs-base me-2"></i>
                            Gratis ongkir untuk area dekat rumah
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Related products -->
        @if($data['relatedProducts'] && $data['relatedProducts']->count() > 0)
        <div class="border-top pt-5 mt-5">
            <h2 class="h3 mb-4">Produk Lain yang Mungkin Anda Suka</h2>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-4">
                @foreach($data['relatedProducts'] as $product)
                <div class="col">
                    <div class="card product-card h-100 bg-transparent border-0 shadow-none">
                        <div class="position-relative z-2">
                            <button type="button"
                                class="btn btn-icon btn-sm btn-secondary animate-pulse fs-sm bg-body border-0 position-absolute top-0 end-0 z-2 mt-1 mt-sm-2 me-1 me-sm-2">
                                <i class="ci-heart animate-target"></i>
                            </button>

                            <a class="d-block p-2 p-lg-3" href="{{ route('product.detail', $product->uuid) }}">
                                <div class="ratio" style="--cz-aspect-ratio: calc(160 / 191 * 100%)">
                                    <img src="{{ $product->primaryImage 
                                                ? asset('storage/'.$product->primaryImage->image_url) 
                                                : asset('logo/logo.png') }}"
                                         alt="{{ $product->name }}">
                                </div>
                            </a>

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
                                <a class="hover-effect-underline fw-normal" href="{{ route('product.detail', $product->uuid) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>
                        </div>

                        <div class="fs-xs text-body-secondary px-1 px-md-2 px-lg-3 pb-2 pb-md-3">
                            {{ $product->weight }} g
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </section>

</main>

<script>
function changeMainImage(src, button) {
    // Update main image
    document.getElementById('mainImage').src = src;
    
    // Update active state on thumbnails
    document.querySelectorAll('.product-gallery button').forEach(btn => {
        btn.classList.remove('active');
    });
    button.classList.add('active');
}
</script>

@include('home.layout.footer')
