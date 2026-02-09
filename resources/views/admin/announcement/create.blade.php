@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Buat Pengumuman Baru</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success text-white" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('admin.announcement.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subjek</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Kirim Pengumuman</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.layout.footer')