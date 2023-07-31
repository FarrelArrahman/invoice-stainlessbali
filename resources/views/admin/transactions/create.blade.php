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
<form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
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
                                            <span class="breakdown-title" id="breakdown1-title">Breakdown #1</span>
                                        </button>
                                    </h2>
                                    <div id="breakdownCollapse" class="accordion-collapse collapse show" aria-labelledby="breakdown" data-bs-parent="#accordionBreakdown">
                                        <div class="accordion-body">
                                            <label for="">Nama Breakdown</label>
                                            <input type="hidden" class="breakdown-index" name="breakdown[]" value="1">
                                            <input type="text" class="form-control w-100 my-2 breakdown-input" data-breakdown-title="breakdown1-title" data-breakdown-title-default="Breakdown #1" name="breakdown[1][name]" placeholder="Masukkan nama breakdown..." autocomplete="off">
                                            <button class="add-manual-button btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#modal-add-new" data-breakdown="breakdown1"><i class="fa fa-plus me-1"></i> Tambah Manual</button>
                                            <button class="select-item-button btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-select-item" data-breakdown="breakdown1"><i class="fa fa-list me-1"></i> Pilih Item</button>
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
                                                    <tbody class="breakdown-table" id="breakdown1-table">
                                                        <!-- @foreach($items as $item)
                                                        <tr id="breakdown1-item{{ $loop->iteration }}">
                                                            <th class="border-0 rounded-start">
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <button class="btn btn-sm btn-link text-danger remove-item" data-remove-item="#breakdown1-item{{ $loop->iteration }}">
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
                                                        @endforeach -->
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
                            <h1 class="h5 mt-2">Total Harga</h1>
                            <h1 class="h4" id="total-price-text">Rp 0</h1>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="discount-percentage" class="form-label mt-3">Diskon 1 (%)</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control discounts" id="discount-percentage" name="discount_percentage" value="0" min="0" max="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="discount-nominal" class="form-label mt-3">Diskon 2 (Rp)</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control discounts" id="discount-nominal" name="discount_percentage" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invoice-type-offer" class="form-label mt-3">Simpan invoice sebagai</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input onclick="invoiceType(this)" class="form-check-input" type="radio" name="invoice_type" id="invoice-type-offer" value="Offer">
                                        <label class="form-check-label" for="invoice-type-offer">Penawaran</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input onclick="invoiceType(this)" class="form-check-input" type="radio" name="invoice_type" id="invoice-type-deal" value="Deal">
                                        <label class="form-check-label" for="invoice-type-deal">Deal</label>
                                    </div>
                                </div>
                                <div class="mb-3 d-none" id="payment-terms">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="term" class="form-label mt-3">Termin</label>
                                                <div class="input-group">
                                                    <select name="payment_terms" id="term" class="form-select">
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="dp" class="form-label mt-3">DP</label>
                                                <div class="input-group">
                                                    <select name="payment_terms" id="dp" class="form-select">
                                                        <option value="10">10%</option>
                                                        <option value="15">15%</option>
                                                        <option value="20">20%</option>
                                                        <option value="25">25%</option>
                                                        <option value="30">30%</option>
                                                        <option value="40">40%</option>
                                                        <option value="50">50%</option>
                                                        <option value="60">60%</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment-term-breakdown" class="form-label mt-3">Pembayaran</label>
                                        <table id="payment-term-breakdown" class="table table-centered table-bordered mb-0 rounded">
                                            <tr>
                                                <td width="20%">DP</td>
                                                <td width="80%" id="dp-amount">Rp 0</td>
                                                <input type="hidden" id="dp-input" name="dp">
                                            </tr>
                                            <tr id="term1">
                                                <td width="20%">Termin 1</td>
                                                <td width="80%" id="term1-amount">Rp 0</td>
                                                <input type="hidden" id="term1-input" name="term1">
                                            </tr>
                                            <tr id="term2">
                                                <td width="20%">Termin 2</td>
                                                <td width="80%" id="term2-amount">Rp 0</td>
                                                <input type="hidden" id="term2-input" name="term2">
                                            </tr>
                                            <tr id="term3" class="d-none">
                                                <td width="20%">Termin 3</td>
                                                <td width="80%" id="term3-amount">Rp 0</td>
                                                <input type="hidden" id="term3-input" name="term3">
                                            </tr>
                                        </table>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

