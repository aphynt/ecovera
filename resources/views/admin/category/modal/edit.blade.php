<div class="modal fade" id="editCategory{{ $ct->id }}" tabindex="-1"
     aria-labelledby="editCategoryLabel{{ $ct->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Kategori Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.category.update', $ct->id) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <!-- Nama -->
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text"
                               class="form-control"
                               name="name"
                               value="{{ $ct->name }}"
                               required>
                    </div>

                    <!-- Gambar -->
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>

                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$ct->image_url) }}"
                                 width="80" class="rounded">
                        </div>

                        <div class="input-group">
                            <input type="file" class="form-control" name="image">
                            <label class="input-group-text">Upload</label>
                        </div>

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti gambar
                        </small>
                    </div>

                    <!-- STATUS AKTIF -->
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               name="is_active"
                               value="1"
                               id="isActive{{ $ct->id }}"
                               {{ $ct->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive{{ $ct->id }}">
                            Aktif
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
