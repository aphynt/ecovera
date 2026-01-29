@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')


<div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Produk</h4>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-12">
                    <div class="card overflow-hidden">

                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('admin.product.insert') }}" class="btn btn-success btn-sm">
                                    <i data-feather="plus" class="icon-xs"></i>
                                    Tambah
                                </a>
                            </div>
                        </div>

                        <div class="card-body mt-0">
                            <div class="table-responsive table-card mt-0">
                                <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                    <thead class="text-muted table-light">
                                        <tr>
                                            <th scope="col" class="cursor-pointer">#</th>
                                            <th scope="col" class="cursor-pointer">Produk</th>
                                            <th scope="col" class="cursor-pointer">Toko</th>
                                            <th scope="col" class="cursor-pointer">Kategori</th>
                                            <th scope="col" class="cursor-pointer">Harga</th>
                                            <th scope="col" class="cursor-pointer">Stok</th>
                                            <th scope="col" class="cursor-pointer">Berat</th>
                                            <th scope="col" class="cursor-pointer">Status</th>
                                            <th  scope="col" class="cursor-pointer" width="150">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($data['products'] as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <!-- Produk -->
                                            <td>
                                                <div class="fw-semibold">{{ $product->name }}</div>
                                                <small class="text-muted">{{ $product->slug }}</small>
                                            </td>

                                            <!-- Store -->
                                            <td>
                                                {{ $product->store_name ?? '-' }}
                                            </td>

                                            <!-- Category -->
                                            <td>
                                                {{ $product->category_name ?? '-' }}
                                            </td>

                                            <!-- Price -->
                                            <td>
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </td>

                                            <!-- Stock -->
                                            <td>
                                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>

                                            <!-- Weight -->
                                            <td>
                                                {{ $product->weight }} gr
                                            </td>

                                            <!-- Status -->
                                            <td>
                                                @if ($product->status == 'active')
                                                <span class="badge bg-primary }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                                @else
                                                <span class="badge bg-warning }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>

                                                @endif
                                            </td>

                                            <!-- Action -->
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('admin.product.edit', $product->uuid) }}"
                                                    class="btn btn-sm bg-primary-subtle btn-edit-user">
                                                        <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                                    </a>

                                                    @if (
                                                        $product->status === 'inactive' &&
                                                        (
                                                            Auth::user()->role === 'admin' ||
                                                            $product->user_id === Auth::id()
                                                        )
                                                    )
                                                        <button class="btn btn-sm bg-danger-subtle btn-toggle-user"
                                                                onclick="deleteProduct('{{ $product->uuid }}', '{{ $product->name }}')">
                                                            <i class="mdi mdi-trash-can fs-14 text-danger"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
                                                Belum ada data produk.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
<form id="delete-product-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
<script>
    const deleteRoute = "{{ route('admin.product.destroy', ':uuid') }}";

    function deleteProduct(uuid, productName) {
        Swal.fire({
            title: 'Hapus Produk?',
            html: `<strong>${productName}</strong><br>Data ini tidak dapat dikembalikan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-product-form');
                form.action = deleteRoute.replace(':uuid', uuid);
                form.submit();
            }
        });
    }
</script>
@include('admin.layout.footer')
