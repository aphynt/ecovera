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
                <li>
                    <a href="{{ route('admin.dashboard.index') }}" class="tp-link">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Store</li>

                <li>
                    <a href="{{ route('admin.store') }}" class="tp-link">
                        <i data-feather="shopping-cart"></i>
                        <span> Toko </span>
                    </a>
                </li>


                <li class="menu-title mt-2">Produk</li>

                <li>
                    <a href="{{ route('admin.category') }}" class="tp-link">
                        <i data-feather="tag"></i>
                        <span> Kategori </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.product') }}" class="tp-link">
                        <i data-feather="box"></i>
                        <span> Produk </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Authentication</li>

                @if (Auth::user()->role == 'admin')
                <li>
                    <a href="{{ route('admin.users') }}" class="tp-link">
                        <i data-feather="users"></i>
                        <span> Users </span>
                    </a>
                </li>
                @endif

                <li>
                    <a href="{{ route('admin.profile') }}" class="tp-link">
                        <i data-feather="user"></i>
                        <span> Profile </span>
                    </a>
                </li>

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
