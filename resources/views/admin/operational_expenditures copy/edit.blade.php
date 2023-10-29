@extends('layout.template')

@section('title')
Pengeluaran Bahan
@endsection

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#"><svg class="icon icon-xxs" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg></a></li>
            <li class="breadcrumb-item"><a href="#">Pengeluaran Bahan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Pengeluaran Bahan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit Pengeluaran Bahan</h1>
        </div>
    </div>
</div>
<form action="{{ route('material_expenditures.update', $material_expenditures->id) }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="total_price" id="total-price-input" value="{{ $material_expenditures->total_price }}">
    <input type="hidden" name="total_price_before_discount" id="total-price-before-discount-input" value="{{ $material_expenditures->total_price }}">
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
                                            Masukkan data toko...
                                        </button>
                                    </h2>
                                    <div id="customerCollapse" class="accordion-collapse collapse" aria-labelledby="customerData" data-bs-parent="#accordionCustomer">
                                        <div class="accordion-body">
                                            <div id="customer-detail">
                                                <label for="shop-name">Nama Toko</label>
                                                <div class="input-group mb-3">
                                                    <input id="shop-name" type="text" class="form-control" name="shop_name" value="{{ $material_expenditures->shop_name }}">
                                                    <span data-bs-toggle="modal" data-bs-target="#modal-select-company" id="select-customer" style="cursor: pointer;" class="input-group-text" id="basic-addon2">
                                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="shop-telephone-number">Nomor Kantor</label>
                                                    <input id="shop-telephone-number" type="text" class="form-control" id="shop_telephone_number" name="shop_telephone_number" value="{{ $material_expenditures->shop_telephone_number }}">
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="shop-address">Alamat Kantor</label>
                                                    <input id="shop-address" type="text" class="form-control" id="shop_address" name="shop_address" value="{{ $material_expenditures->shop_address }}">
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
                            <!-- <button id="addBreakdown" class="btn btn-primary pull-right" type="button"><i class="fa fa-plus me-1"></i> Tambah Breakdown Baru</button> -->
                        </div>

                        <div class="col-12" id="breakdowns">
                            <div class="accordion mb-2" id="accordionBreakdown">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="breakdown">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#breakdownCollapse" aria-expanded="false" aria-controls="breakdownCollapse">
                                            <span class="breakdown-title" id="breakdown-title">Pengeluaran Bahan</span>
                                        </button>
                                    </h2>
                                    <div id="breakdownCollapse" class="accordion-collapse collapse show" aria-labelledby="breakdown" data-bs-parent="#accordionBreakdown">
                                        <div class="accordion-body">
                                            <label for="">Tanggal</label>
                                            <input type="date" class="form-control w-100 my-2" name="date" value="{{ $material_expenditures->date->format('Y-m-d') }}">
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
                                                        @foreach($material_expenditures->items as $item)
                                                        <tr id="breakdown-item{{ $item->id }}">
                                                            <th class="border-0 rounded-start">
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <button type="button" id="item{{ $item->id }}-remove-button" class="btn btn-sm btn-link text-danger remove-item" onclick='removeItem("#breakdown-item{{ $item->id }}")'>
                                                                            <i class="fa fa-times"></i>
                                                                        </button>
                                                                        <input type="hidden" value="{{ $item->id }}" name="material_expenditure[{{ $item->id }}][id]">
                                                                    </div>
                                                                    <div class="col-8" id="item{{ $item->id }}-image-preview">
                                                                        <h6 class="item-name mt-2">
                                                                            <input class="border-bottom-input w-100" type="text" name="material_expenditure[{{ $item->id }}][item_name]" value="{{ $item->item_name }}" placeholder="Masukkan nama barang...">
                                                                        </h6>
                                                                        <span class="item-dimension">
                                                                            Rp.
                                                                            <input class="border-bottom-input item-price" type="text" value="{{ $item->price }}" data-total-price="#item{{ $item->id }}-total-price" data-qty="#item{{ $item->id }}-qty" name="material_expenditure[{{ $item->id }}][price]">
                                                                        </span> <br>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <th class="border-0 text-center">
                                                                <input id="item{{ $item->id }}-qty" type="number" name="material_expenditure[{{ $item->id }}][qty]" data-price="{{ $item->price }}" data-total-price="#item{{ $item->id }}-total-price" class="form-control item-qty" min="1" value="{{ $item->qty }}">
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
                            <h1 class="h5 mt-2">Total Harga</h1>
                            <h1 class="h4" id="total-price-text">{{ $material_expenditures->formatted_total_price }}</h1>
                            <h1 class="h6 text-danger text-decoration-line-through d-none" id="total-price-before-discount-text">Rp 0</h1>
                            <button type="submit" class="btn btn-success w-100">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

