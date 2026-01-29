@include('admin.layout.head')
@include('admin.layout.topbar')
@include('admin.layout.sidebar')

<div class="content">
    <div class="container-fluid">

        <div class="py-3">
            <h4 class="fs-18 fw-semibold m-0">Profile</h4>
        </div>
        @include('alert')

        <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">

                        <img src="{{ Auth::user()->avatar
                                ? asset('storage/'.Auth::user()->avatar)
                                : asset('logo/logo.png') }}"
                             class="rounded-circle avatar-xl img-thumbnail mb-3">

                        <form action="{{ route('admin.profile.avatar') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <input type="file"
                                   name="avatar"
                                   class="form-control mb-3"
                                   accept="image/*"
                                   required>

                            <button type="submit" class="btn btn-primary w-100">
                                Update Avatar
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.profile.update') }}"
                              method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ Auth::user()->name }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ Auth::user()->email }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No. Telp</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ Auth::user()->phone }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Kosongkan jika tidak diganti">
                            </div>

                            <button type="submit" class="btn btn-success">
                                Update Profile
                            </button>

                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@include('admin.layout.footer')
