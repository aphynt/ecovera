@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">
    <div class="container-fluid">

        <div class="py-3">
            <h4 class="fs-18 fw-semibold m-0">Profil Seller</h4>
        </div>
        @include('alert')

        <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">

                        <img src="{{ Auth::user()->avatar
                                ? asset('storage/'.Auth::user()->avatar)
                                : asset('logo/logo.png') }}"
                             class="rounded-circle avatar-xl img-thumbnail mb-3">

                        <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                        <p class="text-muted mb-3">{{ Auth::user()->email }}</p>

                        <form action="{{ route('seller.profile.avatar') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <input type="file"
                                   name="avatar"
                                   class="form-control mb-3"
                                   accept="image/*"
                                   required>

                            <button type="submit" class="btn btn-primary w-100">
                                <i data-feather="camera" class="icon-xs me-1"></i>
                                Update Avatar
                            </button>
                        </form>

                    </div>
                </div>

                <!-- Info Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Informasi Akun</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Role</span>
                            <span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Status</span>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Bergabung</span>
                            <span>{{ Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Profil</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('seller.profile.update') }}"
                              method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ Auth::user()->name }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ Auth::user()->email }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ Auth::user()->phone }}"
                                       placeholder="Masukkan nomor telepon">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Kosongkan jika tidak ingin mengubah password">
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i data-feather="save" class="icon-xs me-1"></i>
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('seller.dashboard.index') }}" class="btn btn-secondary">
                                    <i data-feather="arrow-left" class="icon-xs me-1"></i>
                                    Kembali
                                </a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@include('admin.layout.footer')
