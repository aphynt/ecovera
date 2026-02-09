@php
    use App\Models\CategoryProduct;
    $menuCategories = CategoryProduct::where('is_active', true)->get();
@endphp

<body>
    @include('sweetalert2')
    <!-- Shopping cart offcanvas -->
    @include('home.layout.cart')
    @include('home.layout.address')


    <!-- Site menu offcanvas -->
    <nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1" aria-labelledby="navbarNavLabel">
        <div class="offcanvas-header py-3">
            <h5 class="offcanvas-title" id="navbarNavLabel">Menu EcoVera</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body pt-0 pb-3">

            <!-- Navbar nav -->
            <div class="d-flex flex-column gap-3">

                <!-- Beranda -->
                <div class="h6 fw-medium py-1 mb-0 border-bottom pb-2">
                    <a class="d-block animate-underline py-1" href="{{ route('home') }}">
                        <span class="d-inline-block animate-target py-1">Beranda</span>
                    </a>
                </div>

                <!-- Produk -->
                <div class="h6 fw-medium py-1 mb-0 border-bottom pb-2">
                    <a class="d-block animate-underline py-1" href="{{ route('products.all') }}">
                        <span class="d-inline-block animate-target py-1">Semua Produk</span>
                    </a>
                </div>

                <!-- Categories Accordion -->
                <div class="accordion border-bottom pb-2" id="navigation">
                    <div class="accordion-item border-0">
                        <div class="accordion-header" id="headingCategories">
                            <button type="button"
                                class="accordion-button animate-underline fw-medium collapsed py-2 px-0 shadow-none bg-transparent"
                                data-bs-toggle="collapse" data-bs-target="#categories" aria-expanded="false"
                                aria-controls="categories">
                                <span class="d-block animate-target py-1 h6 mb-0">Kategori</span>
                            </button>
                        </div>
                        <div class="accordion-collapse collapse" id="categories" aria-labelledby="headingCategories"
                            data-bs-parent="#navigation">
                            <div class="accordion-body pb-3 px-0">
                                <ul class="dropdown-menu show position-static shadow-none border-0 p-0">
                                    @foreach ($menuCategories as $category)
                                        <li class="hover-effect-opacity px-0">
                                            <a class="dropdown-item d-block mb-0 rounded"
                                                href="{{ route('products.category', $category->slug) }}">
                                                <span class="fw-medium">{{ $category->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>

        <!-- Account button visible on screens < 768px wide (md breakpoint) -->
        <div class="offcanvas-header flex-column align-items-start d-md-none">
            @if(Auth::check())
                <div class="w-100">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ci-user fs-xl me-2"></i>
                        <span class="fw-semibold">{{ Auth::user()->name }}</span>
                    </div>
                    @if(Auth::user()->role === 'admin')
                        <a class="btn btn-lg btn-outline-secondary w-100 rounded-pill mb-2"
                            href="{{ route('admin.dashboard.index') }}">
                            <i class="ci-pie-chart fs-lg ms-n1 me-2"></i>
                            Dashboard Admin
                        </a>
                    @elseif(Auth::user()->role == 'seller')
                        <a class="btn btn-lg btn-outline-secondary w-100 rounded-pill mb-2"
                            href="{{ route('seller.dashboard.index') }}">
                            <i class="ci-package fs-lg ms-n1 me-2"></i>
                            Dashboard Toko
                        </a>
                    @endif
                    @if(Auth::user()->role === 'buyer')
                        <a class="btn btn-lg btn-outline-secondary w-100 rounded-pill mb-2" href="{{ route('buyer.profile') }}">
                            <i class="ci-user fs-lg ms-n1 me-2"></i>
                            Akun Saya
                        </a>
                    @else
                        <a class="btn btn-lg btn-outline-secondary w-100 rounded-pill mb-2"
                            href="{{ route('seller.profile') }}">
                            <i class="ci-user fs-lg ms-n1 me-2"></i>
                            Akun Saya
                        </a>
                    @endif
                    <a class="btn btn-lg btn-outline-secondary w-100 rounded-pill" href="{{ route('logout') }}">
                        <i class="ci-sign-out fs-lg ms-n1 me-2"></i>
                        Logout
                    </a>
                </div>
            @else
                <a class="btn btn-lg btn-outline-secondary w-100 rounded-pill" href="{{ route('login') }}">
                    <i class="ci-user fs-lg ms-n1 me-2"></i>
                    Account
                </a>
            @endif
        </div>
    </nav>


    <!-- Navigation bar (Page header) -->
    <header class="navbar navbar-expand navbar-sticky sticky-top d-block bg-body z-fixed py-1 py-lg-0 py-xl-1 px-0"
        data-sticky-element>
        <div class="container justify-content-start py-2 py-lg-3">

            <!-- Offcanvas menu toggler (Hamburger) -->
            <button type="button" class="navbar-toggler d-block flex-shrink-0 me-3 me-sm-4" data-bs-toggle="offcanvas"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar brand (Logo) -->
            <a class="navbar-brand fs-2 p-0 pe-lg-2 pe-xxl-0 me-0 me-sm-3 me-md-4 me-xxl-5"
                href="{{ route('home') }}">{{ config('app.name') }}</a>

            <!-- Search bar visible on screens > 768px wide (md breakpoint) -->
            <div class="position-relative w-100 d-none d-md-block me-3 me-xl-4">
                <form action="{{ route('products.all') }}" method="GET">
                    <input type="search" name="search" class="form-control form-control-lg rounded-pill" 
                           placeholder="Cari produk..." aria-label="Search" value="{{ request('search') }}">
                    <button type="submit"
                        class="btn btn-icon btn-ghost fs-lg btn-secondary text-bo border-0 position-absolute top-0 end-0 rounded-circle mt-1 me-1"
                        aria-label="Search button">
                        <i class="ci-search"></i>
                    </button>
                </form>
            </div>

            <!-- Delivery options toggle visible on screens > 1200px wide (xl breakpoint) -->
            <div class="nav me-4 me-xxl-5 d-none d-xl-block">
                <a class="nav-link flex-column align-items-start animate-underline p-0" href="#deliveryOptions"
                    data-bs-toggle="offcanvas" aria-controls="deliveryOptions">
                    <div class="h6 fs-sm mb-0">Pengiriman</div>
                    <div class="d-flex align-items-center fs-sm fw-normal text-body">
                        <span class="animate-target text-nowrap">Atur alamat pengiriman</span>
                        <i class="ci-chevron-down fs-base ms-1"></i>
                    </div>
                </a>
            </div>

            <!-- Button group -->
            <div class="d-flex align-items-center gap-md-1 gap-lg-2 ms-auto">

                <!-- Theme switcher (light/dark/auto) -->
                <div class="dropdown">
                    <button type="button"
                        class="theme-switcher btn btn-icon btn-outline-secondary fs-lg border-0 rounded-circle animate-scale"
                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="Toggle theme (light)">
                        <span class="theme-icon-active d-flex animate-target">
                            <i class="ci-sun"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu" style="--cz-dropdown-min-width: 9rem">
                        <li>
                            <button type="button" class="dropdown-item active" data-bs-theme-value="light"
                                aria-pressed="true">
                                <span class="theme-icon d-flex fs-base me-2">
                                    <i class="ci-sun"></i>
                                </span>
                                <span class="theme-label">Light</span>
                                <i class="item-active-indicator ci-check ms-auto"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item" data-bs-theme-value="dark" aria-pressed="false">
                                <span class="theme-icon d-flex fs-base me-2">
                                    <i class="ci-moon"></i>
                                </span>
                                <span class="theme-label">Dark</span>
                                <i class="item-active-indicator ci-check ms-auto"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item" data-bs-theme-value="auto" aria-pressed="false">
                                <span class="theme-icon d-flex fs-base me-2">
                                    <i class="ci-auto"></i>
                                </span>
                                <span class="theme-label">Auto</span>
                                <i class="item-active-indicator ci-check ms-auto"></i>
                            </button>
                        </li>
                    </ul>
                </div>




                <!-- Chat Icon -->
                @if(Auth::check())
                    @php
                        $unreadChatCount = \App\Models\Message::where('receiver_id', Auth::id())
                            ->where('is_read', false)
                            ->count();
                    @endphp
                    <a class="btn btn-icon fs-lg btn-outline-secondary border-0 rounded-circle animate-scale position-relative"
                        href="{{ route('chat.index') }}" aria-label="Chat">
                        @if($unreadChatCount > 0)
                            <span class="position-absolute top-0 start-100 badge fs-xs text-bg-danger rounded-pill ms-n3 z-2"
                                style="--cz-badge-padding-y: .25em; --cz-badge-padding-x: .42em">
                                {{ $unreadChatCount }}
                            </span>
                        @endif
                        <i class="ci-chat animate-target"></i>
                    </a>
                @endif

                <!-- Search toggle button visible on screens < 768px wide (md breakpoint) -->
                <button type="button"
                    class="btn btn-icon fs-xl btn-outline-secondary border-0 rounded-circle animate-shake d-md-none"
                    data-bs-toggle="collapse" data-bs-target="#searchBar" aria-controls="searchBar"
                    aria-label="Toggle search bar">
                    <i class="ci-search animate-target"></i>
                </button>

                <!-- Delivery options button visible on screens < 1200px wide (xl breakpoint) -->
                <button type="button"
                    class="btn btn-icon fs-lg btn-outline-secondary border-0 rounded-circle animate-scale d-xl-none"
                    data-bs-toggle="offcanvas" data-bs-target="#deliveryOptions" aria-controls="deliveryOptions"
                    aria-label="Buka pilihan alamat pengiriman">
                    <i class="ci-map-pin animate-target"></i>
                </button>

                <!-- Account button visible on screens > 768px wide (md breakpoint) -->
                @if(Auth::check())
                    <div class="dropdown d-none d-md-inline-flex">
                        <button class="btn btn-icon fs-lg btn-outline-secondary border-0 rounded-circle animate-shake"
                            type="button" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ci-user animate-target"></i>
                            <span class="visually-hidden">Account</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            <li>
                                <h6 class="dropdown-header">{{ Auth::user()->name }}</h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @if(Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard.index') }}">
                                        <i class="ci-pie-chart fs-base opacity-75 me-2"></i>
                                        Dashboard Admin
                                    </a>
                                </li>
                            @elseif(Auth::user()->role == 'seller')
                                <li>
                                    <a class="dropdown-item" href="{{ route('seller.dashboard.index') }}">
                                        <i class="ci-package fs-base opacity-75 me-2"></i>
                                        Dashboard Toko
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->role === 'buyer')
                                <li>
                                    <a class="dropdown-item" href="{{ route('buyer.profile') }}">
                                        <i class="ci-user fs-base opacity-75 me-2"></i>
                                        Akun Saya
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('seller.profile') }}">
                                        <i class="ci-user fs-base opacity-75 me-2"></i>
                                        Akun Saya
                                    </a>
                                </li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}">
                                    <i class="ci-sign-out fs-base opacity-75 me-2"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-icon fs-lg btn-outline-secondary border-0 rounded-circle animate-shake d-none d-md-inline-flex"
                        href="{{ route('login') }}">
                        <i class="ci-user animate-target"></i>
                        <span class="visually-hidden">Account</span>
                    </a>
                @endif

                @php
                    $cartCount = 0;

                    if (Auth::check()) {
                        $cartCount = \DB::table('cart_items')
                            ->join('carts', 'carts.id', '=', 'cart_items.cart_id')
                            ->where('carts.user_id', Auth::id())
                            ->sum('cart_items.quantity');
                    }
                @endphp
                @if(Auth::check())
                    <button type="button"
                        class="btn btn-icon fs-xl btn-outline-secondary position-relative border-0 rounded-circle animate-scale"
                        data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" aria-controls="shoppingCart"
                        aria-label="Shopping cart">

                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 badge fs-xs text-bg-primary rounded-pill ms-n3 z-2"
                                style="--cz-badge-padding-y: .25em; --cz-badge-padding-x: .42em">
                                {{ $cartCount }}
                            </span>
                        @endif

                        <i class="ci-shopping-cart animate-target"></i>
                    </button>
                @endif
            </div>
        </div>

        <!-- Search collapse available on screens < 768px wide (md breakpoint) -->
        <div class="collapse d-md-none" id="searchBar">
            <div class="container pt-2 pb-3">
                <form action="{{ route('products.all') }}" method="GET">
                    <div class="position-relative">
                        <i class="ci-search position-absolute top-50 translate-middle-y d-flex fs-lg ms-3"></i>
                        <input type="search" name="search" class="form-control form-icon-start rounded-pill"
                            placeholder="Cari produk..." data-autofocus="collapse" value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>
    </header>