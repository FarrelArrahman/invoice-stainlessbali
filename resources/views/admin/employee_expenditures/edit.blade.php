@extends('layout.template')

@section('title')
Pengeluaran
@endsection

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#"><svg class="icon icon-xxs" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg></a></li>
            <li class="breadcrumb-item"><a href="#">Pengeluaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Pengeluaran</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit Pengeluaran</h1>
        </div>
    </div>
</div>
<form action="{{ route('technician_expenditures.update', $technician_expenditure->id) }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="total_price" id="total-price-input">
    <input type="hidden" name="total_price_before_discount" id="total-price-before-discount-input">
    @method('PUT')
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
                                            Masukkan data teknisi...
                                        </button>
                                    </h2>
                                    <div id="customerCollapse" class="accordion-collapse collapse" aria-labelledby="customerData" data-bs-parent="#accordionCustomer">
                                        <div class="accordion-body">
                                            <div id="technician-detail">
                                                <label for="technician-name">Nama Teknisi</label>
                                                <div class="input-group mb-3">
                                                    <input id="technician-name" type="text" class="form-control" name="technician_name" value="{{ $technician_expenditure->technician->name }}">
                                                    <span data-bs-toggle="modal" data-bs-target="#modal-select-technician" id="select-customer" style="cursor: pointer;" class="input-group-text" id="basic-addon2">
                                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="technician-phone-number">Nomor Telepon</label>
                                                    <input id="technician-phone-number" type="text" class="form-control" id="technician_phone_number" name="technician_phone_number" value="{{ $technician_expenditure->technician->phone_number }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="technician-address">Alamat</label>
                                                    <input id="technician-address" type="text" class="form-control" id="technician_address" name="technician_address" value="{{ $technician_expenditure->technician->address }}">
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
        </div>

        <div class="col-lg-8 col-sm-12 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="h5 mt-2">Pengeluaran</h1>
                            <!-- <button id="addBreakdown" class="btn btn-primary pull-right" type="button"><i class="fa fa-plus me-1"></i> Tambah Breakdown Baru</button> -->
                        </div>

                        <div class="col-12" id="breakdowns">
                            <div class="accordion mb-2" id="accordionBreakdown">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="breakdown">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#breakdownCollapse" aria-expanded="false" aria-controls="breakdownCollapse">
                                            <span class="breakdown-title" id="breakdown-title">Daftar pemasukan</span>
                                        </button>
                                    </h2>
                                    <div id="breakdownCollapse" class="accordion-collapse collapse show" aria-labelledby="breakdown" data-bs-parent="#accordionBreakdown">
                                        <div class="accordion-body">
                                            <label for="">Tanggal</label>
                                            <input type="date" class="form-control w-100 my-2" name="date" value="{{ $technician_expenditure->date->format('Y-m-d') }}">
                                            <button class="add-manual-button btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#modal-add-new" data-breakdown="breakdown" data-breakdown-counter=""><i class="fa fa-plus me-1"></i> Tambah Item</button>
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
                                                    <tbody class="breakdown-table" id="breakdown-table">
                                                        @foreach($technician_expenditure->items as $item)
                                                        <tr id="breakdown-item{{ $item->id }}">
                                                            <th class="border-0 rounded-start">
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <button type="button" id="item{{ $item->id }}-remove-button" class="btn btn-sm btn-link text-danger remove-item" onclick='removeItem("#breakdown-item{{ $item->id }}")'>
                                                                            <i class="fa fa-times"></i>
                                                                        </button>
                                                                        <input type="hidden" value="{{ $item->id }}" name="technician_expenditure[{{ $item->id }}][id]">
                                                                    </div>
                                                                    <div class="col-8" id="item{{ $item->id }}-image-preview">
                                                                        <h6 class="item-name mt-2">
                                                                            <input class="border-bottom-input" type="text" name="technician_expenditure[{{ $item->id }}][name]" value="{{ $item->item_name }}" placeholder="Masukkan nama barang...">
                                                                        </h6>
                                                                        <span class="item-dimension">
                                                                            Rp.
                                                                            <input onfocus="if(this.value.length <= 1) setSelectionRange(0, this.value.length)" class="border-bottom-input item-price" type="text" value="{{ $item->price }}" data-total-price="#item{{ $item->id }}-total-price" data-qty="#item{{ $item->id }}-qty" name="technician_expenditure[{{ $item->id }}][price]">
                                                                        </span> <br>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <th class="border-0 text-center">
                                                                <input id="item{{ $item->id }}-qty" type="number" name="technician_expenditure[{{ $item->id }}][qty]" data-price="{{ $item->price }}" data-total-price="#item{{ $item->id }}-total-price" class="form-control item-qty" min="1" value="{{ $item->qty }}">
                                                            </th>
                                                            <th id="item{{ $item->id }}-total-price" class="border-0 rounded-end text-end prices" data-price="{{ $item->total_price }}">
                                                                {{ $item->formatted_total_price }}
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
                            <div class="form-group">
                                <label for="service-fee-input" class="form-label">Biaya Jasa (Rp)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control discounts" id="service-fee-input" name="service_fee" value="{{ $technician_expenditure->service_fee }}">
                                </div>
                            </div>
                            <h1 class="h5 mt-5">Total Harga</h1>
                            <h1 class="h4" id="total-price-text">{{ $technician_expenditure->formatted_total_price }}</h1>
                            <h1 class="h6 text-danger text-decoration-line-through d-none" id="total-price-before-discount-text">Rp 0</h1>
                            <!-- <div class="mb-3">
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
                                                <input type="number" class="form-control discounts" id="discount-nominal" name="discount_nominal" value="0">
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
                                                    <select name="dp" id="dp" class="form-select">
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
                                </div> -->
                                <button type="submit" class="btn btn-success w-100">Simpan</button>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

