<div class="col-lg-3 mb-4 mb-lg-0">
    <div class="card">
        <div class="card-body p-0">
            <!-- User Info -->
            <div class="p-4 border-bottom">
                <div class="d-flex align-items-center">
                    <img src="{{ Auth::user()->avatar 
                            ? asset('storage/'.Auth::user()->avatar) 
                            : asset('logo/logo.png') }}"
                         class="rounded-circle me-3"
                         style="width: 60px; height: 60px; object-fit: cover;"
                         alt="{{ Auth::user()->name }}">
                    <div>
                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </div>
                </div>
            </div>

            <!-- Menu -->
            <div class="list-group list-group-flush">
                <a href="{{ route('buyer.profile') }}" 
                   class="list-group-item list-group-item-action {{ request()->routeIs('buyer.profile') ? 'active' : '' }}">
                    <i class="ci-user me-2"></i>
                    Profil Saya
                </a>
                <a href="{{ route('buyer.my.address') }}" 
                   class="list-group-item list-group-item-action {{ request()->routeIs('buyer.my.address') ? 'active' : '' }}">
                    <i class="ci-location me-2"></i>
                    Alamat
                </a>
                <a href="{{ route('buyer.my.orders') }}" 
                   class="list-group-item list-group-item-action {{ request()->routeIs('buyer.my.orders') ? 'active' : '' }}">
                    <i class="ci-package me-2"></i>
                    Pesanan Saya
                </a>
                <a href="{{ route('buyer.my.returns') }}" 
                   class="list-group-item list-group-item-action {{ request()->routeIs('buyer.my.returns') ? 'active' : '' }}">
                    <i class="ci-undo me-2"></i>
                    Pengembalian
                </a>
                <a href="{{ route('logout') }}" 
                   class="list-group-item list-group-item-action text-danger">
                    <i class="ci-sign-out me-2"></i>
                    Logout
                </a>
            </div>
        </div>
    </div>
</div>
