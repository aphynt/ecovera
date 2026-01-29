@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="py-3 d-flex align-items-center justify-content-between">
            <h4 class="fs-18 fw-semibold m-0">Edit Toko</h4>
            <a href="{{ route('admin.store') }}" class="btn btn-light btn-sm">
                <i data-feather="arrow-left" class="icon-xs"></i>
                Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-xl-12">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <form action="{{ route('admin.store.update', $store->uuid) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">

                                <!-- Nama Toko -->
                                <div class="col-md-12">
                                    <label class="form-label">Nama Toko</label>
                                    <input type="text" name="store_name"
                                        class="form-control"
                                        placeholder="Masukkan nama toko"
                                        value="{{ old('store_name', $store->store_name) }}" required>
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" rows="3"
                                        class="form-control"
                                        placeholder="Deskripsi singkat tentang toko">{{ old('description', $store->description) }}</textarea>
                                </div>

                                <!-- Alamat -->
                                <div class="col-md-12">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="address" rows="2"
                                        class="form-control"
                                        placeholder="Alamat lengkap toko">{{ old('address', $store->address) }}</textarea>
                                </div>

                            </div>

                            <!-- Action -->
                            <div class="d-flex justify-content-end mt-4 gap-2">
                                <a href="{{ route('admin.store') }}" class="btn btn-light">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i data-feather="save" class="icon-xs me-1"></i>
                                    Perbarui Toko
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div><!-- container-fluid -->
</div>

@include('admin.layout.footer')
