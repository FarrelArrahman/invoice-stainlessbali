@extends('layout.template')

@section('title')
Gaji Karyawan
@endsection

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#"><svg class="icon icon-xxs" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg></a></li>
            <li class="breadcrumb-item"><a href="#">Gaji Karyawan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Gaji Karyawan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Tambah Gaji Karyawan</h1>
        </div>
    </div>
</div>
<form onsubmit="checkForm()" action="{{ route('employee_expenditures.store') }}" method="POST" enctype="multipart/form-data">
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
                                            Masukkan data karyawan...
                                        </button>
                                    </h2>
                                    <div id="customerCollapse" class="accordion-collapse collapse" aria-labelledby="customerData" data-bs-parent="#accordionCustomer">
                                        <div class="accordion-body">
                                            <div id="employee-detail">
                                                <label for="employee-name">Nama Karyawan</label>
                                                <div class="input-group mb-3">
                                                    <input id="employee-name" type="text" class="form-control" name="employee_name" readonly>
                                                    <span data-bs-toggle="modal" data-bs-target="#modal-select-employee" id="select-customer" style="cursor: pointer;" class="input-group-text" id="basic-addon2">
                                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="employee-phone-number">Nomor Telepon</label>
                                                    <input id="employee-phone-number" type="text" class="form-control" id="employee_phone_number" name="employee_phone_number" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="employee-address">Alamat</label>
                                                    <input id="employee-address" type="text" class="form-control" id="employee_address" name="employee_address" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="employee-role">Role</label>
                                                    <input id="employee-role" type="text" class="form-control" id="employee_role" name="employee_role" readonly>
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
                            <h1 class="h5 mt-2">Gaji Karyawan</h1>
                            <!-- <button id="addBreakdown" class="btn btn-primary pull-right" type="button"><i class="fa fa-plus me-1"></i> Tambah Breakdown Baru</button> -->
                        </div>

                        <div class="col-12" id="breakdowns">
                            <div class="accordion mb-2" id="accordionBreakdown">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="breakdown">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#breakdownCollapse" aria-expanded="false" aria-controls="breakdownCollapse">
                                            <span class="breakdown-title" id="breakdown1-title">Daftar Gaji Karyawan</span>
                                        </button>
                                    </h2>
                                    <div id="breakdownCollapse" class="accordion-collapse collapse show" aria-labelledby="breakdown" data-bs-parent="#accordionBreakdown">
                                        <div class="accordion-body">
                                            <label for="">Tanggal</label>
                                            <input type="date" class="form-control w-100 my-2" name="date" value="{{ today()->format('Y-m-d') }}">
                                            <button class="add-manual-button btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#modal-add-new" data-breakdown="breakdown1" data-breakdown-counter="1"><i class="fa fa-plus me-1"></i> Input Gaji</button>
                                            <!-- <button class="select-item-button btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-select-item" data-breakdown="breakdown1" data-breakdown-counter="1"><i class="fa fa-list me-1"></i> Pilih Item</button> -->
                                            <span class="deleteBreakdownPlaceholder"></span>
                                            <div class="table-responsive">
                                                <table class="table table-centered mb-0 rounded">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th width="60%" class="border-0">Bulan / Tahun <br> (Gaji per Bulan)</th>
                                                            <th width="15%" class="border-0 text-center">Hari Kerja</th>
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
                            <h1 class="h5 mt-2">Total Gaji</h1>
                            <h1 class="h4" id="total-price-text">Rp 0</h1>
                            <h1 class="h6 text-danger text-decoration-line-through d-none" id="total-price-before-discount-text">Rp 0</h1>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success w-100">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

