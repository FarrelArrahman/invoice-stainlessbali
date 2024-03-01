@extends('layout.template')

@section('title')
Invoice
@endsection

@push('custom-css')
<style>
    #page-container {
        font-family: sans-serif;
        font-size: 10pt;
    }

    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 5cm;
    }

    body {
        counter-reset: page;
        margin-top: 2.5cm;
    }
    

    table.items p {
        margin: 0pt;
    }

    table.items {
        border: 0.1mm solid #e7e7e7;
    }

    td {
        vertical-align: top;
    }

    .items td {
        border: 1px solid #000;
    }

    table thead td {
        text-align: center;
        border: 0.1mm solid #e7e7e7;
    }

    .items td.blanktotal {
        background-color: #EEEEEE;
        border: 0.1mm solid #e7e7e7;
        background-color: #FFFFFF;
        border: 0mm none #e7e7e7;
        border-top: 0.1mm solid #e7e7e7;
        border-right: 0.1mm solid #e7e7e7;
    }

    .items td.totals {
        text-align: right;
        border: 0.1mm solid #e7e7e7;
    }

    .items td.cost {
        text-align: "." center;
    }

    .page-number:after {
        counter-increment: page;
        content: counter(page) " halaman";
    }
</style>
@endpush

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Invoice</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $transaction->code }}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">{{ $transaction->code }}</h1>
        </div>
    </div>
</div>

