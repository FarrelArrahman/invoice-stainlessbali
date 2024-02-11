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
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="input-group mb-3">
                <input type="search" id="min" class="form-control" value="{{ today()->startOfMonth()->format('Y-m-d') }}">
                <span class="input-group-text">s/d</span>
                <input type="search" id="max" class="form-control" value="{{ today()->endOfMonth()->format('Y-m-d') }}">
                <div class="input-group-append ms-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal-add-income" class="btn btn-info d-inline-flex align-items-center">
                        <i class="fa fa-plus me-2"></i> Tambah Pemasukan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-centered mb-0 rounded">
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
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
    // Create date inputs
    minDate = new DateTime('#min', {
        format: 'YYYY-MM-DD'
    });
    maxDate = new DateTime('#max', {
        format: 'YYYY-MM-DD'
    });

    var dataTable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            type: "GET",
            url: "{{ route('datatables.incomes') }}",
            data: function(d) {
                d.start_date = $('#min').val(),
                d.end_date = $('#max').val()
            }
        },
        order: [[ 0, 'desc' ]],
        columnDefs: [
            {targets: 0, width: "15%"},
        ],
        columns: [
            {data: 'date', name: 'date'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'company_name', name: 'company_name'},
            {data: 'total_price', name: 'total_price'},
            {
                data: 'badge', 
                name: 'badge',
            },
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    })

    $('.filter-select').change(function() {
        dataTable.column($(this).data('column'))
        .search($(this).val())
        .draw()
    })

    
    // Refilter the table
    document.querySelectorAll('#min, #max').forEach((el) => {
        el.addEventListener('change', () => { 
            dataTable.draw()
        })
    })
</script>
@endpush