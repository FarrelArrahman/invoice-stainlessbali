@extends('layout.template')

@section('title')
Item
@endsection

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="#"><svg class="icon icon-xxs" fill="none" stroke="currentColor"
                        viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg></a></li>
            <li class="breadcrumb-item"><a href="#">Item</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Item</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Edit Item</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow components-section">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12">
                        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="name">Nama</label>
                                <input type="text"
                                    class="form-control" id="name" name="name" value="{{ $item->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Foto</label>
                                <br>
                                <img src="{{ Storage::url($item->image) }}" alt="" width="128px">
                                <input class="form-control" type="file" id="image" name="image">
                            </div>
                            <div class="mb-3">
                                <label for="brand" aria-describedby="brandHelp">Brand</label>
                                <input type="text"
                                    class="form-control" id="brand" name="brand" value="{{ $item->brand }}">
                            </div>
                            <div class="mb-3">
                                <label for="model">Model</label>
                                <input type="text"
                                    class="form-control" id="model" name="model" value="{{ $item->model }}">
                            </div>
                            <div class="mb-3">
                                <div class="row mb-3">
                                    <div class="col-lg-4 col-sm-12 mb-lg-0 mb-sm-3">
                                        <label for="width">Width (mm)</label>
                                        <input type="number"
                                            class="form-control" id="width" name="width" value="{{ $item->width }}">
                                    </div>
                                    <div class="col-lg-4 col-sm-12 mb-lg-0 mb-sm-3">
                                        <label for="depth">Depth (mm)</label>
                                        <input type="number"
                                            class="form-control" id="depth" name="depth" value="{{ $item->depth }}">
                                    </div>
                                    <div class="col-lg-4 col-sm-12 mb-lg-0 mb-sm-3">
                                        <label for="height">Height (mm)</label>
                                        <input type="number"
                                            class="form-control" id="height" name="height" value="{{ $item->height }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        Rp.
                                    </span>
                                    <input type="text" class="form-control" id="price" name="price" value="{{ $item->price }}"></div>
                            </div>
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-select">
                                    @foreach(\App\Enums\StatusEnum::cases() as $status)
                                    <option @selected($status->value == $item->status) value="{{ $status->value }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-block btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
    new DataTable('#example')
</script>
@endpush