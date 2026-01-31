@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')


<div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Toko</h4>
                </div>
                <div class="d-flex align-items-center">
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.store.insert') }}" class="btn btn-success btn-sm">
                        <i data-feather="plus" class="icon-xs"></i>
                        Tambah
                    </a>
                    @else
                    <a href="{{ route('seller.store.insert') }}" class="btn btn-success btn-sm">
                        <i data-feather="plus" class="icon-xs"></i>
                        Tambah
                    </a>
                    @endif
                </div>
            </div>

            <div class="row">

                @forelse ($stores as $store)
                    <div class="col-xl-6 col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0 store-card">

                            <div class="card-body d-flex flex-column">

                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="fw-semibold mb-1">
                                            {{ $store->store_name }}
                                        </h5>
                                        <span class="text-muted fs-13">
                                            {{ $store->store_slug }}
                                        </span>
                                    </div>

                                    @if ($store->is_verified)
                                        <span class="badge bg-success">
                                            <i data-feather="check-circle" class="icon-xs me-1"></i>
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Belum Verifikasi
                                        </span>
                                    @endif
                                </div>

                                <!-- Description -->
                                <p class="text-muted fs-14 mb-3">
                                    {{ Str::limit($store->description ?? 'Tidak ada deskripsi.', 550) }}
                                </p>

                                <!-- Info -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-center text-muted fs-13 mb-1">
                                        <i data-feather="map-pin" class="icon-xs me-2"></i>
                                        {{ Str::limit($store->address ?? '-', 150) }}
                                    </div>

                                    <div class="d-flex align-items-center text-muted fs-13">
                                        <i data-feather="star" class="icon-xs me-2 text-warning"></i>
                                        Rating: {{ $store->rating ?? '0.0' }}
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="mt-auto d-flex gap-2">
                                    @if (!$store->is_verified)
                                        @if (Auth::user()->role == 'admin')
                                        <button class="btn btn-success btn-sm w-100"
                                            onclick="verifyStore('{{ $store->uuid }}', '{{ $store->store_name }}')">
                                            <i data-feather="check-circle" class="icon-xs me-1"></i>
                                            Verifikasi
                                        </button>
                                        @endif

                                    @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.store.edit', $store->uuid) }}"
                                        class="btn btn-sm btn-primary w-100">
                                        <i data-feather="edit" class="icon-xs me-1"></i>
                                        Edit
                                    </a>
                                    @else
                                    <a href="{{ route('seller.store.edit', $store->uuid) }}"
                                        class="btn btn-sm btn-primary w-100">
                                        <i data-feather="edit" class="icon-xs me-1"></i>
                                        Edit
                                    </a>
                                    @endif
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center">
                            <i data-feather="shopping-bag" class="mb-2"></i>
                            <p class="mb-0">Belum ada data toko.</p>
                        </div>
                    </div>
                @endforelse

            </div>



        </div> <!-- container-fluid -->
    </div>
<form id="verify-form" method="POST" style="display: none;">
    @csrf
    @method('PUT')
</form>
<script>
function verifyStore(uuid, storeName) {
    const verifyRoute = "{{ route('admin.store.verify', ':uuid') }}";
    Swal.fire({
        title: 'Verifikasi Toko?',
        html: `<strong>${storeName}</strong><br>akan ditandai sebagai <b>Terverifikasi</b>.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Verifikasi',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('verify-form');
            form.action = verifyRoute.replace(':uuid', uuid);
            form.submit();
        }
    });
}
</script>
@include('admin.layout.footer')