<!-- Modal Select Technician -->
<div class="modal fade" id="modal-select-employee" tabindex="-1" role="dialog" aria-labelledby="modal-select-employee" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h6 modal-title">Pilih karyawan</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="a-select" class="form-label">Nama</label>
                    <select name="employee_id" id="employee-nice-select" class="select-company w-100" placeholder="Pilih karyawan...">
                        <option value="" disabled selected>--- Pilih karyawan ---</option>
                        @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" data-name="{{ $employee->name }}" data-address="{{ $employee->address }}" data-phone-number="{{ $employee->phone_number }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="select-existing-employee-button" class="btn btn-secondary add-company-data" data-bs-dismiss="modal">Pilih Karyawan</button>
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
                <h2 class="h6 modal-title">Input gaji</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-new-form" runat="server">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name">Bulan</label>
                                <select name="month" id="month-select" class="form-select">
                                    <option value="0" selected disabled>-- Pilih Bulan --</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name">Tahun</label>
                                <input type="number" class="form-control" value="{{ date('Y') }}" name="year">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="price">Gaji (per hari)</label>
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
            employeeDetail.querySelector("#employee-name").value == "" ||
            employeeDetail.querySelector("#employee-phone-number").value == ""
        ) {
            showNotyf("red", "Data karyawan belum diisi")
            event.preventDefault()
        }
    }

    let companyNiceSelect = NiceSelect.bind(document.getElementById("employee-nice-select"), {
        searchable: true
    })
    
    let customerNiceSelect = NiceSelect.bind(document.getElementById("customer-nice-select"), {
        searchable: true
    })

    VMasker(document.querySelector(`#new-price`)).maskMoney({
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
    const employeeDetail = document.getElementById('employee-detail')
    const itemDetail = document.getElementById('item-detail')
    const addNewForm = document.getElementById('add-new-form')
    const addNewItemButton = document.getElementById('add-new-item-button')
    const selectItemForm = document.getElementById('select-item-form')
    const selectExistingEmployeeButton = document.getElementById('select-existing-employee-button')
    const selectExistingCustomerButton = document.getElementById('select-existing-customer-button')
    const totalPriceText = document.getElementById('total-price-text')
    const totalPriceInput = document.getElementById('total-price-input')
    const totalPriceBeforeDiscountText = document.getElementById('total-price-before-discount-text')
    const totalPriceBeforeDiscountInput = document.getElementById('total-price-before-discount-input')
    const discountPercentageInput = document.getElementById('discount-percentage')
    const employeeSelect = document.getElementById('employee-nice-select')
    
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

        let prices = breakdowns.querySelectorAll('.prices')
        let discounts = document.querySelectorAll('.discounts')

        prices.forEach(function(e) {
            totalPrice += parseInt(e.dataset.price)
        })

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

    // Show employee detail upon selection changing
    employeeSelect.onchange = function(e) {
        if (!employeeSelect.value || !employeeSelect.value.trim().length) {
            selectExistingEmployeeButton.classList.add('disabled')
        } else {
            selectExistingEmployeeButton.classList.remove('disabled')
        }
    }

    let setEmployeeDetail = (data) => {
        employeeDetail.querySelector("#employee-name").value = data.name
        employeeDetail.querySelector("#employee-phone-number").value = data.phoneNumber
        employeeDetail.querySelector("#employee-address").value = data.address
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
                    </div>
                    <div class="col-8" id="item${itemCounter}-image-preview">
                        <h6 class="item-name mt-2">
                            <input type="hidden" value="${data.month}" name="breakdown[${breakdownCounter}][item][${itemCounter}][month]">
                            <input type="hidden" value="${data.year}" name="breakdown[${breakdownCounter}][item][${itemCounter}][year]">
                            <input class="border-bottom-input" type="text" value="${data.month_name} ${data.year}" name="breakdown[${breakdownCounter}][item][${itemCounter}][name]" readonly>
                        </h6>
                        <span class="item-dimension mt-2">
                            Rp.  
                            <input id="item${itemCounter}-price" data-qty="#item${itemCounter}-qty" data-total-price="#item${itemCounter}-total-price" class="border-bottom-input item-price" type="text" value="${data.price}" name="breakdown[${breakdownCounter}][item][${itemCounter}][salary_per_day]">
                        </span> <br>
                    </div>
                </div>
            </th>
            <th class="border-0 text-center">
                <input id="item${itemCounter}-qty" type="number" name="breakdown[${breakdownCounter}][item][${itemCounter}][working_day]" data-price="${data.price.replaceAll('.', '')}" data-total-price="#item${itemCounter}-total-price" class="form-control item-qty" min="0" value="1">
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

    selectExistingEmployeeButton.addEventListener('click', function(e) {
        setEmployeeDetail(employeeSelect.options[employeeSelect.selectedIndex].dataset)
    })

    addNewItemButton.onclick = e => {
        const el = addNewForm.elements
        const data = {
            month: el.namedItem("month").value,
            month_name: document.querySelector('#month-select').options[el.namedItem("month").value].text,
            year: el.namedItem("year").value,
            price: el.namedItem("price").value
        }
        addItem(data)
        addNewForm.reset()
    }
</script>
@endpush