@if (session('success'))
    <div class="alert alert-success d-flex alert-dismissible fade show" role="alert">
        <i class="ci-check-circle fs-lg mt-1 me-2"></i>
        <div>
            <span class="fw-bold">Berhasil!</span> {{ session('success') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info d-flex alert-dismissible fade show border-info bg-info bg-opacity-10 text-info"
        role="alert">
        <div class="d-flex align-items-center">
            <i class="ci-info fs-lg text-info me-3"></i>
            <div>
                <h6 class="alert-heading fw-bold mb-1">Informasi</h6>
                <p class="mb-0 fs-sm">{{ session('info') }}</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning d-flex alert-dismissible fade show" role="alert">
        <i class="ci-alert-triangle fs-lg mt-1 me-2"></i>
        <div>
            <span class="fw-bold">Perhatian!</span> {{ session('warning') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger d-flex alert-dismissible fade show" role="alert">
        <i class="ci-close-circle fs-lg mt-1 me-2"></i>
        <div>
            <span class="fw-bold">Error!</span> {{ session('error') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Validation Errors General -->
@if ($errors->any())
    <div class="alert alert-danger d-flex alert-dismissible fade show" role="alert">
        <i class="ci-close-circle fs-lg mt-1 me-2"></i>
        <div>
            <span class="fw-bold">Terjadi Kesalahan!</span>
            <ul class="mb-0 ps-3 mt-1 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif