<div class="modal fade" id="insertCategory" tabindex="-1" aria-labelledby="insertCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="insertCategoryLabel">Kategori Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.category.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="categoryName" placeholder="Masukkan Nama" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Gambar</label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="image" id="imageURL" required>
                            <label class="input-group-text" for="imageURL">Upload</label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
