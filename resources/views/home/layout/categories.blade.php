@php
    use App\Models\CategoryProduct;

    $data['category'] = CategoryProduct::where('is_active', true)->get();
@endphp

<section class="border-top">
    <div class="container py-lg-1">
        <div class="overflow-auto" data-simplebar>
            <div class="nav flex-nowrap justify-content-between gap-4 py-2">

                <!-- Lihat Semua Link -->
                <a class="nav-link align-items-center animate-underline gap-2 p-0" href="{{ route('products.all') }}">
                    <span class="d-flex align-items-center justify-content-center bg-body-tertiary rounded-circle"
                          style="width: 40px; height: 40px">
                        <i class="ci-grid fs-lg"></i>
                    </span>
                    <span class="d-block animate-target fw-semibold text-nowrap ms-1">
                        Lihat Semua
                    </span>
                </a>

                @foreach ($data['category'] as $category)
                    <a class="nav-link align-items-center animate-underline gap-2 p-0" href="{{ route('products.category', $category->slug) }}">
                        <span class="d-flex align-items-center justify-content-center bg-body-tertiary rounded-circle"
                              style="width: 40px; height: 40px">
                            <img src="{{ asset('storage/'.$category->image_url) }}"
                                 alt="{{ $category->name }}"
                                 style="width: 24px; height: 24px; object-fit: contain">
                        </span>
                        <span class="d-block animate-target fw-semibold text-nowrap ms-1">
                            {{ $category->name }}
                        </span>
                    </a>
                @endforeach

            </div>
        </div>
    </div>
</section>
