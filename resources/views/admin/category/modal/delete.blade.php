<div class="modal fade" id="deleteCategory{{ $ct->id }}" tabindex="-1"
     aria-labelledby="deleteCategoryLabel{{ $ct->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryLabel{{ $ct->id }}">
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>
                    Apakah Anda yakin ingin menghapus kategori
                    <strong>{{ $ct->name }}</strong>?
                </p>
                <p class="text-danger mb-0">
                    Data yang dihapus tidak dapat dikembalikan.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <form action="{{ route('admin.category.destroy', $ct->id) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
