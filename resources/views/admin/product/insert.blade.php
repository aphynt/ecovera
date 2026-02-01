@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="py-3 d-flex align-items-center justify-content-between">
            <h4 class="fs-18 fw-semibold m-0">Tambah Produk</h4>
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.product') }}" class="btn btn-light btn-sm">
                <i data-feather="arrow-left" class="icon-xs"></i>
                Kembali
            </a>
            @else
            <a href="{{ route('seller.product') }}" class="btn btn-light btn-sm">
                <i data-feather="arrow-left" class="icon-xs"></i>
                Kembali
            </a>
            @endif
        </div>

        <div class="row">
            <div class="col-xl-12">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        @if(Auth::user()->role === 'admin')
                        <form action="{{ route('admin.product.create') }}"
                        @else
                        <form action="{{ route('seller.product.create') }}"
                        @endif
                            method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">

                                <!-- Nama Produk -->
                                <div class="col-md-6">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <!-- Store -->
                                <div class="col-md-6">
                                    <label class="form-label">Toko</label>
                                    <select name="store_id" class="form-select" required>
                                        <option value="">-- Pilih Toko --</option>
                                        @foreach ($data['stores'] as $store)
                                            <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Kategori -->
                                <div class="col-md-6">
                                    <label class="form-label">Kategori</label>
                                    <select name="category_id" class="form-select" required>
                                        @foreach ($data['categories'] as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Harga -->
                                <div class="col-md-6">
                                    <label class="form-label">Harga</label>
                                    <input type="number" name="price" class="form-control" required>
                                </div>

                                <!-- Stok -->
                                <div class="col-md-6">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stock" class="form-control" required>
                                </div>

                                <!-- Berat -->
                                <div class="col-md-6">
                                    <label class="form-label">Berat (gram)</label>
                                    <input type="number" name="weight" class="form-control">
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" rows="15" class="form-control"></textarea>
                                </div>

                                <!-- Upload Gambar -->
                                <div class="col-md-12">
                                    <label class="form-label">Gambar Produk</label>
                                    <input type="file" name="images[]" id="imagesInput"
                                        class="form-control" accept="image/*" multiple>
                                </div>

                                <!-- Pilih Gambar Utama -->
                                <div class="col-md-6">
                                    <label class="form-label">Gambar Utama</label>
                                    <select name="primary_image_index" class="form-select">
                                        <option value="0">Gambar pertama</option>
                                    </select>
                                </div>

                                <!-- Upload Video -->
                                <div class="col-md-6">
                                    <label class="form-label">Video Produk (Opsional)</label>
                                    <input type="file" name="video" id="videoInput"
                                        class="form-control" accept="video/mp4,video/mov">
                                </div>

                                <!-- Preview -->
                                <div class="col-md-12">
                                    <div id="imagePreview" class="row g-2 mt-2"></div>
                                </div>

                                <div class="col-md-12">
                                    <div id="videoPreview" class="mt-3"></div>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    Simpan Produk
                                </button>
                            </div>
                        </form>



                    </div>
                </div>

            </div>
        </div>

    </div><!-- container-fluid -->
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const imagesInput = document.getElementById('imagesInput');
    const imagePreview = document.getElementById('imagePreview');
    const primarySelect = document.querySelector('[name="primary_image_index"]');

    imagesInput.addEventListener('change', function () {

        imagePreview.innerHTML = '';
        primarySelect.innerHTML = '';

        Array.from(this.files).forEach((file, index) => {

            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = e => {

                imagePreview.innerHTML += `
                    <div class="col-md-3">
                        <div class="card border shadow-sm">
                            <img src="${e.target.result}"
                                 style="object-fit:cover">
                            <div class="card-body text-center p-1">
                                <small>Gambar ${index + 1}</small>
                            </div>
                        </div>
                    </div>
                `;
            };

            reader.readAsDataURL(file);

            primarySelect.innerHTML += `
                <option value="${index}">Gambar ${index + 1}</option>
            `;
        });
    });

    const videoInput = document.getElementById('videoInput');
    const videoPreview = document.getElementById('videoPreview');

    videoInput.addEventListener('change', function () {
        videoPreview.innerHTML = '';
        if (!this.files[0]) return;

        videoPreview.innerHTML = `
            <video controls width="100%" style="max-height:300px">
                <source src="${URL.createObjectURL(this.files[0])}">
            </video>
        `;
    });

});
</script>


@include('admin.layout.footer')