<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div id="page-container">
            <table width="100%" style="font-family: sans-serif;" cellpadding="10">
                <tr>
                    <td width="100%" style="text-align: center; font-size: 20px; font-weight: bold; padding: 0px;">
                        <br>
                        {{ str()->upper($transaction->invoice_type) }} KITCHEN EQUIPMENT
                        <br>
                        <span class="font-size: 8pt">{{ $transaction->code }}</span>
                    </td>
                </tr>
                <tr>
                    <td height="10" style="font-size: 0px; line-height: 10px; height: 10px; padding: 0px;">&nbsp;</td>
                </tr>
            </table>
            <table width="100%" style="font-family: sans-serif;" cellpadding="10">
                <tr>
                    <td width="50%">
                        <table border="0" width="75%" style="border-collapse: collapse;">
                            <tr>
                                <td>Kepada</td>
                                <td>:</td>
                                <td>{{ $transaction->customer->name }}</td>
                            </tr>
                            <tr>
                                <td>Ket</td>
                                <td>:</td>
                                <td>{{ $transaction->invoice_type }}</td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" style=" text-align: right;">
                        <table border="0" width="75%" style="border-collapse: collapse; float: right;">
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td>{{ $transaction->date->isoFormat('DD MMMM Y') }}</td>
                            </tr>
                            <tr>
                                <td>Terlampir</td>
                                <td>:</td>
                                <td class="page-number"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br>

            <table border="1" class="items" width="100%" style="border-collapse: collapse;" cellpadding="8">
                <thead>
                    <tr style="background-color: #333; color: #fff">
                        <td rowspan="2" width="5%" style="text-align: center; vertical-align: middle;"><strong>No</strong></td>
                        <td rowspan="2" width="20%" style="text-align: center; vertical-align: middle;"><strong>Nama</strong></td>
                        <td rowspan="2" width="10%" style="text-align: center; vertical-align: middle;"><strong>Preview</strong></td>
                        <td colspan="3" width="10%" style="text-align: center; vertical-align: middle;"><strong>Size (mm)</strong></td>
                        <td rowspan="2" width="20%" style="text-align: center; vertical-align: middle;"><strong>Price</strong></td>
                        <td rowspan="2" width="5%" style="text-align: center; vertical-align: middle;"><strong>Qty</strong></td>
                        <td rowspan="2" width="20%" style="text-align: center; vertical-align: middle;"><strong>Total</strong></td>
                    </tr>
                    <tr style="text-transform: uppercase; background-color: #333; color: #fff">
                        <td style="text-align: center; vertical-align: middle;"><strong>P</strong></td>
                        <td style="text-align: center; vertical-align: middle;"><strong>L</strong></td>
                        <td style="text-align: center; vertical-align: middle;"><strong>T</strong></td>
                    </tr>
                </thead>
                <tbody>
                @foreach($transaction->breakdowns as $breakdown)
                    <tr>
                        <td colspan="8" style="text-align: left"><strong>{{ $breakdown->breakdown_name }}</strong></td>
                        <td style="text-align: right">{{ $breakdown->formatted_total_price }}</td>
                    </tr>
                    @foreach($breakdown->items as $item)
                    <tr>
                        <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $loop->iteration }}</td>
                        <td style="padding: 0px 7px; line-height: 20px; vertical-align: middle;">
                            <p style="white-space: pre-line; font-size: 12pt">{{ $item->name }}</p>
                            <strong>Brand</strong>: {{ $item->brand }}<br>
                            <strong>Type</strong>: {{ $item->model }}<br>
                        </td>
                        <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">
                            @if($item->item_id != NULL)
                            <img style="padding: 5px;" src="{{ Storage::url($item->item->image) }}" width="48px">
                            @elseif($item->item_id == NULL && $item->image != NULL)
                            <img style="padding: 5px;" src="{{ Storage::url($item->image) }}" width="48px">
                            @endif
                        </td>
                        <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $item->width > 0 ? $item->width : "" }}</td>
                        <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $item->depth > 0 ? $item->depth : "" }}</td>
                        <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $item->height > 0 ? $item->height : "" }}</td>
                        <td style="padding: 0px 7px; line-height: 20px; text-align: right; vertical-align: middle;">{{ $item->formatted_price }}</td>
                        <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $item->qty > 0 ? $item->qty : "" }}</td>
                        <td style="padding: 0px 7px; line-height: 20px; text-align: right; vertical-align: middle;">{{ $item->formatted_total_price }}</td>
                    </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>

            @if(count($transaction->breakdowns) > 1)
            <table width="100%" style="font-family: sans-serif;">
                <tr>
                    <td>
                        <table width="60%" align="left" style="font-family: sans-serif;">
                            <tr>
                                <td style="padding: 0px; line-height: 20px;">&nbsp;</td>
                            </tr>
                        </table>
                        <table cellpadding="10" width="40%" align="right" style="font-family: sans-serif;">
                            <tr>
                                <td style="border: 1px #000 solid; line-height: 20px; width: 30%"><strong>Total</strong></td>
                                <td style="border: 1px #000 solid; line-height: 20px; width: 70%">{{ $transaction->formatted_total_price }}</td>
                            </tr>
                        </table>
                        <br>
                        @if($transaction->invoice_type == "Deal")
                        <table cellpadding="10" width="40%" align="right" style="font-family: sans-serif;">
                            <tr>
                                <td style="border: 1px #000 solid; line-height: 20px; width: 30%"><strong>DP</strong></td>
                                <td style="border: 1px #000 solid; line-height: 20px; width: 70%">{{ $transaction->formatted_dp }}</td>
                            </tr>
                        </table>
                        <table cellpadding="10" width="40%" align="right" style="font-family: sans-serif;">
                            <tr>
                                <td style="border: 1px #000 solid; line-height: 20px; width: 30%"><strong>Termin 1</strong></td>
                                <td style="border: 1px #000 solid; line-height: 20px; width: 70%">{{ $transaction->amount_per_termin }}</td>
                            </tr>
                        </table>
                        <table cellpadding="10" width="40%" align="right" style="font-family: sans-serif;">
                            <tr>
                                <td style="border: 1px #000 solid; line-height: 20px; width: 30%"><strong>Termin 2</strong></td>
                                <td style="border: 1px #000 solid; line-height: 20px; width: 70%">{{ $transaction->amount_per_termin }}</td>
                            </tr>
                        </table>
                        @if($transaction->payment_terms > 2)
                        <table cellpadding="10" width="40%" align="right" style="font-family: sans-serif;">
                            <tr>
                                <td style="border: 1px #000 solid; line-height: 20px; width: 30%"><strong>Termin 3</strong></td>
                                <td style="border: 1px #000 solid; line-height: 20px; width: 70%">{{ $transaction->amount_per_termin }}</td>
                            </tr>
                        </table>
                        @endif
                        @endif
                    </td>
                </tr>
            </table>
            @endif
            <br>

            <div style="width: 100%; height: auto;">
                {!! $transaction->note !!}
            </div>

            <table width="100%" align="left" style="margin-top: 2cm; font-family: sans-serif; text-align: left;">
                <tr>
                    <td width="50%" style="padding: 0px; line-height: 20px; text-align: center;">
                        Hormat kami
                        <br>
                        <br>
                        <img width="128px" src="{{ asset('img/logo-dewata-kitchen.png') }}" style="display: block; margin: auto;">
                        <br>
                        Ferrizal Dewata Kitchen
                    </td>
                    <td width="50%" style="padding: 0px; line-height: 20px; text-align: center;">
                        Customer
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td width="50%" style="padding: 0px; line-height: 20px; text-align: center;">
                        <hr style="width: 50%; margin: auto">
                        Owner
                    </td>
                    <td width="50%" style="padding: 0px; line-height: 20px; text-align: center;">
                        <hr style="width: 50%; margin: auto">
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
</script>
@endpush