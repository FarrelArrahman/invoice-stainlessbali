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
                                        <span class="breakdown-title" id="breakdown1-title">Breakdown #1</span>
                                    </button>
                                </h2>
                                <div id="breakdownCollapse" class="accordion-collapse collapse show" aria-labelledby="breakdown" data-bs-parent="#accordionBreakdown">
                                    <div class="accordion-body">
                                        <label for="">Nama Breakdown</label>
                                        <input type="text" class="form-control w-100 my-2 breakdown-input" data-breakdown-title="breakdown1-title" data-breakdown-title-default="Breakdown #1" name="name" placeholder="Masukkan nama breakdown...">
                                        <button class="add-manual-button btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#modal-add-manual" data-breakdown="breakdown1"><i class="fa fa-plus me-1"></i> Tambah Manual</button>
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
                <form id="select-item-form">
                    @csrf
                    <div class="mb-3">
                        <label for="a-select" class="form-label">Nama</label>
                        <select name="name" id="a-select" class="select-item w-100" placeholder="Pilih item...">
                            <option value="" disabled selected>--- Pilih item ---</option>
                            @foreach($items as $item)
                            <option 
                                value="{{ $item->id }}"
                                data-image="{{ $item->image_real_path }}"
                                data-brand="{{ $item->brand }}"
                                data-model="{{ $item->model }}"
                                data-width="{{ $item->width }}"
                                data-depth="{{ $item->depth }}"
                                data-height="{{ $item->height }}"
                                data-price="{{ $item->price }}">{{ $item->name }}</option>
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

<div class="modal fade" id="modal-add-manual" tabindex="-1" role="dialog" aria-labelledby="modal-add-manual" aria-hidden="true">
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
    let itemCounter = 1
    let currentBreakdown = "breakdown1"
    let itemSelected = false
    
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

    const rupiahFormat = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    });


    // Add new breakdown upon clicking
    addBreakdown.addEventListener('click', function() {
        const clonedBreakdown = breakdown.cloneNode(true)
        clonedBreakdown.id = 'accordionBreakdown' + ++breakdownCounter
        
        const clonedBreakdownTitle = clonedBreakdown.querySelector('.breakdown-title')
        clonedBreakdownTitle.setAttribute('id', 'breakdown' + breakdownCounter + '-title')
        clonedBreakdownTitle.innerHTML = 'Breakdown #' + breakdownCounter
        
        const clonedBreakdownInput = clonedBreakdown.querySelector('.breakdown-input')
        clonedBreakdownInput.value = ""
        clonedBreakdownInput.setAttribute('data-breakdown-title', 'breakdown' + breakdownCounter + '-title')
        clonedBreakdownInput.setAttribute('data-breakdown-title-default', 'Breakdown #' + breakdownCounter)
        
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
            title.innerHTML = ! clonedBreakdownInput.value || ! clonedBreakdownInput.value.trim().length 
                ? e.target.getAttribute('data-breakdown-title-default')
                : clonedBreakdownInput.value
        })
    })

    // Change breakdown title dynamically
    inputTitle[0].addEventListener('keyup', e => {
        const title = document.getElementById(e.target.getAttribute('data-breakdown-title'))
        title.innerHTML = ! inputTitle[0].value || ! inputTitle[0].value.trim().length 
            ? e.target.getAttribute('data-breakdown-title-default')
            : inputTitle[0].value
    })

    breakdowns.addEventListener('click', function(e) {
        if(e.target.classList.contains('deleteBreakdownButton')) {
            deleteElement(e.target.getAttribute('data-remove'))
        } else if(e.target.classList.contains('add-manual-button') || e.target.classList.contains('select-item-button')) {
            currentBreakdown = e.target.getAttribute('data-breakdown')
        } else if(e.target.classList.contains('item-qty')) {
            let totalPrice = e.target.value * e.target.getAttribute('data-price')
            const totalPriceText = breakdowns.querySelector(e.target.getAttribute('data-total-price'))
            totalPriceText.innerHTML = rupiahFormat.format(totalPrice)
        }
    })

    breakdowns.addEventListener('keyup', function(e) {
        if(e.target.classList.contains('item-qty')) {
            if(e.target.value == "" || e.target.value < 1) {
                e.target.value = 1
            }
            let totalPrice = e.target.value * e.target.getAttribute('data-price')
            const totalPriceText = breakdowns.querySelector(e.target.getAttribute('data-total-price'))
            totalPriceText.innerHTML = rupiahFormat.format(totalPrice)
        }
    })

    // Show item detail upon selection changing
    itemSelect.onchange = function(e) {
        if(! itemSelect.value || ! itemSelect.value.trim().length) {
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
        
        if(Object.keys(data).length === 0 && data.constructor === Object) {
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
        if(! image || ! image.trim().length) {
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
                        <img src="${data.image}">
                    </div>
                    <div class="col-8">
                        <h6 class="item-name mt-2">${data.name}</h6>
                        <span class="item-brand">Brand: ${data.brand}</span> <br>
                        <span class="item-model">Model: ${data.model}</span> <br>
                        <span class="item-dimension">Dimension: ${data.dimension}</span> <br>
                        <span class="item-dimension">Price: ${rupiahFormat.format(data.price)}</span> <br>
                    </div>
                </div>
            </th>
            <th class="border-0 text-center">
                <input type="number" name="item-qty" data-price="${data.price}" data-total-price="#item${itemCounter}-total-price" class="form-control item-qty" min="1" value="1">
            </th>
            <th id="item${itemCounter}-total-price" class="border-0 rounded-end text-end">
                ${rupiahFormat.format(data.price)}
            </th>
        `

        let table = breakdowns.querySelector('#' + currentBreakdown + '-table')
        table.appendChild(item)

        breakdowns.querySelector(`#item${itemCounter}-remove-button`).addEventListener('click', function (e) {
            breakdowns.querySelector(this.getAttribute('data-remove-item')).remove()
        })
    }
    
    addItemToBreakdown.forEach((item) => {
        item.addEventListener('click', function (e) {
            const el = selectItemForm.elements
            const data = {
                name: itemSelect.options[el.namedItem("name").value].text,
                image: el.namedItem("image_path").value,
                brand: el.namedItem("brand").value,
                model: el.namedItem("model").value,
                dimension: el.namedItem("width").value + " x " + el.namedItem("depth").value + " x " + el.namedItem("height").value,
                price: el.namedItem("price").value
            }
            addItem(data)
        })
    })
    
    let modalSelectItem = document.getElementById('modal-select-item')
    modalSelectItem.addEventListener('hidden.bs.modal', function (event) {
        showItemDetail(false)
        setItemDetail({})
        niceSelect.clear()
    })

    addNewImageInput.onchange = e => {
        const file = e.target.files[0]
        if(file) {
            addNewImagePreview.classList.remove('d-none')
            addNewImagePreview.src = URL.createObjectURL(file)
        } else {
            addNewImagePreview.classList.add('d-none')
            addNewImagePreview.src = ""
        }
    }
</script>
@endpush