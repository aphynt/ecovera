<div class="modal fade" id="addAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.address.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Alamat Pengiriman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" name="recipient_name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="province" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kota / Kabupaten</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="district" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="postal_code" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address_detail" rows="3" class="form-control" required></textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_default" value="1">
                                <label class="form-check-label">
                                    Jadikan sebagai alamat utama
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Alamat</button>
                </div>

            </form>
        </div>
    </div>
</div>
