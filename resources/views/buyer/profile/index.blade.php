@include('home.layout.head')
@include('home.layout.header')

<!-- Page content -->
<main class="content-wrapper">
    
    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
        </ol>
    </nav>

    <section class="container pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
        <div class="row">
            
            <!-- Sidebar -->
            @include('buyer.profile.sidebar')

            <!-- Main Content -->
            <div class="col-lg-9">
                @include('alert')
                
                <h2 class="h3 mb-4">Profil Saya</h2>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="{{ Auth::user()->avatar
                                        ? asset('storage/'.Auth::user()->avatar)
                                        : asset('logo/logo.png') }}"
                                     class="rounded-circle mb-3"
                                     style="width: 150px; height: 150px; object-fit: cover;"
                                     alt="{{ Auth::user()->name }}">

                                <p class="text-muted mb-3">Klik untuk ganti foto profil</p>

                                <form action="{{ route('buyer.profile.avatar') }}"
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
                                        <i class="ci-upload me-2"></i>
                                        Ubah Foto Profil
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('buyer.profile.update') }}"
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
                                        <label class="form-label">Nomor Telepon</label>
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
                                    </div>

                                    <button type="submit" class="btn btn-success">
                                        <i class="ci-check me-2"></i>
                                        Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

@include('home.layout.footer')