<!-- Modal Select Item -->
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
    let customerNiceSelect = NiceSelect.bind(document.getElementById("customer-nice-select"), {
        searchable: true
    })

    VMasker(document.querySelector(`#new-price`)).maskMoney({
        precision: 0
    })
    
    VMasker(document.querySelectorAll('.item-price')).maskMoney({
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
    const itemSelect = document.getElementById('item-nice-select')
    const itemDetail = document.getElementById('item-detail')
    const customerSelect = document.getElementById('customer-nice-select')
    const customerDetail = document.getElementById('customer-detail')
    const addNewForm = document.getElementById('add-new-form')
    const addNewItemButton = document.getElementById('add-new-item-button')
    const selectItemForm = document.getElementById('select-item-form')
    const selectExistingItemButton = document.getElementById('select-existing-item-button')
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

    // Change breakdown title dynamically
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
            console.log(e.target.getAttribute('data-total-price'))
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

        setTotalPrice(totalPrice)
    }

    let setTotalPrice = (totalPrice) => {
        totalPriceText.innerHTML = rupiahFormat.format(totalPrice)
        totalPriceInput.value = totalPrice
    }

    // Show customer detail upon selection changing
    customerSelect.onchange = function(e) {
        if (!customerSelect.value || !customerSelect.value.trim().length) {
            selectExistingCustomerButton.classList.add('disabled')
        } else {
            selectExistingCustomerButton.classList.remove('disabled')
        }
    }

    let setCustomerDetail = (data) => {
        customerDetail.querySelector("#customer-name").value = data.name
        customerDetail.querySelector("#customer-address").value = data.address
        customerDetail.querySelector("#customer-phone-number").value = data.phoneNumber
    }

    let deleteElement = (id) => {
        const element = document.querySelector(id)
        element.remove()
    }

    let addItem = (data) => {
        let item = document.createElement("tr")
        item.id = `new-${currentBreakdown}-item${++itemCounter}`
        // console.log("Add item to Current Breakdown: " + currentBreakdown)
        item.innerHTML =
            `
            <th class="border-0 rounded-start">
                <div class="row">
                    <div class="col-2">
                        <button type="button" id="new-item${itemCounter}-remove-button" class="btn btn-sm btn-link text-danger remove-item" data-remove-item="#new-${currentBreakdown}-item${itemCounter}">
                            <i class="fa fa-times"></i>
                        </button>
                        <input type="hidden" value="${data.id ?? ''}" name="new_item[${itemCounter}][id]">
                    </div>
                    <div class="col-8" id="item${itemCounter}-image-preview">
                        <h6 class="item-name mt-2">
                            <input class="border-bottom-input" type="text" value="${data.name}" name="new_item[${itemCounter}][item_name]">
                        </h6>
                        <span class="item-dimension mt-2">
                            Rp.  
                            <input id="new-item${itemCounter}-price" data-qty="#new-item${itemCounter}-qty" data-total-price="#new-item${itemCounter}-total-price" class="border-bottom-input item-price" type="text" value="${data.price}" name="new_item[${itemCounter}][price]">
                        </span> <br>
                    </div>
                </div>
            </th>
            <th class="border-0 text-center">
                <input id="new-item${itemCounter}-qty" type="number" name="new_item[${itemCounter}][qty]" data-price="${data.price.replaceAll('.', '')}" data-total-price="#new-item${itemCounter}-total-price" class="form-control item-qty" min="1" value="1">
            </th>
            <th id="new-item${itemCounter}-total-price" class="border-0 rounded-end text-end prices" data-price="${data.price.replaceAll('.', '')}">
                ${rupiahFormat.format(data.price.replaceAll('.', ''))}
            </th>
        `

        let table = breakdowns.querySelector('#' + currentBreakdown + '-table')
        table.appendChild(item)

        breakdowns.querySelector(`#new-item${itemCounter}-remove-button`).addEventListener('click', function(e) {
            breakdowns.querySelector(this.getAttribute('data-remove-item')).remove()
            calculateTotalPrice()
        })

        calculateTotalPrice()

        VMasker(document.querySelector(`#new-item${itemCounter}-price`)).maskMoney({
            precision: 0
        })
    }

    let removeItem = (id) => {
        breakdowns.querySelector(id).remove()
        calculateTotalPrice()
    }

    selectExistingCustomerButton.addEventListener('click', function(e) {
        setCustomerDetail(customerSelect.options[customerSelect.selectedIndex].dataset)
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
</script>
@endpush