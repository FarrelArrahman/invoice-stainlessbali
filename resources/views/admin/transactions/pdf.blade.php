<html>

<head>
    <style>
        * {
            font-family: sans-serif;
            font-size: 8pt;
        }

        p {
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
    </style>
</head>

<body>
    <table width="100%" style="font-family: sans-serif;" cellpadding="10">
        <tr>
            <td width="100%" style="padding: 0px; text-align: center;">
                <a href="#" target="_blank">
                    <img src="{{ asset('img/dewatakitchen-header2.jpg') }}" align="center" border="0" style="width: 100%;">
                </a>
            </td>
        </tr>
        <tr>
            <td width="100%" style="text-align: center; font-size: 20px; font-weight: bold; padding: 0px;">
                <br>
                {{ str()->upper($transaction->invoice_type) }} KITCHEN EQUIPMENT
            </td>
        </tr>
        <tr>
            <td height="10" style="font-size: 0px; line-height: 10px; height: 10px; padding: 0px;">&nbsp;</td>
        </tr>
    </table>
    <table width="100%" style="font-family: sans-serif;" cellpadding="10">
        <tr>
            <td width="49%" style=""><strong>Kepada: {{ $transaction->customer->name }}</strong></td>
            <td width="2%">&nbsp;</td>
            <td width="49%" style=" text-align: right;"><strong>{{ $transaction->date->isoFormat('DD MMMM Y') }}</strong></td>
        </tr>
    </table>
    <br>

    @foreach($transaction->breakdowns as $breakdown)
    <table border="1" class="items" width="100%" style="font-size: 11px; border-collapse: collapse;" cellpadding="8">
        <thead>
            <tr>
                <td colspan="11" style="text-align: left">{{ $breakdown->breakdown_name }}</td>
            </tr>
            <tr style="text-transform: uppercase;">
                <td rowspan="2" width="5%" style="text-align: center; vertical-align: middle;"><strong>No</strong></td>
                <td rowspan="2" width="20%" style="text-align: center; vertical-align: middle;"><strong>Nama</strong></td>
                <td rowspan="2" width="10%" style="text-align: center;"><strong>Preview</strong></td>
                <td colspan="3" width="10%" style="text-align: center; vertical-align: middle;"><strong>Size (mm)</strong></td>
                <td rowspan="2" width="25%" style="text-align: center; vertical-align: middle;"><strong>Price</strong></td>
                <td rowspan="2" width="5%" style="text-align: center; vertical-align: middle;"><strong>Qty</strong></td>
                <td rowspan="2" width="25%" style="text-align: center; vertical-align: middle;"><strong>Total</strong></td>
            </tr>
            <tr style="text-transform: uppercase;">
                <td style="text-align: center; vertical-align: middle;"><strong>P</strong></td>
                <td style="text-align: center; vertical-align: middle;"><strong>L</strong></td>
                <td style="text-align: center; vertical-align: middle;"><strong>T</strong></td>
            </tr>
        </thead>
        <tbody>
            @foreach($breakdown->items as $item)
            <tr>
                <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $loop->iteration }}</td>
                <td style="padding: 0px 7px; line-height: 20px; vertical-align: middle;">
                    <p style="white-space: pre-line;">{{ $item->name }}</p>
                    <strong>Brand</strong>: {{ $item->brand }}<br>
                    <strong>Type</strong>: {{ $item->model }}<br>
                </td>
                <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">
                    <img style="padding: 5px;" src="{{ $item->item_id == NULL || Storage::exists($item->image) ? Storage::url($item->image) : asset('img/no_image.jpg') }}" width="96px">
                </td>
                <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $item->width }}</td>
                <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $item->depth }}</td>
                <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $item->height }}</td>
                <td style="padding: 0px 7px; line-height: 20px; text-align: right; vertical-align: middle;">{{ $item->formatted_price }}</td>
                <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $item->qty }}</td>
                <td style="padding: 0px 7px; line-height: 20px; text-align: right; vertical-align: middle;">{{ $item->formatted_total_price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    @endforeach
    
    <table width="100%" style="font-family: sans-serif; font-size: 14px;">
        <tr>
            <td>
                <table width="60%" align="left" style="font-family: sans-serif; font-size: 14px;">
                    <tr>
                        <td style="padding: 0px; line-height: 20px;">&nbsp;</td>
                    </tr>
                </table>
                <table cellpadding="10" width="40%" align="right" style="font-family: sans-serif; font-size: 14px;">
                    <tr>
                        <td style="border: 1px #000 solid; line-height: 20px; width: 30%"><strong>Total</strong></td>
                        <td style="border: 1px #000 solid; line-height: 20px; width: 70%">{{ $transaction->formatted_total_price }}</td>
                    </tr>
                </table>
                <br>
                @if($transaction->invoice_type == "Deal")
                <table cellpadding="10" width="40%" align="right" style="font-family: sans-serif; font-size: 14px;">
                    <tr>
                        <td style="border: 1px #000 solid; line-height: 20px; width: 30%"><strong>DP</strong></td>
                        <td style="border: 1px #000 solid; line-height: 20px; width: 70%">{{ $transaction->formatted_dp }}</td>
                    </tr>
                </table>
                <table cellpadding="10" width="40%" align="right" style="font-family: sans-serif; font-size: 14px;">
                    <tr>
                        <td style="border: 1px #000 solid; line-height: 20px; width: 30%"><strong>Termin 1</strong></td>
                        <td style="border: 1px #000 solid; line-height: 20px; width: 70%">{{ $transaction->amount_per_termin }}</td>
                    </tr>
                </table>
                <table cellpadding="10" width="40%" align="right" style="font-family: sans-serif; font-size: 14px;">
                    <tr>
                        <td style="border: 1px #000 solid; line-height: 20px; width: 30%"><strong>Termin 2</strong></td>
                        <td style="border: 1px #000 solid; line-height: 20px; width: 70%">{{ $transaction->amount_per_termin }}</td>
                    </tr>
                </table>
                @if($transaction->payment_terms > 2)
                <table cellpadding="10" width="40%" align="right" style="font-family: sans-serif; font-size: 14px;">
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
    <br>
    
    <table width="100%" style="font-family: sans-serif; font-size: 14px;">
        <br>
        <tr>
            <td>
                <table width="75%" align="left" style="font-family: sans-serif; font-size: 13px; text-align: left;">
                    <tr>
                        <td style="padding: 0px; line-height: 20px;">
                        Note <br>
                        {!! $transaction->note !!}
                        </td>
                    </tr>
                </table>
                <table width="25%" align="right" style="font-family: sans-serif; font-size: 14px;">
                    <tr>
                        <td style="padding: 0px; line-height: 20px; text-align: center;">
                            Hormat kami
                            <br>
                            <br>
                            <img width="128px" src="{{ asset('img/logo-dewata-kitchen.png') }}" style="display: block; margin: auto;">
                            <br>
                            Ferrizal Dewata Kitchen
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <br>
    </table>
</body>

</html>