@include('home.layout.head')
@include('home.layout.header')

<!-- Page content -->
<main class="content-wrapper">

    <!-- Breadcrumb -->
    <nav class="container pt-3 my-3 my-md-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('buyer.profile') }}">Profil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Alamat</li>
        </ol>
    </nav>

    <section class="container pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
        <div class="row">

            <!-- Sidebar -->
            @include('buyer.profile.sidebar')

            <!-- Main Content -->
            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ci-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ci-close-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 mb-0">Alamat Saya</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        <i class="ci-plus me-2"></i>
                        Tambah Alamat Baru
                    </button>
                </div>

                <!-- Empty State -->
                @if($data['addresses']->isEmpty())
                    <div class="text-center py-5">
                        <i class="ci-location fs-1 text-muted mb-3 d-block"></i>
                        <h5 class="mb-2">Belum ada alamat tersimpan</h5>
                        <p class="text-muted mb-4">Tambahkan alamat pengiriman untuk mempermudah checkout</p>
                    </div>
                @else
                            <!-- Address List -->
                            <div class="row">
                                @foreach($data['addresses'] as $address)
                                            <div class="col-md-6 mb-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <strong>{{ $address->label ?? 'Alamat' }}</strong>
                                                            @if($address->is_default)
                                                                <span class="badge bg-success">Utama</span>
                                                            @endif
                                                        </div>
                                                        <p class="mb-1"><strong>{{ $address->recipient_name }}</strong></p>
                                                        <p class="mb-1 text-muted">{{ $address->phone }}</p>
                                                        <p class="text-muted mb-2">
                                                            {{ $address->address_detail }}<br>
                                                            {{ $address->district }}, {{ $address->city }}<br>
                                                            {{ $address->province }} {{ $address->postal_code }}
                                                        </p>
                                                        <div class="mt-3">
                                                            <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal"
                                                                data-bs-target="#editAddressModal{{ $address->id }}">
                                                                <i class="ci-edit me-1"></i>Ubah
                                                            </button>
                                                            @if(!$address->is_default)
                                                                <form action="{{ route('buyer.address.setDefault', $address->uuid) }}" method="POST"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="btn btn-sm btn-outline-success me-2">
                                                                        <i class="ci-star me-1"></i>Jadikan Utama
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('buyer.address.delete', $address->uuid) }}" method="POST"
                                                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus alamat ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                        <i class="ci-trash me-1"></i>Hapus
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Address Modal -->
                                            <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Alamat</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('buyer.address.update', $address->uuid) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label">Nama Label (Rumah, Kantor, dll)</label>
                                                                        <input type="text" name="label" class="form-control" value="{{ $address->label }}"
                                                                            placeholder="Rumah">
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label">Nama Penerima</label>
                                                                        <input type="text" name="recipient_name" class="form-control"
                                                                            value="{{ $address->recipient_name }}" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label">Nomor Telepon</label>
                                                                        <input type="tel" name="phone" class="form-control" value="{{ $address->phone }}"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alamat Lengkap</label>
                                                                    <textarea name="address_detail" class="form-control" rows="3"
                                                                        required>{{ $address->address_detail }}</textarea>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label">Provinsi</label>
                                                                        <input type="text" name="province" class="form-control"
                                                                            value="{{ $address->province }}" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label">Kota/Kabupaten</label>
                                                                        <input type="text" name="city" class="form-control" value="{{ $address->city }}"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label">Kecamatan</label>
                                                                        <input type="text" name="district" class="form-control"
                                                                            value="{{ $address->district }}" required>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label">Kode Pos</label>
                                                                        <input type="text" name="postal_code" class="form-control"
                                                                            value="{{ $address->postal_code }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="is_default"
                                                                        id="setPrimary{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="setPrimary{{ $address->id }}">
                                                                        Jadikan alamat utama
                                                                    </label>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                @endforeach
                            </div>
                @endif

        </div>
        </div>
    </section>

    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Alamat Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('buyer.address.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Label (Rumah, Kantor, dll)</label>
                                <input type="text" name="label" class="form-control" placeholder="Rumah">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Penerima</label>
                                <input type="text" name="recipient_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address_detail" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="text" name="province" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kota/Kabupaten</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" name="district" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" name="postal_code" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_default" id="setPrimary">
                            <label class="form-check-label" for="setPrimary">
                                Jadikan alamat utama
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Alamat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>

@include('home.layout.footer')