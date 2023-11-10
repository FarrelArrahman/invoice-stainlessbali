@extends('layout.template')

@section('title')
User
@endsection

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#"><svg class="icon icon-xxs" fill="none" stroke="currentColor"
                        viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg></a></li>
            <li class="breadcrumb-item"><a href="#">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit User</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow components-section">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12">
                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="name">Nama</label>
                                <input type="text"
                                    class="form-control" id="name" name="name" value="{{ $user->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="text"
                                    class="form-control" id="email" name="email" value="{{ $user->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="role">Role</label>
                                <select class="form-select" name="role" id="">
                                    <option value="" selected disabled>-- Pilih Role --</option>
                                    <option @selected($user->role == "Admin") value="Admin">Admin</option>
                                    <option @selected($user->role == "Karyawan") value="Karyawan">Karyawan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password"
                                    class="form-control" id="password" name="password" placeholder="(tidak diubah)">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password"
                                    class="form-control" id="password_confirmation" name="password_confirmation" placeholder="(tidak diubah)">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-block btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
    new DataTable('#example')

    $('#validation').submit(function(e) {
        let password = $('#password')
        let passwordConfirmation = $('#password_confirmation')

        if(password.val() !== passwordConfirmation.val()) {
            alert("Password dan password konfirmasi harus sama.")
            e.preventDefault()
        }
    })
</script>
@endpush