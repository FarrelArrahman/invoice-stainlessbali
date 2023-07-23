@extends('layout.template')

@section('title')
Transaksi
@endsection

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#"><svg class="icon icon-xxs" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg></a></li>
            <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Transaksi</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Tambah Transaksi</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow components-section">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="accordion" id="accordionCustomer">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="customerData">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#customerCollapse" aria-expanded="false" aria-controls="customerCollapse">
                                        Masukkan data pelanggan...
                                    </button>
                                </h2>
                                <div id="customerCollapse" class="accordion-collapse collapse" aria-labelledby="customerData" data-bs-parent="#accordionCustomer">
                                    <div class="accordion-body">
                                        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name">
                                            </div>
                                            <div class="mb-3">
                                                <label for="name">Address</label>
                                                <input type="text" class="form-control" id="address" name="address">
                                            </div>
                                            <div class="mb-3">
                                                <label for="name">Phone Number</label>
                                                <input type="text" class="form-control" id="phone_number" name="phone_number">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-sm-12 mb-4">
        <div class="card border-0 shadow components-section">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h1 class="h5 mt-2">Transaksi</h1>
                        <button id="addBreakdown" class="btn btn-primary pull-right" type="button"><i class="fa fa-plus me-1"></i> Tambah Breakdown Baru</button>
                    </div>

                    <div class="col-12" id="breakdowns">
                        <div class="accordion mb-2" id="accordionBreakdown">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="breakdown">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#breakdownCollapse" aria-expanded="false" aria-controls="breakdownCollapse">
                                        <span class="breakdown-title">Breakdown #1</span>
                                    </button>
                                </h2>
                                <div id="breakdownCollapse" class="accordion-collapse collapse show" aria-labelledby="breakdown" data-bs-parent="#accordionBreakdown">
                                    <div class="accordion-body">
                                        <input type="text" class="form-control w-100 my-2 breakdown-input" data-breakdown-title="breakdown1-title" data-breakdown-title-default="Breakdown #1" name="name" placeholder="Masukkan nama breakdown...">
                                        <button class="add-manual-button btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#modal-add-manual" data-breakdown="breakdown1"><i class="fa fa-plus me-1"></i> Tambah Manual</button>
                                        <button class="select-item-button btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-select-item" data-breakdown="breakdown1"><i class="fa fa-plus me-1"></i> Pilih Item</button>
                                        <span class="deleteBreakdownPlaceholder"></span>
                                        <div class="table-responsive">
                                            <table class="table table-centered mb-0 rounded">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th width="60%" class="border-0">Item</th>
                                                        <th width="15%" class="border-0 text-center">Qty</th>
                                                        <th width="25%" class="border-0 rounded-end text-end">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($items as $item)
                                                    <tr>
                                                        <th class="border-0 rounded-start">
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <button class="btn btn-sm btn-link text-danger">
                                                                        <i class="fa fa-times"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="col-2">
                                                                    <img src="{{ Storage::url($item->image) }}">
                                                                </div>
                                                                <div class="col-8">
                                                                    <h6 class="item-name mt-2">{{ $item->name }}</h6>
                                                                    <span class="item-brand">Brand: {{ $item->brand }}</span> <br>
                                                                    <span class="item-model">Model: {{ $item->model }}</span> <br>
                                                                    <span class="item-dimension">Dimension: {{ $item->dimension }}</span>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th class="border-0 text-center">
                                                            <input type="number" name="item-qty" id="item-qty" class="form-control" min="1" value="1">
                                                        </th>
                                                        <th class="border-0 rounded-end text-end">
                                                            {{ $item->formatted_price }}
                                                        </th>
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
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-sm-12 mb-4">
        <div class="card border-0 shadow components-section">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h1 class="h5 mt-2">Pembayaran</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-select-item" tabindex="-1" role="dialog" aria-labelledby="modal-select-item" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h6 modal-title">Pilih dari daftar item</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="items">Nama</label>
                        <select name="items" id="a-select" class="select-item w-100">
                            <option value=""></option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="item-detail d-none">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Foto</label>
                            <input class="form-control" type="file" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="brand" aria-describedby="brandHelp">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand">
                            <small id="brandHelp" class="form-text text-muted">Kosongkan field ini jika tanpa brand / custom.</small>
                        </div>
                        <div class="mb-3">
                            <label for="model">Model</label>
                            <input type="text" class="form-control" id="model" name="model">
                        </div>
                        <div class="mb-3">
                            <div class="row mb-3">
                                <div class="col-lg-4 col-sm-12 mb-lg-0 mb-sm-3">
                                    <label for="width">Width (mm)</label>
                                    <input type="number" class="form-control" id="width" name="width">
                                </div>
                                <div class="col-lg-4 col-sm-12 mb-lg-0 mb-sm-3">
                                    <label for="depth">Depth (mm)</label>
                                    <input type="number" class="form-control" id="depth" name="depth">
                                </div>
                                <div class="col-lg-4 col-sm-12 mb-lg-0 mb-sm-3">
                                    <label for="height">Height (mm)</label>
                                    <input type="number" class="form-control" id="height" name="height">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="price">Price</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    Rp.
                                </span>
                                <input type="text" class="form-control" id="price" name="price">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary">Tambah ke Breakdown</button>
                <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-manual" tabindex="-1" role="dialog" aria-labelledby="modal-add-manual" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h6 modal-title">Tambah item baru</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Foto</label>
                        <input class="form-control" type="file" id="image" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="brand" aria-describedby="brandHelp">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand">
                        <small id="brandHelp" class="form-text text-muted">Kosongkan field ini jika tanpa brand / custom.</small>
                    </div>
                    <div class="mb-3">
                        <label for="model">Model</label>
                        <input type="text" class="form-control" id="model" name="model">
                    </div>
                    <div class="mb-3">
                        <div class="row mb-3">
                            <div class="col-lg-4 col-sm-12 mb-lg-0 mb-sm-3">
                                <label for="width">Width (mm)</label>
                                <input type="number" class="form-control" id="width" name="width">
                            </div>
                            <div class="col-lg-4 col-sm-12 mb-lg-0 mb-sm-3">
                                <label for="depth">Depth (mm)</label>
                                <input type="number" class="form-control" id="depth" name="depth">
                            </div>
                            <div class="col-lg-4 col-sm-12 mb-lg-0 mb-sm-3">
                                <label for="height">Height (mm)</label>
                                <input type="number" class="form-control" id="height" name="height">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="price">Price</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                Rp.
                            </span>
                            <input type="text" class="form-control" id="price" name="price">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary">Tambah ke Breakdown</button>
                <button type="button" class="btn btn-danger">Reset</button>
                <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script type="text/javascript">
    NiceSelect.bind(document.getElementById("a-select"), {
        searchable: true
    })

    let counter = 1
    let currentBreakdown = "breakdown1"
    
    const addBreakdown = document.getElementById('addBreakdown')
    const breakdowns = document.getElementById('breakdowns')
    const breakdown = document.getElementById('accordionBreakdown')
    const inputTitle = document.querySelectorAll('.breakdown-input')

    addBreakdown.addEventListener('click', function() {
        const clonedBreakdown = breakdown.cloneNode(true)
        clonedBreakdown.id = 'accordionBreakdown' + ++counter
        
        const clonedBreakdownTitle = clonedBreakdown.querySelector('.breakdown-title')
        clonedBreakdownTitle.setAttribute('id', 'breakdown' + counter + '-title')
        clonedBreakdownTitle.innerHTML = 'Breakdown #' + counter
        
        const clonedBreakdownInput = clonedBreakdown.querySelector('.breakdown-input')
        clonedBreakdownInput.setAttribute('data-breakdown-title', 'breakdown' + counter + '-title')
        clonedBreakdownInput.setAttribute('data-breakdown-title-default', 'Breakdown #' + counter)
        
        clonedBreakdown.querySelector('.add-manual-button').setAttribute('data-breakdown', 'breakdown' + counter)
        clonedBreakdown.querySelector('.select-item-button').setAttribute('data-breakdown', 'breakdown' + counter)

        const clonedBreakdownAccordionButton = clonedBreakdown.querySelector('.accordion-button')
        clonedBreakdownAccordionButton.setAttribute('data-bs-target', '#breakdownCollapse' + counter)
        clonedBreakdownAccordionButton.setAttribute('aria-controls', '#breakdownCollapse' + counter)

        const clonedBreakdownAccordionCollapse = clonedBreakdown.querySelector('.accordion-collapse')
        clonedBreakdownAccordionCollapse.setAttribute('id', 'breakdownCollapse' + counter)
        clonedBreakdownAccordionCollapse.setAttribute('data-bs-parent', '#accordionBreakdown' + counter)
        
        const deleteBreakdownButton = document.createElement("button")
        deleteBreakdownButton.setAttribute("class", "btn btn-danger deleteBreakdownButton")
        deleteBreakdownButton.setAttribute("data-remove", `#accordionBreakdown${counter}`)
        deleteBreakdownButton.innerHTML = "Hapus Breakdown"

        clonedBreakdown.querySelector('.deleteBreakdownPlaceholder').appendChild(deleteBreakdownButton)
        breakdowns.appendChild(clonedBreakdown)

        clonedBreakdown.querySelector('.breakdown-input').addEventListener('keyup', e => {
            const title = document.getElementById(e.target.getAttribute('data-breakdown-title'))
            title.innerHTML = ! clonedBreakdownInput.value || ! clonedBreakdownInput.value.trim().length 
                ? e.target.getAttribute('data-breakdown-title-default')
                : clonedBreakdownInput.value
        })
    })

    breakdowns.addEventListener('click', function(e) {
        if(e.target.classList.contains('deleteBreakdownButton')) {
            // alert(e.target.getAttribute('data-remove'))
            deleteBreakdown(e.target.getAttribute('data-remove'))
        }
    })

    let deleteBreakdown = (id) => {
        const breakdown = document.querySelector(id)
        breakdown.remove()
    }

    breakdowns.addEventListener('click', function(e) {
        if(e.target.classList.contains('add-manual-button') || e.target.classList.contains('select-item-button')) {
            currentBreakdown = e.target.getAttribute('data-breakdown')
            console.log(currentBreakdown)
        }
    })
</script>
@endpush