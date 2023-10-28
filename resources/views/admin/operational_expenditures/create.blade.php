@extends('layout.template')

@section('title')
Pengeluaran Operasional
@endsection

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#"><svg class="icon icon-xxs" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg></a></li>
            <li class="breadcrumb-item"><a href="#">Pengeluaran Operasional</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pengeluaran Operasional</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Tambah Pengeluaran Operasional</h1>
        </div>
    </div>
</div>
<form onsubmit="checkForm()" action="{{ route('operational_expenditures.store') }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="total_price" id="total-price-input">
    <input type="hidden" name="total_price_before_discount" id="total-price-before-discount-input">
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
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#customerCollapse" aria-expanded="false" aria-controls="customerCollapse">
                                            Masukkan data Toko...
                                        </button>
                                    </h2>
                                    <div id="customerCollapse" class="accordion-collapse collapse" aria-labelledby="customerData" data-bs-parent="#accordionCustomer">
                                        <div class="accordion-body">
                                            <div id="customer-detail">
                                                <label for="shop-name">Nama Toko</label>
                                                <div class="input-group mb-3">
                                                    <input id="shop-name" type="text" class="form-control" name="shop_name">
                                                    <span data-bs-toggle="modal" data-bs-target="#modal-select-company" id="select-customer" style="cursor: pointer;" class="input-group-text" id="basic-addon2">
                                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="shop-telephone-number">Nomor Telepon Toko</label>
                                                    <input id="shop-telephone-number" type="text" class="form-control" name="shop_telephone_number">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="shop-address">Alamat Toko</label>
                                                    <input id="shop-address" type="text" class="form-control" name="shop_address">
                                                </div>
                                                <!-- <div class="input-group mb-3">
                                                    <label for="name">Nama PIC</label>
                                                    <input id="customer-name" type="text" class="form-control" name="customer_name">
                                                    <span data-bs-toggle="modal" data-bs-target="#modal-select-customer" id="select-customer" style="cursor: pointer;" class="input-group-text" id="basic-addon2">
                                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="name">Nomor Telepon</label>
                                                    <input id="customer-phone-number" type="text" class="form-control" id="customer_phone_number" name="customer_phone_number">
                                                </div> -->
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
                            <h1 class="h5 mt-2">Pengeluaran Operasional</h1>
                            <!-- <button id="addBreakdown" class="btn btn-primary pull-right" type="button"><i class="fa fa-plus me-1"></i> Tambah Breakdown Baru</button> -->
                        </div>

                        <div class="col-12" id="breakdowns">
                            <div class="accordion mb-2" id="accordionBreakdown">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="breakdown">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#breakdownCollapse" aria-expanded="false" aria-controls="breakdownCollapse">
                                            <span class="breakdown-title" id="breakdown1-title">Daftar Pengeluaran Operasional</span>
                                        </button>
                                    </h2>
                                    <div id="breakdownCollapse" class="accordion-collapse collapse show" aria-labelledby="breakdown" data-bs-parent="#accordionBreakdown">
                                        <div class="accordion-body">
                                            <label for="">Tanggal</label>
                                            <input type="date" class="form-control w-100 my-2" name="date" value="{{ today()->format('Y-m-d') }}">
                                            <button class="add-manual-button btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#modal-add-new" data-breakdown="breakdown1" data-breakdown-counter="1"><i class="fa fa-plus me-1"></i> Tambah Item</button>
                                            <!-- <button class="select-item-button btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-select-item" data-breakdown="breakdown1" data-breakdown-counter="1"><i class="fa fa-list me-1"></i> Pilih Item</button> -->
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
                            <h1 class="h6 text-danger text-decoration-line-through d-none" id="total-price-before-discount-text">Rp 0</h1>
                            <button type="submit" class="btn btn-success w-100">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

