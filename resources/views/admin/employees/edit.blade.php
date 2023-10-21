@extends('layout.template')

@section('title')
Karyawan
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
            <li class="breadcrumb-item"><a href="#">Karyawan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Karyawan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit Karyawan</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow components-section">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12">
                        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="name">Nama</label>
                                <input type="text"
                                    class="form-control" id="name" name="name" value="{{ $employee->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="address" aria-describedby="addressHelp">Alamat</label>
                                <input type="text"
                                    class="form-control" id="address" name="address" value="{{ $employee->address }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone_number">Nomor Telepon</label>
                                <input type="text"
                                    class="form-control" id="phone_number" name="phone_number" value="{{ $employee->phone_number }}">
                            </div>
                            <div class="mb-3">
                                <label for="role">Role</label>
                                <input type="text"
                                    class="form-control" id="role" name="role" value="{{ $employee->role }}">
                            </div>
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-select">
                                    @foreach(\App\Enums\StatusEnum::activeCases() as $status)
                                    <option @selected($status->value == $employee->status) value="{{ $status->value }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
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
</script>
@endpush