<!-- Modal Select Item -->
<div class="modal fade" id="modal-select-item" tabindex="-1" role="dialog" aria-labelledby="modal-select-item" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h6 modal-title">Pilih dari daftar item</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="select-item-form">
                    @csrf
                    <div class="mb-3">
                        <label for="a-select" class="form-label">Nama</label>
                        <select name="name" id="a-select" class="select-item w-100" placeholder="Pilih item...">
                            <option value="" disabled selected>--- Pilih item ---</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" data-image="{{ $item->image_real_path }}" data-brand="{{ $item->brand }}" data-model="{{ $item->model }}" data-width="{{ $item->width }}" data-depth="{{ $item->depth }}" data-height="{{ $item->height }}" data-price="{{ $item->price }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="item-detail" class="d-none">
                        <div class="mb-3">
                            <label for="formFile" class="form-label mt-3">Foto</label>
                            <br>
                            <img class="d-none" width="128" id="image-preview" src="" alt="">
                            <input class="form-control" type="file" id="input-file" name="image">
                            <input type="hidden" name="image_path">
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
                <button type="button" id="select-existing-item-button" class="btn btn-secondary add-to-breakdown disabled" data-bs-dismiss="modal">Tambah ke Breakdown</button>
                <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add New -->
<div class="modal fade" id="modal-add-new" tabindex="-1" role="dialog" aria-labelledby="modal-add-new" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h6 modal-title">Tambah item baru</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-new-form" runat="server">
                    @csrf
                    <div class="mb-3">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Foto</label>
                        <br>
                        <img width="128" id="add-new-image-preview" class="d-none">
                        <input class="form-control" type="file" id="add-new-image-input" name="image">
                        <input type="hidden" name="image_path">
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
                <button type="button" id="add-new-item-button" class="btn btn-secondary add-to-breakdown" data-bs-dismiss="modal">Tambah ke Breakdown</button>
                <button type="button" class="btn btn-danger">Reset</button>
                <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script type="text/javascript">
    let niceSelect = NiceSelect.bind(document.getElementById("a-select"), {
        searchable: true
    })

    let breakdownCounter = 1
    let itemCounter = 0
    let currentBreakdown = "breakdown1"
    let itemSelected = false
    let totalPrice = 0
    let discountPercentage = 0
    let discountNominal = 0

    const addBreakdown = document.getElementById('addBreakdown')
    const addNewImageInput = document.getElementById('add-new-image-input')
    const addNewImagePreview = document.getElementById('add-new-image-preview')
    const addItemToBreakdown = document.querySelectorAll('.add-to-breakdown')
    const itemQty = document.querySelectorAll('.item-qty')
    const breakdowns = document.getElementById('breakdowns')
    const breakdown = document.getElementById('accordionBreakdown')
    const inputTitle = document.querySelectorAll('.breakdown-input')
    const inputFile = document.getElementById('input-file')
    const imagePreview = document.getElementById('image-preview')
    const itemSelect = document.getElementById('a-select')
    const itemDetail = document.getElementById('item-detail')
    const addNewForm = document.getElementById('add-new-form')
    const addNewItemButton = document.getElementById('add-new-item-button')
    const selectItemForm = document.getElementById('select-item-form')
    const selectExistingItemButton = document.getElementById('select-existing-item-button')
    const totalPriceText = document.getElementById('total-price-text')
    const discountPercentageInput = document.getElementById('discount-percentage')
    const discountNominalInput = document.getElementById('discount-nominal')
    const paymentTerms = document.getElementById('payment-terms')
    const term = document.getElementById('term')
    const dp = document.getElementById('dp')
    const dpAmount = document.getElementById('dp-amount')
    const term1 = document.getElementById('term1')
    const term1Amount = document.getElementById('term1-amount')
    const term1Input = document.getElementById('term1-input')
    const term2 = document.getElementById('term2')
    const term2Amount = document.getElementById('term2-amount')
    const term2Input = document.getElementById('term2-input')
    const term3 = document.getElementById('term3')
    const term3Amount = document.getElementById('term3-amount')
    const term3Input = document.getElementById('term3-input')

    const rupiahFormat = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    });


    // Add new breakdown upon clicking
    addBreakdown.addEventListener('click', function() {
        const clonedBreakdown = breakdown.cloneNode(true)
        clonedBreakdown.id = 'accordionBreakdown' + ++breakdownCounter

        const clonedBreakdownIndex = clonedBreakdown.querySelector('.breakdown-index')
        clonedBreakdownIndex.value = breakdownCounter

        const clonedBreakdownTitle = clonedBreakdown.querySelector('.breakdown-title')
        clonedBreakdownTitle.setAttribute('id', 'breakdown' + breakdownCounter + '-title')
        clonedBreakdownTitle.innerHTML = 'Breakdown #' + breakdownCounter

        const clonedBreakdownInput = clonedBreakdown.querySelector('.breakdown-input')
        clonedBreakdownInput.value = ""
        clonedBreakdownInput.setAttribute('data-breakdown-title', 'breakdown' + breakdownCounter + '-title')
        clonedBreakdownInput.setAttribute('data-breakdown-title-default', 'Breakdown #' + breakdownCounter)
        clonedBreakdownInput.setAttribute('name', `breakdown[${breakdownCounter}][name]`)

        clonedBreakdown.querySelector('.add-manual-button').setAttribute('data-breakdown', 'breakdown' + breakdownCounter)
        clonedBreakdown.querySelector('.select-item-button').setAttribute('data-breakdown', 'breakdown' + breakdownCounter)

        const clonedBreakdownAccordionButton = clonedBreakdown.querySelector('.accordion-button')
        clonedBreakdownAccordionButton.setAttribute('data-bs-target', '#breakdownCollapse' + breakdownCounter)
        clonedBreakdownAccordionButton.setAttribute('aria-controls', '#breakdownCollapse' + breakdownCounter)

        const clonedBreakdownAccordionCollapse = clonedBreakdown.querySelector('.accordion-collapse')
        clonedBreakdownAccordionCollapse.setAttribute('id', 'breakdownCollapse' + breakdownCounter)
        clonedBreakdownAccordionCollapse.setAttribute('data-bs-parent', '#accordionBreakdown' + breakdownCounter)

        const clonedBreakdownTable = clonedBreakdown.querySelector('.breakdown-table')
        clonedBreakdownTable.replaceChildren()
        clonedBreakdownTable.setAttribute('id', 'breakdown' + breakdownCounter + '-table')

        const deleteBreakdownButton = document.createElement("button")
        deleteBreakdownButton.setAttribute("class", "btn btn-danger deleteBreakdownButton")
        deleteBreakdownButton.setAttribute("data-remove", `#accordionBreakdown${breakdownCounter}`)
        deleteBreakdownButton.innerHTML = "Hapus Breakdown"

        clonedBreakdown.querySelector('.deleteBreakdownPlaceholder').appendChild(deleteBreakdownButton)
        breakdowns.appendChild(clonedBreakdown)

        clonedBreakdown.querySelector('.breakdown-input').addEventListener('keyup', e => {
            const title = document.getElementById(e.target.getAttribute('data-breakdown-title'))
            title.innerHTML = !clonedBreakdownInput.value || !clonedBreakdownInput.value.trim().length ?
                e.target.getAttribute('data-breakdown-title-default') :
                clonedBreakdownInput.value
        })
    })

    // Change breakdown title dynamically
    inputTitle[0].addEventListener('keyup', e => {
        const title = document.getElementById(e.target.getAttribute('data-breakdown-title'))
        title.innerHTML = !inputTitle[0].value || !inputTitle[0].value.trim().length ?
            e.target.getAttribute('data-breakdown-title-default') :
            inputTitle[0].value
    })

    breakdowns.addEventListener('click', function(e) {
        if (e.target.classList.contains('deleteBreakdownButton')) {
            deleteElement(e.target.getAttribute('data-remove'))
            calculateTotalPrice()
        } else if (e.target.classList.contains('add-manual-button') || e.target.classList.contains('select-item-button')) {
            currentBreakdown = e.target.getAttribute('data-breakdown')
        } else if (e.target.classList.contains('item-qty')) {
            calculateItemPrice(e.target.value, e.target.getAttribute('data-price'), e.target.getAttribute('data-total-price'))
        }
    })

    breakdowns.addEventListener('keyup', function(e) {
        if (e.target.classList.contains('item-qty')) {
            if (e.target.value == "" || e.target.value < 1) {
                e.target.value = 1
            }
            calculateItemPrice(e.target.value, e.target.getAttribute('data-price'), e.target.getAttribute('data-total-price'))
        }
    })

    let calculateItemPrice = (qty, price, element) => {
        let totalPrice = qty * price
        const totalPriceText = breakdowns.querySelector(element)
        totalPriceText.innerHTML = rupiahFormat.format(totalPrice)
        totalPriceText.setAttribute('data-price', totalPrice)
        calculateTotalPrice()
    }

    let calculateTotalPrice = () => {
        totalPrice = 0
        discountPercentage = 0
        discountNominal = 0

        let prices = breakdowns.querySelectorAll('.prices')
        let discounts = document.querySelectorAll('.discounts')

        prices.forEach(function(e) {
            totalPrice += parseInt(e.dataset.price)
        })

        discountPercentage = document.querySelector('#discount-percentage').value * totalPrice / 100
        discountNominal = document.querySelector('#discount-nominal').value

        totalPrice = totalPrice - discountPercentage - discountNominal

        if (totalPrice < 0) {
            totalPrice = 0
        }

        setTotalPrice(totalPrice)
        let dpAmount = setDP(totalPrice, dp.value)
        setTerm(totalPrice, dpAmount, term.value)
    }

    let setTotalPrice = (totalPrice) => {
        totalPriceText.innerHTML = rupiahFormat.format(totalPrice)
    }

    let setDP = (totalPrice, dpPercentage) => {
        let dp = dpPercentage * totalPrice / 100
        dpAmount.innerHTML = rupiahFormat.format(dp)
        return dp
    }

    let setTerm = (totalPrice, dpAmount, terms) => {
        let termAmount = totalPrice - dpAmount
        let amountPerTerm = 0

        amountPerTerm = termAmount / terms

        term1Amount.innerHTML = rupiahFormat.format(amountPerTerm)
        term1Input.value = amountPerTerm
        
        term2Amount.innerHTML = rupiahFormat.format(amountPerTerm)
        term2Input.value = amountPerTerm
        
        term3Amount.innerHTML = terms == 3 ? rupiahFormat.format(amountPerTerm) : 0
        term3Input.value = terms == 3 ? amountPerTerm : 0
    }

    // Show item detail upon selection changing
    itemSelect.onchange = function(e) {
        if (!itemSelect.value || !itemSelect.value.trim().length) {
            selectExistingItemButton.classList.add('disabled')
            showItemDetail(false)
        } else {
            selectExistingItemButton.classList.remove('disabled')
            showItemDetail(true)
            setItemDetail(e.target.options[e.target.selectedIndex].dataset)
        }
    }

    let showItemDetail = (toggle) => {
        toggle ? itemDetail.classList.remove('d-none') : itemDetail.classList.add('d-none')
    }

    let setItemDetail = (data) => {
        setImagePreview(data.image)

        if (Object.keys(data).length === 0 && data.constructor === Object) {
            itemSelected = false
            selectItemForm.reset()
        } else {
            itemSelected = true
            const inputs = selectItemForm.elements
            inputs.namedItem("image_path").value = data.image
            inputs.namedItem("brand").value = data.brand
            inputs.namedItem("model").value = data.model
            inputs.namedItem("width").value = data.width
            inputs.namedItem("depth").value = data.depth
            inputs.namedItem("height").value = data.height
            inputs.namedItem("price").value = data.price
        }
    }

    let setImagePreview = (image) => {
        if (!image || !image.trim().length) {
            inputFile.classList.remove('d-none')

            imagePreview.setAttribute('src', "")
            imagePreview.classList.add('d-none')
        } else {
            inputFile.classList.add('d-none')

            imagePreview.setAttribute('src', image)
            imagePreview.classList.remove('d-none')
        }
    }

    let deleteElement = (id) => {
        const element = document.querySelector(id)
        element.remove()
    }

    let addItem = (data) => {
        let item = document.createElement("tr")
        item.id = `${currentBreakdown}-item${++itemCounter}`

        item.innerHTML =
            `
            <th class="border-0 rounded-start">
                <div class="row">
                    <div class="col-2">
                        <button id="item${itemCounter}-remove-button" class="btn btn-sm btn-link text-danger remove-item" data-remove-item="#${currentBreakdown}-item${itemCounter}">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="col-2">
                        <img src="${data.image}" width="128">
                        <input type="hidden" value="${data.image}" name="breakdown[${breakdownCounter}][item][${itemCounter}][image]">
                    </div>
                    <div class="col-8" id="item${itemCounter}-image-preview">
                        <h6 class="item-name mt-2">
                            ${data.name}
                            <input type="hidden" value="${data.name}" name="breakdown[${breakdownCounter}][item][${itemCounter}][name]">
                        </h6>
                        <span class="item-brand">
                            Brand: ${data.brand}
                            <input type="hidden" value="${data.brand}" name="breakdown[${breakdownCounter}][item][${itemCounter}][brand]">
                        </span> <br>
                        <span class="item-model">
                            Model: ${data.model}
                            <input type="hidden" value="${data.model}" name="breakdown[${breakdownCounter}][item][${itemCounter}][model]">
                        </span> <br>
                        <span class="item-dimension">
                            Dimension: ${data.dimension}
                        </span> <br>
                        <span class="item-dimension">
                            Price: ${rupiahFormat.format(data.price)}
                            <input type="hidden" value="${data.price}" name="breakdown[${breakdownCounter}][item][${itemCounter}][price]">
                        </span> <br>
                    </div>
                </div>
            </th>
            <th class="border-0 text-center">
                <input type="number" name="breakdown[${breakdownCounter}][item][${itemCounter}][qty]" data-price="${data.price}" data-total-price="#item${itemCounter}-total-price" class="form-control item-qty" min="1" value="1">
            </th>
            <th id="item${itemCounter}-total-price" class="border-0 rounded-end text-end prices" data-price="${data.price}">
                ${rupiahFormat.format(data.price)}
            </th>
        `

        let table = breakdowns.querySelector('#' + currentBreakdown + '-table')
        table.appendChild(item)

        breakdowns.querySelector(`#item${itemCounter}-remove-button`).addEventListener('click', function(e) {
            breakdowns.querySelector(this.getAttribute('data-remove-item')).remove()
            calculateTotalPrice()
        })

        calculateTotalPrice()
    }

    selectExistingItemButton.addEventListener('click', function(e) {
        const el = selectItemForm.elements
        const data = {
            name: itemSelect.options[el.namedItem("name").value].text,
            image: el.namedItem("image_path").value,
            brand: el.namedItem("brand").value,
            model: el.namedItem("model").value,
            width: el.namedItem("width").value,
            depth: el.namedItem("depth").value,
            height: el.namedItem("height").value,
            dimension: el.namedItem("width").value + " x " + el.namedItem("depth").value + " x " + el.namedItem("height").value,
            price: el.namedItem("price").value
        }
        addItem(data)
    })

    let modalSelectItem = document.getElementById('modal-select-item')
    modalSelectItem.addEventListener('hidden.bs.modal', function(event) {
        showItemDetail(false)
        setItemDetail({})
        niceSelect.clear()
    })

    addNewImageInput.onchange = e => {
        const file = e.target.files[0]
        if (file) {
            addNewImagePreview.classList.remove('d-none')
            addNewImagePreview.src = URL.createObjectURL(file)
            addNewForm.elements.namedItem("image_path").value = URL.createObjectURL(file)
        } else {
            addNewImagePreview.classList.add('d-none')
            addNewImagePreview.src = ""
            addNewForm.elements.namedItem("image_path").value = ""
        }
    }

    addNewItemButton.onclick = e => {
        const el = addNewForm.elements
        const data = {
            name: el.namedItem("name").value,
            image: el.namedItem("image_path").value,
            brand: el.namedItem("brand").value ?? "*CUSTOM",
            model: el.namedItem("model").value,
            width: el.namedItem("width").value,
            depth: el.namedItem("depth").value,
            height: el.namedItem("height").value,
            dimension: el.namedItem("width").value + " x " + el.namedItem("depth").value + " x " + el.namedItem("height").value,
            price: el.namedItem("price").value
        }
        addItem(data)
        copyImageToBreakdown()
        addNewForm.reset()
        addNewImagePreview.classList.add('d-none')
    }

    let copyImageToBreakdown = () => {
        const image = inputFile.cloneNode()
        image.classList.add("visually-hidden")
        image.setAttribute('name', `breakdown[${breakdownCounter}][item][${itemCounter}][image]`)
        document.getElementById(`item${itemCounter}-image-preview`).appendChild(image)
    }

    // Discount
    discountNominalInput.addEventListener('change', e => {
        calculateTotalPrice()
    })

    discountNominalInput.addEventListener('keyup', e => {
        if (e.target.value == "" || e.target.value < 0) {
            e.target.value = 0
        }

        calculateTotalPrice()
    })

    discountPercentageInput.addEventListener('change', e => {
        calculateTotalPrice()
    })

    discountPercentageInput.addEventListener('keyup', e => {
        if (e.target.value == "" || e.target.value < 0) {
            e.target.value = 0
        } else if (e.target.value > 100) {
            e.target.value = 100
        }

        calculateTotalPrice()
    })

    let invoiceType = (type) => {
        if (type.value == "Deal") {
            paymentTerms.classList.remove('d-none')
        } else {
            paymentTerms.classList.add('d-none')
        }
    }

    term.onchange = (e) => {
        if(e.target.value == 3) {
            term3.classList.remove('d-none')
        } else {
            term3.classList.add('d-none')
        }

        calculateTotalPrice()
    }
    
    dp.onchange = (e) => {
        calculateTotalPrice()
    }
</script>
@endpush