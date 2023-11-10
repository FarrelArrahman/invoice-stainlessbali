@extends('layout.template')

@section('title')
Pengeluaran
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
            <li class="breadcrumb-item"><a href="{{ route('expenditures.index') }}">Pengeluaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Pengeluaran</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Daftar Pengeluaran</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <select data-column="3" class="form-select filter-select">
                <option value="">All</option>
                <option value="Teknisi">Teknisi</option>
                <option value="Karyawan">Karyawan</option>
                <option value="Operasional">Operasional</option>
                <option value="Bahan">Bahan</option>
            </select>
        </div>

        <div class="col-md-8">
            <div class="input-group mb-3">
                <input type="search" id="min" class="form-control" value="{{ today()->startOfMonth()->format('Y-m-d') }}">
                <span class="input-group-text">s/d</span>
                <input type="search" id="max" class="form-control" value="{{ today()->endOfMonth()->format('Y-m-d') }}">
                <div class="input-group-append ms-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal-add-expenditure" class="btn btn-info d-inline-flex align-items-center">
                        <i class="fa fa-plus me-2"></i> Tambah Pengeluaran
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
                        <th class="border-0">Name</th>
                        <th class="border-0">Total (Rp.)</th>
                        <th class="border-0">Expenditure Type</th>
                        <th class="border-0 rounded-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add Expenditure -->
<div class="modal fade" id="modal-add-expenditure" tabindex="-1" role="dialog" aria-labelledby="modal-add-expenditure" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h6 modal-title">Tambah pengeluaran untuk</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <a href="{{ route('technician_expenditures.create') }}" class="btn w-100 mb-2 btn-success">Teknisi</a>
                <a href="{{ route('employee_expenditures.create') }}" class="btn w-100 mb-2 btn-info">Karyawan</a>
                <a href="{{ route('operational_expenditures.create') }}" class="btn w-100 mb-2 btn-warning">Operasional</a>
                <a href="{{ route('material_expenditures.create') }}" class="btn w-100 mb-2 btn-danger">Bahan</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
            </div>
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
            url: "{{ route('datatables.expenditures') }}",
            data: function(d) {
                d.start_date = $('#min').val(),
                d.end_date = $('#max').val()
            }
        },
        columnDefs: [
            {targets: 0, width: "15%"},
        ],
        columns: [
            {data: 'date', name: 'date'},
            {data: 'name', name: 'name'},
            {data: 'total_price', name: 'total_price'},
            {
                data: 'type', 
                name: 'type',
                render: function(data, type, row, meta) {
                    return row.expenditure_type
                }
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