@extends('layout.template')

@section('title')
Pemasukan
@endsection

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('incomes.index') }}">Pemasukan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Pemasukan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Daftar Pemasukan</h1>
        </div>
        <div>
            <a href="{{ route('incomes.create') }}" class="btn btn-info d-inline-flex align-items-center">
                <i class="fa fa-plus me-2"></i> Tambah Pemasukan
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table table-centered mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">Date</th>
                        <th class="border-0">Buyer</th>
                        <th class="border-0">Company</th>
                        <th class="border-0">Total Price</th>
                        <th class="border-0">Status</th>
                        <th class="border-0 rounded-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incomes as $income)
                    <tr>
                        <td>{{ $income->date->format('d-m-Y') }}</td>
                        <td>{{ $income->customer_name }}</td>
                        <td>{{ $income->company_name }}</td>
                        <td>{{ $income->formatted_total_price }}</td>
                        <td>{!! $income->status->badge() !!}</td>
                        <td>
                            <form action="{{ route('incomes.destroy', $income->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <!-- <a href="{{ route('incomes.show', $income->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a> -->
                                <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
    new DataTable('#example')
</script>
@endpush