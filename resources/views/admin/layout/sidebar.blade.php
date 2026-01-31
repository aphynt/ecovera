<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="javascript:void(0);" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('admin/dist') }}/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('admin/dist') }}/assets/images/logo-light.png" alt="" height="24">
                    </span>
                </a>
                <a href="javascript:void(0);" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('admin/dist') }}/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('logo') }}/cover.png" alt="" height="40">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Home</li>
                @if (Auth::user()->role == 'admin')
                <li>
                    <a href="{{ route('admin.dashboard.index') }}" class="tp-link">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ route('seller.dashboard.index') }}" class="tp-link">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                @endif

                <li class="menu-title mt-2">Store</li>

                @if (Auth::user()->role == 'admin')
                <li>
                    <a href="{{ route('admin.store') }}" class="tp-link">
                        <i data-feather="shopping-cart"></i>
                        <span> Toko </span>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ route('seller.store') }}" class="tp-link">
                        <i data-feather="shopping-cart"></i>
                        <span> Toko </span>
                    </a>
                </li>
                @endif


                <li class="menu-title mt-2">Produk</li>

                @if (Auth::user()->role == 'admin')
                <li>
                    <a href="{{ route('admin.category') }}" class="tp-link">
                        <i data-feather="tag"></i>
                        <span> Kategori </span>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ route('seller.category') }}" class="tp-link">
                        <i data-feather="tag"></i>
                        <span> Kategori </span>
                    </a>
                </li>
                @endif

                @if (Auth::user()->role == 'admin')
                <li>
                    <a href="{{ route('admin.product') }}" class="tp-link">
                        <i data-feather="box"></i>
                        <span> Produk </span>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ route('seller.product') }}" class="tp-link">
                        <i data-feather="box"></i>
                        <span> Produk </span>
                    </a>
                </li>
                @endif

                <li class="menu-title mt-2">Transaksi</li>

                @if (Auth::user()->role == 'admin')
                {{-- Admin: Monitoring semua return untuk proses refund --}}
                <li>
                    <a href="{{ route('admin.returns.index') }}" class="tp-link">
                        <i data-feather="refresh-cw"></i>
                        <span> Monitoring Pengembalian </span>
                        @php
                            $pendingRefunds = \App\Models\ReturnRequest::where('return_status', 'item_received')->count();
                        @endphp
                        @if($pendingRefunds > 0)
                        <span class="badge bg-danger ms-1">{{ $pendingRefunds }}</span>
                        @endif
                    </a>
                </li>
                @endif

                @if (Auth::user()->role == 'seller')
                {{-- Seller: Kelola return untuk toko mereka --}}
                <li>
                    <a href="{{ route('seller.returns.index') }}" class="tp-link">
                        <i data-feather="refresh-cw"></i>
                        <span> Pengembalian Barang </span>
                        @php
                            $sellerPendingReturns = \App\Models\ReturnRequest::where('seller_id', Auth::id())
                                ->whereIn('return_status', ['requested', 'item_sent_back'])
                                ->count();
                        @endphp
                        @if($sellerPendingReturns > 0)
                        <span class="badge bg-danger ms-1">{{ $sellerPendingReturns }}</span>
                        @endif
                    </a>
                </li>
                @endif

                <li class="menu-title mt-2">Authentication</li>

                @if (Auth::user()->role == 'admin')
                <li>
                    <a href="{{ route('admin.users') }}" class="tp-link">
                        <i data-feather="users"></i>
                        <span> Users </span>
                    </a>
                </li>
                @endif

                @if (Auth::user()->role == 'admin')
                <li>
                    <a href="{{ route('admin.profile') }}" class="tp-link">
                        <i data-feather="user"></i>
                        <span> Profile </span>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ route('seller.profile') }}" class="tp-link">
                        <i data-feather="user"></i>
                        <span> Profile </span>
                    </a>
                </li>
                @endif

                <li>
                    <a href="{{ route('logout') }}" class="tp-link">
                        <i data-feather="log-out"></i>
                        <span> Logout </span>
                    </a>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
<div class="content-page">
