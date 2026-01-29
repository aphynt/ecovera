@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Kategori Produk</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card overflow-hidden">

                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            @if (Auth::user()->role === 'admin')
                                <button type="button"
                                        class="btn btn-success btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#insertCategory">
                                    <i data-feather="plus" class="icon-xs"></i>
                                    Tambah
                                </button>
                                @include('admin.category.modal.insert')
                            @endif
                        </div>
                    </div>

                    <div class="card-body mt-0">
                        <div class="table-responsive table-card mt-0">
                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                <thead class="text-muted table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category as $ct)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ asset('storage/'.$ct->image_url) }}"
                                                     class="avatar avatar-sm rounded-circle me-3">
                                                {{ $ct->name }}
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary fw-semibold">
                                                    {{ $ct->slug }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($ct->is_active)
                                                    <span class="badge bg-success-subtle text-success fw-semibold">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger fw-semibold">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (Auth::user()->role === 'admin')
                                                    <a href="javascript:void(0)"
                                                       class="me-1"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#editCategory{{ $ct->id }}">
                                                        <i class="mdi mdi-pencil-outline fs-16 text-muted"></i>
                                                    </a>
                                                    <a href="javascript:void(0)"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#deleteCategory{{ $ct->id }}">
                                                        <i class="mdi mdi-delete fs-16 text-muted"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>

                                        @if (Auth::user()->role === 'admin')
                                            @include('admin.category.modal.edit')
                                            @include('admin.category.modal.delete')
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.layout.footer')
