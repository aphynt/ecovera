@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-components">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Pengaduan</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Subjek</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($complaints as $complaint)
                                        <tr>
                                            <td>{{ $complaint->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                @if($complaint->user)
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-2">
                                                            <h6 class="mb-0">{{ $complaint->user->name }}</h6>
                                                            <small class="text-muted">{{ $complaint->user->email }}</small>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-2">
                                                            <h6 class="mb-0">{{ $complaint->name ?? 'Guest' }}</h6>
                                                            <small class="text-muted">{{ $complaint->email }}</small>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($complaint->subject, 30) }}</td>
                                            <td>
                                                @if($complaint->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($complaint->status == 'processed')
                                                    <span class="badge bg-info">Diproses</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#complaintModal{{ $complaint->id }}">
                                                    Lihat Detail
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Detail -->
                                        <div class="modal fade" id="complaintModal{{ $complaint->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detail Pengaduan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="fw-bold">Pengirim:</label>
                                                            <p>{{ $complaint->name }} ({{ $complaint->email }})</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="fw-bold">Subjek:</label>
                                                            <p>{{ $complaint->subject }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="fw-bold">Pesan:</label>
                                                            <p class="bg-light p-3 rounded">{{ $complaint->message }}</p>
                                                        </div>
                                                        <hr>
                                                        <form
                                                            action="{{ route('admin.complaints.update', $complaint->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label fw-bold">Update
                                                                    Status:</label>
                                                                <select name="status" class="form-select">
                                                                    <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="processed" {{ $complaint->status == 'processed' ? 'selected' : '' }}>Diproses</option>
                                                                    <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>
                                                                        Selesai</option>
                                                                </select>
                                                            </div>
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Simpan
                                                                    Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">Belum ada pengaduan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $complaints->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.layout.footer')