<!-- Modal Select Company -->
<div class="modal fade" id="modal-select-company" tabindex="-1" role="dialog" aria-labelledby="modal-select-company" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h6 modal-title">Pilih toko</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="a-select" class="form-label">Nama</label>
                    <select name="company_id" id="company-nice-select" class="select-company w-100" placeholder="Pilih toko...">
                        <option value="" disabled selected>--- Pilih toko ---</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" data-name="{{ $company->name }}" data-address="{{ $company->address }}" data-telephone-number="{{ $company->telephone_number }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="select-existing-company-button" class="btn btn-secondary add-company-data" data-bs-dismiss="modal">Pilih Toko</button>
                <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Select Customer -->
<div class="modal fade" id="modal-select-customer" tabindex="-1" role="dialog" aria-labelledby="modal-select-customer" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h6 modal-title">Pilih customer</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="a-select" class="form-label">Nama</label>
                    <select name="customer_id" id="customer-nice-select" class="select-customer w-100" placeholder="Pilih customer...">
                        <option value="" disabled selected>--- Pilih customer ---</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="select-existing-customer-button" class="btn btn-secondary add-customer-data disabled" data-bs-dismiss="modal">Tambah Data Customer</button>
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
            customerDetail.querySelector("#customer-name").value == "" ||
            customerDetail.querySelector("#companyaddress").value == "" || 
            customerDetail.querySelector("#customer-phone-number").value == ""
        ) {
            showNotyf("red", "Data PIC belum diisi")
            event.preventDefault()
        }
    }

    let companyNiceSelect = NiceSelect.bind(document.getElementById("company-nice-select"), {
        searchable: true
    })
    
    let customerNiceSelect = NiceSelect.bind(document.getElementById("customer-nice-select"), {
        searchable: true
    })

    VMasker(document.querySelector(`#new-price`)).maskMoney({
        precision: 0
    })
    
    // VMasker(document.querySelector(`#discount-nominal`)).maskMoney({
    //     precision: 0
    // })

    let breakdownCounter = 1
    let itemCounter = 0
    let currentBreakdown = "breakdown1"
    let currentBreakdownCounter = 1
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
    const inputFileWrapper = document.getElementById('input-file-wrapper')
    const inputFile = document.getElementById('input-file')
    const imagePreview = document.getElementById('image-preview')
    const companySelect = document.getElementById('company-nice-select')
    const itemDetail = document.getElementById('item-detail')
    const customerSelect = document.getElementById('customer-nice-select')
    const customerDetail = document.getElementById('customer-detail')
    const addNewForm = document.getElementById('add-new-form')
    const addNewItemButton = document.getElementById('add-new-item-button')
    const selectItemForm = document.getElementById('select-item-form')
    const selectExistingCompanyButton = document.getElementById('select-existing-company-button')
    const selectExistingCustomerButton = document.getElementById('select-existing-customer-button')
    const totalPriceText = document.getElementById('total-price-text')
    const totalPriceInput = document.getElementById('total-price-input')
    const totalPriceBeforeDiscountText = document.getElementById('total-price-before-discount-text')
    const totalPriceBeforeDiscountInput = document.getElementById('total-price-before-discount-input')
    const discountPercentageInput = document.getElementById('discount-percentage')
    const discountNominalInput = document.getElementById('discount-nominal')
    const paymentTerms = document.getElementById('payment-terms')
    const term = document.getElementById('term')
    const dp = document.getElementById('dp')
    const dpAmount = document.getElementById('dp-amount')
    const dpInput = document.getElementById('dp-input')
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
    // addBreakdown.addEventListener('click', function() {
    //     breakdownCounter = breakdownCounter + 1
    //     const clonedBreakdown = breakdown.cloneNode(true)
    //     clonedBreakdown.id = 'accordionBreakdown' + breakdownCounter

    //     const clonedBreakdownIndex = clonedBreakdown.querySelector('.breakdown-index')
    //     clonedBreakdownIndex.value = breakdownCounter
    //     console.log("Breakdown Counter: " + clonedBreakdownIndex.value)

    //     const clonedBreakdownTitle = clonedBreakdown.querySelector('.breakdown-title')
    //     clonedBreakdownTitle.setAttribute('id', 'breakdown' + breakdownCounter + '-title')
    //     clonedBreakdownTitle.innerHTML = 'Breakdown #' + breakdownCounter

    //     const clonedBreakdownInput = clonedBreakdown.querySelector('.breakdown-input')
    //     clonedBreakdownInput.value = ""
    //     clonedBreakdownInput.setAttribute('data-breakdown-title', 'breakdown' + breakdownCounter + '-title')
    //     clonedBreakdownInput.setAttribute('data-breakdown-title-default', 'Breakdown #' + breakdownCounter)
    //     clonedBreakdownInput.setAttribute('name', `breakdown[${breakdownCounter}][name]`)
        
    //     // const clonedFileInput = clonedBreakdown.querySelector('.testfileinput')
    //     // clonedFileInput.setAttribute('name', `breakdown[${breakdownCounter}][name]`)

    //     clonedBreakdown.querySelector('.add-manual-button').setAttribute('data-breakdown', 'breakdown' + breakdownCounter)
    //     clonedBreakdown.querySelector('.add-manual-button').setAttribute('data-breakdown-counter', 'breakdown' + breakdownCounter)
    //     clonedBreakdown.querySelector('.select-item-button').setAttribute('data-breakdown', 'breakdown' + breakdownCounter)
    //     clonedBreakdown.querySelector('.select-item-button').setAttribute('data-breakdown-counter', 'breakdown' + breakdownCounter)

    //     const clonedBreakdownAccordionButton = clonedBreakdown.querySelector('.accordion-button')
    //     clonedBreakdownAccordionButton.setAttribute('data-bs-target', '#breakdownCollapse' + breakdownCounter)
    //     clonedBreakdownAccordionButton.setAttribute('aria-controls', '#breakdownCollapse' + breakdownCounter)

    //     const clonedBreakdownAccordionCollapse = clonedBreakdown.querySelector('.accordion-collapse')
    //     clonedBreakdownAccordionCollapse.setAttribute('id', 'breakdownCollapse' + breakdownCounter)
    //     clonedBreakdownAccordionCollapse.setAttribute('data-bs-parent', '#accordionBreakdown' + breakdownCounter)

    //     const clonedBreakdownTable = clonedBreakdown.querySelector('.breakdown-table')
    //     clonedBreakdownTable.replaceChildren()
    //     clonedBreakdownTable.setAttribute('id', 'breakdown' + breakdownCounter + '-table')

    //     const deleteBreakdownButton = document.createElement("button")
    //     deleteBreakdownButton.setAttribute("class", "btn btn-danger deleteBreakdownButton")
    //     deleteBreakdownButton.setAttribute("data-remove", `#accordionBreakdown${breakdownCounter}`)
    //     deleteBreakdownButton.innerHTML = "Hapus Breakdown"

    //     clonedBreakdown.querySelector('.deleteBreakdownPlaceholder').appendChild(deleteBreakdownButton)
    //     breakdowns.appendChild(clonedBreakdown)

    //     clonedBreakdown.querySelector('.breakdown-input').addEventListener('keyup', e => {
    //         const title = document.getElementById(e.target.getAttribute('data-breakdown-title'))
    //         title.innerHTML = !clonedBreakdownInput.value || !clonedBreakdownInput.value.trim().length ?
    //             e.target.getAttribute('data-breakdown-title-default') :
    //             clonedBreakdownInput.value
    //     })
    // })

    // Change breakdown title dynamically
    // inputTitle[0].addEventListener('keyup', e => {
    //     const title = document.getElementById(e.target.getAttribute('data-breakdown-title'))
    //     title.innerHTML = !inputTitle[0].value || !inputTitle[0].value.trim().length ?
    //         e.target.getAttribute('data-breakdown-title-default') :
    //         inputTitle[0].value
    // })

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
        discountPercentage = 0
        discountNominal = 0

        let prices = breakdowns.querySelectorAll('.prices')
        let discounts = document.querySelectorAll('.discounts')

        prices.forEach(function(e) {
            totalPrice += parseInt(e.dataset.price)
        })

        // discountPercentage = document.querySelector('#discount-percentage').value * totalPrice / 100
        // discountNominal = document.querySelector('#discount-nominal').value.replaceAll('.', '')

        discountTotal = discountPercentage + discountNominal

        setTotalPriceBeforeDiscount(totalPrice, discountTotal)

        totalPrice = totalPrice - discountPercentage - discountNominal

        if (totalPrice < 0) {
            totalPrice = 0
        }

        setTotalPrice(totalPrice)
        // let dpAmount = setDP(totalPrice, dp.value)
        // setTerm(totalPrice, dpAmount, term.value)
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

    // Show company detail upon selection changing
    companySelect.onchange = function(e) {
        if (!companySelect.value || !companySelect.value.trim().length) {
            selectExistingCompanyButton.classList.add('disabled')
        } else {
            selectExistingCompanyButton.classList.remove('disabled')
        }
    }

    // Show customer detail upon selection changing
    customerSelect.onchange = function(e) {
        if (!customerSelect.value || !customerSelect.value.trim().length) {
            selectExistingCustomerButton.classList.add('disabled')
        } else {
            selectExistingCustomerButton.classList.remove('disabled')
        }
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

    let setCompanyDetail = (data) => {
        customerDetail.querySelector("#shop-name").value = data.name
        customerDetail.querySelector("#shop-address").value = data.address
        customerDetail.querySelector("#shop-telephone-number").value = data.telephoneNumber
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
                            <input class="border-bottom-input" type="text" value="${data.name}" name="breakdown[${breakdownCounter}][item][${itemCounter}][item_name]">
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
        setCompanyDetail(companySelect.options[companySelect.selectedIndex].dataset)
        getCompanyCustomers(companySelect.options[companySelect.selectedIndex].value)
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

    let copyImageToBreakdown = () => {
        const image = addNewForm.elements.namedItem("image").cloneNode(true)
        image.classList.add("visually-hidden")
        image.setAttribute('name', `breakdown[${breakdownCounter}][item][${itemCounter}][image]`)
        image.setAttribute('id', `breakdown[${breakdownCounter}][item][${itemCounter}][image]`)
        document.getElementById(`item${itemCounter}-image-preview`).appendChild(image)
    }

    let invoiceType = (type) => {
        if (type.value == "Deal") {
            paymentTerms.classList.remove('d-none')
        } else {
            paymentTerms.classList.add('d-none')
        }
    }

    let triggerFile = (id) => {
        let inputFile = document.getElementById(id)
        let preview = event.target

        if(confirm("Apakah Anda ingin mengubah gambar item ini?")) {
            inputFile.click()

            inputFile.onchange = e => {
                const file = e.target.files[0]
                if (file) {
                    preview.src = URL.createObjectURL(file)
                } else {
                    preview.src = ""
                }
            }
        }
    }

    async function getCompanyCustomers(companyId = 0) {
        const url = "{{ route('api.getCompanyCustomers', 'x') }}".replace('x', companyId)
        const response = await fetch(url)
        let data = await response.json()
        setCustomers(data.data)
    }

    let setCustomers = (data) => {
        let el = `<option value="">--- Pilih Customer ---</option>`
        data.forEach((customer) => {
            el += `<option value="${customer.id}" data-name="${customer.name}" data-phone-number="${customer.phone_number}" data-address="${customer.address}">${customer.name}</option>`
        })

        customerSelect.replaceChildren()
        customerSelect.innerHTML = el

        customerNiceSelect.update()
    }

    getCompanyCustomers()
</script>
@endpush