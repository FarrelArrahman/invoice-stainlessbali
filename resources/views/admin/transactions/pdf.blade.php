<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
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
                    <img src="{{ asset('img/stainlessbali-header.jpg') }}" align="center" border="0" style="width: 100%;">
                </a>
            </td>
        </tr>
        <tr>
            <td width="100%" style="text-align: center; font-size: 20px; font-weight: bold; padding: 0px;">
                <br>
                INVOICE STAINLESS EQUIPMENT
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
            <tr style="text-transform: uppercase;">
                <td width="5%" style="text-align: center; vertical-align: middle;"><strong>No</strong></td>
                <td width="10%" style="text-align: center; vertical-align: middle;"><strong>Description</strong></td>
                <td width="10%" style="text-align: center;"><strong></strong></td>
                <td width="10%" style="text-align: center; vertical-align: middle;"><strong>Brand</strong></td>
                <td width="10%" style="text-align: center; vertical-align: middle;"><strong>Model</strong></td>
                <td colspan="3" width="10%" style="text-align: center; vertical-align: middle;"><strong>Dimensi <br> (W x D x H)</strong></td>
                <td width="15%" style="text-align: center; vertical-align: middle;"><strong>Price</strong></td>
                <td width="5%" style="text-align: center; vertical-align: middle;"><strong>Qty</strong></td>
                <td width="15%" style="text-align: center; vertical-align: middle;"><strong>Total</strong></td>
            </tr>
        </thead>
        <tbody>
            @foreach($breakdown->items as $item)
            <tr>
                <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $loop->iteration }}</td>
                <td style="padding: 0px 7px; line-height: 20px; vertical-align: middle;">{{ $item->description }}</td>
                <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">
                    <img src="{{ asset($item->image) }}" width="64px">
                </td>
                <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $item->brand }}</td>
                <td style="padding: 0px 7px; line-height: 20px; text-align: center; vertical-align: middle;">{{ $item->model }}</td>
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
                        <td style="border: 1px #000 solid; line-height: 20px;"><strong>Total</strong></td>
                        <td style="border: 1px #000 solid; line-height: 20px;">{{ $transaction->formatted_total_price }}</td>
                    </tr>
                </table>
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
                        <strong>
                        #Prices can change at any time, so please confirm before ordering# <br>
                        #processing 20-25 working days according to the queue <br>
                        </strong> <br>
                        *As a sign of completion, please pay a down payment of at least 50% <br>
                        directly to our location: Jl. Tukad Badung No.104 Renon <br>
                        Or By Transfer : <br>
                        BCA : 7725344511 <br>
                        An : Muhammad Ferrizal Zulkarnain <br>
                        </td>
                    </tr>
                </table>
                <table width="25%" align="right" style="font-family: sans-serif; font-size: 14px;">
                    <tr>
                        <td style="padding: 0px; line-height: 20px; text-align: center;">
                            Hormat kami
                            <br>
                            <br>
                            <img src="{{ asset('img/ttd-stainless.jpg') }}" style="display: block; margin: auto;">
                            <br>
                            Ferrizal Stainless Bali
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <br>
    </table>
</body>

</html>