<!-- Modal Select Technician -->
<div class="modal fade" id="modal-select-technician" tabindex="-1" role="dialog" aria-labelledby="modal-select-technician" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h6 modal-title">Pilih teknisi</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="a-select" class="form-label">Nama</label>
                    <select name="technician_id" id="technician-nice-select" class="select-company w-100" placeholder="Pilih teknisi...">
                        <option value="" disabled selected>--- Pilih teknisi ---</option>
                        @foreach($technicians as $technician)
                        <option @selected($technician->id == $technician_expenditure->technician_id) value="{{ $technician->id }}" data-name="{{ $technician->name }}" data-address="{{ $technician->address }}" data-phone-number="{{ $technician->phone_number }}">{{ $technician->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="select-existing-technician-button" class="btn btn-secondary add-company-data" data-bs-dismiss="modal">Pilih Teknisi</button>
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
                        <label for="price">Price</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                Rp.
                            </span>
                            <input type="text" class="form-control" id="new-price" name="price">
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
    let showNotyf = (background, message) => {
        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top',
            },
            types: [
                {
                    type: "info",
                    background: background,
                    icon: {
                        className: 'fa fa-exclamation-circle',
                        tagName: 'span',
                        color: '#fff'
                    },
                    dismissible: false
                }
            ]
        })
        
        notyf.open({
            type: "info",
            message: message
        })
    }

    let checkForm = () => {
        if(
            technicianDetail.querySelector("#technician-name").value == "" ||
            technicianDetail.querySelector("#technician-phone-number").value == ""
        ) {
            showNotyf("red", "Data teknisi belum diisi")
            event.preventDefault()
        }
    }

    let companyNiceSelect = NiceSelect.bind(document.getElementById("technician-nice-select"), {
        searchable: true
    })

    VMasker(document.querySelector(`#new-price`)).maskMoney({
        precision: 0
    })
    
    VMasker(document.querySelectorAll(`.item-price`)).maskMoney({
        precision: 0
    })
    
    VMasker(document.querySelector(`#service-fee-input`)).maskMoney({
        precision: 0
    })

    let breakdownCounter = 1
    let itemCounter = 0
    let currentBreakdown = "breakdown1"
    let currentBreakdownCounter = 1
    let itemSelected = false
    let totalPrice = 0
    let discountPercentage = 0
    let discountNominal = 0

    const itemQty = document.querySelectorAll('.item-qty')
    const breakdowns = document.getElementById('breakdowns')
    const breakdown = document.getElementById('accordionBreakdown')
    const technicianDetail = document.getElementById('technician-detail')
    const itemDetail = document.getElementById('item-detail')
    const addNewForm = document.getElementById('add-new-form')
    const addNewItemButton = document.getElementById('add-new-item-button')
    const selectItemForm = document.getElementById('select-item-form')
    const selectExistingCompanyButton = document.getElementById('select-existing-technician-button')
    const selectExistingCustomerButton = document.getElementById('select-existing-customer-button')
    const totalPriceText = document.getElementById('total-price-text')
    const totalPriceInput = document.getElementById('total-price-input')
    const totalPriceBeforeDiscountText = document.getElementById('total-price-before-discount-text')
    const totalPriceBeforeDiscountInput = document.getElementById('total-price-before-discount-input')
    const discountPercentageInput = document.getElementById('discount-percentage')
    const serviceFeeInput = document.getElementById('service-fee-input')
    const technicianSelect = document.getElementById('technician-nice-select')
    
    const rupiahFormat = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    });

    breakdowns.addEventListener('click', function(e) {
        if (e.target.classList.contains('deleteBreakdownButton')) {
            deleteElement(e.target.getAttribute('data-remove'))
            calculateTotalPrice()
        } else if (e.target.classList.contains('add-manual-button') || e.target.classList.contains('select-item-button')) {
            currentBreakdown = e.target.getAttribute('data-breakdown')
            currentBreakdownCounter = e.target.getAttribute('data-breakdown-counter')
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
        } else if (e.target.classList.contains('item-price')) {
            let price = breakdowns.querySelector(e.target.getAttribute('data-total-price'))
            price.setAttribute('data-price', e.target.value.replaceAll('.', ''))
            
            let qty = breakdowns.querySelector(e.target.getAttribute('data-qty'))
            qty.setAttribute('data-price', e.target.value.replaceAll('.', ''))

            calculateItemPrice(qty.value, qty.getAttribute('data-price'), qty.getAttribute('data-total-price'))
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
        serviceFee = 0

        let prices = breakdowns.querySelectorAll('.prices')
        let discounts = document.querySelectorAll('.discounts')

        prices.forEach(function(e) {
            totalPrice += parseInt(e.dataset.price)
        })

        serviceFee = serviceFeeInput.value.replaceAll('.', '')

        totalPrice = +totalPrice + +serviceFee

        if (totalPrice < 0) {
            totalPrice = 0
        }

        setTotalPrice(totalPrice)
    }

    let setTotalPrice = (totalPrice) => {
        totalPriceText.innerHTML = rupiahFormat.format(totalPrice)
        totalPriceInput.value = totalPrice
    }

    let setTotalPriceBeforeDiscount = (totalPriceBeforeDiscount, discountTotal) => {
        if (discountTotal > 0) {
            totalPriceBeforeDiscountText.innerHTML = rupiahFormat.format(totalPriceBeforeDiscount)
            totalPriceBeforeDiscountText.classList.remove('d-none')
        } else {
            totalPriceBeforeDiscountText.classList.add('d-none')
        }

        totalPriceBeforeDiscountInput.value = totalPriceBeforeDiscount
    }

    let setDP = (totalPrice, dpPercentage) => {
        let dp = dpPercentage * totalPrice / 100
        dpAmount.innerHTML = rupiahFormat.format(dp)
        dpInput.value = dp

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

    // Show technician detail upon selection changing
    technicianSelect.onchange = function(e) {
        if (!technicianSelect.value || !technicianSelect.value.trim().length) {
            selectExistingCompanyButton.classList.add('disabled')
            showItemDetail(false)
        } else {
            selectExistingCompanyButton.classList.remove('disabled')
            showItemDetail(true)
            setItemDetail(e.target.options[e.target.selectedIndex].dataset)
        }
    }

    let showItemDetail = (toggle) => {
        toggle ? itemDetail.classList.remove('d-none') : itemDetail.classList.add('d-none')
    }

    let setItemDetail = (data) => {
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

        VMasker(document.querySelector(`#existing-price`)).maskMoney({
            precision: 0
        })
    }

    let setTechnicianDetail = (data) => {
        technicianDetail.querySelector("#technician-name").value = data.name
        technicianDetail.querySelector("#technician-phone-number").value = data.phoneNumber
        technicianDetail.querySelector("#technician-address").value = data.address
    }

    let deleteElement = (id) => {
        const element = document.querySelector(id)
        element.remove()
    }

    let addItem = (data) => {
        let item = document.createElement("tr")
        item.id = `${currentBreakdown}-item${++itemCounter}`
        // console.log("Add item to Current Breakdown: " + currentBreakdown)
        item.innerHTML =
            `
            <th class="border-0 rounded-start">
                <div class="row">
                    <div class="col-2">
                        <button id="item${itemCounter}-remove-button" class="btn btn-sm btn-link text-danger remove-item" data-remove-item="#${currentBreakdown}-item${itemCounter}">
                            <i class="fa fa-times"></i>
                        </button>
                        <input type="hidden" value="${data.id ?? ''}" name="breakdown[${breakdownCounter}][item][${itemCounter}][id]">
                    </div>
                    <div class="col-8" id="item${itemCounter}-image-preview">
                        <h6 class="item-name mt-2">
                            <input class="border-bottom-input" type="text" value="${data.name}" name="breakdown[${breakdownCounter}][item][${itemCounter}][name]">
                        </h6>
                        <span class="item-dimension mt-2">
                            Rp.  
                            <input id="item${itemCounter}-price" data-qty="#item${itemCounter}-qty" data-total-price="#item${itemCounter}-total-price" class="border-bottom-input item-price" type="text" value="${data.price}" name="breakdown[${breakdownCounter}][item][${itemCounter}][price]">
                        </span> <br>
                    </div>
                </div>
            </th>
            <th class="border-0 text-center">
                <input id="item${itemCounter}-qty" type="number" name="breakdown[${breakdownCounter}][item][${itemCounter}][qty]" data-price="${data.price.replaceAll('.', '')}" data-total-price="#item${itemCounter}-total-price" class="form-control item-qty" min="1" value="1">
            </th>
            <th id="item${itemCounter}-total-price" class="border-0 rounded-end text-end prices" data-price="${data.price.replaceAll('.', '')}">
                ${rupiahFormat.format(data.price.replaceAll('.', ''))}
            </th>
        `

        let table = breakdowns.querySelector('#' + currentBreakdown + '-table')
        table.appendChild(item)

        breakdowns.querySelector(`#item${itemCounter}-remove-button`).addEventListener('click', function(e) {
            breakdowns.querySelector(this.getAttribute('data-remove-item')).remove()
            calculateTotalPrice()
        })

        calculateTotalPrice()

        VMasker(document.querySelector(`#item${itemCounter}-price`)).maskMoney({
            precision: 0
        })
    }

    selectExistingCompanyButton.addEventListener('click', function(e) {
        setTechnicianDetail(technicianSelect.options[technicianSelect.selectedIndex].dataset)
    })

    addNewItemButton.onclick = e => {
        const el = addNewForm.elements
        const data = {
            name: el.namedItem("name").value,
            price: el.namedItem("price").value
        }
        addItem(data)
        addNewForm.reset()
    }

    serviceFeeInput.addEventListener('keyup', e => {
        if (e.target.value == "" || e.target.value < 0) {
            e.target.value = 0
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
</script>
@endpush