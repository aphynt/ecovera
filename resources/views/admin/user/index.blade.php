@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">
    <div class="container-fluid">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Daftar User</h4>
            </div>
        </div>
        @include('alert')

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 checkbox-all" id="datatable_1">
                                <thead>
                                    <tr>
                                        <th class="ps-0">Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>No. Telp</th>
                                        <th>Status</th>
                                        <th>Tanggal Registrasi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data['user'] as $user)
                                    <tr>
                                        <td class="ps-0">
                                            <img src="{{ $user->avatar
                                                    ? asset('storage/'.$user->avatar)
                                                    : asset('logo/logo.png') }}"
                                                alt=""
                                                class="thumb-md me-2 rounded-circle avatar-border">
                                            <p class="d-inline-block align-middle mb-0">
                                                <span class="font-13 fw-medium">{{ $user->name }}</span>
                                            </p>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->role == 'admin')
                                                <span class="badge bg-secondary-subtle text-success">{{ ucfirst($user->role) }}</span>
                                            @elseif ($user->role == 'seller')
                                                <span class="badge bg-secondary-subtle text-info">{{ ucfirst($user->role) }}</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($user->role) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            @if ($user->is_active == true)
                                                <span class="badge bg-secondary-subtle text-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">Non Aktif</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($user->created_at)->locale('id')->translatedFormat('d F Y H:i') }}</td>
                                        <td class="text-end">
                                            <a href="javascript:void(0)"
                                                class="btn btn-sm bg-primary-subtle btn-edit-user"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}"
                                                data-phone="{{ $user->phone }}">
                                                <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                class="btn btn-sm {{ $user->is_active ? 'bg-danger-subtle btn-toggle-user' : 'bg-success-subtle btn-toggle-user' }}"
                                                data-id="{{ $user->id }}"
                                                data-active="{{ $user->is_active ? '1' : '0' }}">
                                                    @if ($user->is_active)
                                                        <i class="mdi mdi-account-off fs-14 text-danger"></i>
                                                    @else
                                                        <i class="mdi mdi-account-check fs-14 text-success"></i>
                                                    @endif
                                            </a>
                                        </td>
                                    </tr>
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
@include('admin.user.modal.edit')
<form id="toggle-user-form" method="POST">
    @csrf
    @method('PATCH')
</form>
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.btn-toggle-user').forEach(function (btn) {
        btn.addEventListener('click', function () {

            const userId = this.getAttribute('data-id');
            const isActive = this.getAttribute('data-active') === '1';
            const form = document.getElementById('toggle-user-form');

            form.action = "{{ route('admin.users.toggle', ':id') }}".replace(':id', userId);

            Swal.fire({
                title: isActive ? 'Nonaktifkan User?' : 'Aktifkan User?',
                text: isActive
                    ? 'User ini akan dinonaktifkan dan tidak bisa login.'
                    : 'User ini akan diaktifkan kembali.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: isActive ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: isActive ? '#d33' : '#28a745',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
    const form = document.getElementById('edit-user-form');

    document.querySelectorAll('.btn-edit-user').forEach(function (btn) {
        btn.addEventListener('click', function () {

            const id = this.getAttribute('data-id');
            document.getElementById('edit-name').value = this.getAttribute('data-name');
            document.getElementById('edit-email').value = this.getAttribute('data-email');
            document.getElementById('edit-phone').value = this.getAttribute('data-phone');

            form.action = "{{ route('admin.users.update', ':id') }}".replace(':id', id);

            modal.show();
        });
    });

});
</script>


@include('admin.layout.footer')
