@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-center justify-content-between">
            <h4 class="fs-18 fw-semibold m-0">Edit Produk</h4>
            <a href="{{ route('admin.product') }}" class="btn btn-light btn-sm">
                <i data-feather="arrow-left" class="icon-xs"></i>
                Kembali
            </a>
        </div>

        @if ($data['isReadOnly'])
            <div class="alert alert-info">
                Produk ini sudah diverifikasi dan hanya dapat dilihat (read-only).
            </div>
        @endif

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <form id="form-update-product"
                              action="{{ route('admin.product.update', $data['product']->uuid) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="name" class="form-control"
                                           value="{{ $data['product']->name }}"
                                           {{ $data['isReadOnly'] ? 'readonly' : '' }}>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Toko</label>
                                    <select name="store_id" class="form-select"
                                            {{ $data['isReadOnly'] ? 'disabled' : '' }}>
                                        @foreach ($data['stores'] as $store)
                                            <option value="{{ $store->id }}"
                                                {{ $data['product']->store_id == $store->id ? 'selected' : '' }}>
                                                {{ $store->store_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Kategori</label>
                                    <select name="category_id" class="form-select"
                                            {{ $data['isReadOnly'] ? 'disabled' : '' }}>
                                        @foreach ($data['categories'] as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $data['product']->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Harga</label>
                                    <input type="number" name="price" class="form-control"
                                           value="{{ $data['product']->price }}"
                                           {{ $data['isReadOnly'] ? 'readonly' : '' }}>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stock" class="form-control"
                                           value="{{ $data['product']->stock }}"
                                           {{ $data['isReadOnly'] ? 'readonly' : '' }}>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Berat (gram)</label>
                                    <input type="number" name="weight" class="form-control"
                                           value="{{ $data['product']->weight }}"
                                           {{ $data['isReadOnly'] ? 'readonly' : '' }}>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" rows="15"
                                              class="form-control"
                                              {{ $data['isReadOnly'] ? 'readonly' : '' }}>{{ $data['product']->description }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Gambar Saat Ini</label>
                                    <div class="row g-2">
                                        @foreach ($data['productImages'] as $img)
                                            <div class="col-md-3">
                                                <div class="card border {{ $img->is_primary ? 'border-primary' : '' }}">
                                                    <img src="{{ asset('storage/'.$img->image_url) }}"
                                                        class="img-fluid"
                                                        style="object-fit:cover">

                                                    @if ($img->is_primary)
                                                        <div class="badge bg-primary position-absolute top-0 end-0 m-1">
                                                            Utama
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Tambah Gambar Baru</label>
                                    <input type="file" name="images[]" class="form-control"
                                           multiple
                                           {{ $data['isReadOnly'] ? 'disabled' : '' }}>
                                </div>

                                <!-- Video -->
                                <div class="col-md-6">
                                    <label class="form-label">Video Produk</label>
                                    <input type="file"
                                        name="video"
                                        id="videoInput"
                                        class="form-control"
                                        accept="video/mp4,video/webm,video/ogg"
                                        {{ $data['isReadOnly'] ? 'disabled' : '' }}>
                                </div>

                            </div>
                        </form>
                        <div class="d-flex justify-content-between align-items-center mt-4">

                            <div>
                                @if ($data['product']->status === 'active')
                                    <span class="badge bg-success">Sudah Diverifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Diverifikasi</span>
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                @if ($data['product']->status === 'inactive' && Auth::user()->role == 'admin')
                                    <form id="verify-form"
                                          action="{{ route('admin.product.verify', $data['product']->uuid) }}"
                                          method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <button type="button"
                                                class="btn btn-success"
                                                id="btn-verify-product">
                                            Verifikasi Produk
                                        </button>
                                    </form>
                                @endif

                                @if (!$data['isReadOnly'])
                                    <button type="submit"
                                            form="form-update-product"
                                            class="btn btn-primary">
                                        Update Produk
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const verifyBtn = document.getElementById('btn-verify-product');
    const verifyForm = document.getElementById('verify-form');

    if (!verifyBtn || !verifyForm) return;

    verifyBtn.addEventListener('click', function () {
        Swal.fire({
            title: 'Verifikasi Produk?',
            text: 'Produk yang sudah diverifikasi tidak dapat diedit kembali.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Verifikasi',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                verifyForm.submit();
            }
        });
    });

});
</script>

@include('admin.layout.footer')
