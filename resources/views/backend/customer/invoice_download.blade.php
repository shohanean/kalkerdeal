<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>

    <style>
    body {
        color: #f00;
        font-family: Helvetica;
    }
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://www.creativeitinstitute.com/logo.png" style="width:100%; max-width:300px;">
                            </td>

                            <td>

                                Invoice #: {{ $invoice->invoice_no }}<br>
                                Created: {{ $invoice->created_at->format('d/m/Y (h:i:s A)') }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{ env('APP_NAME') }}<br>
                                {{ env('APP_DESCRIPTION') }}<br>

                            </td>

                            <td>
                                {{ auth()->user()->name }}<br>
                                {{ auth()->user()->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Payment Method
                </td>

                <td>
                </td>
            </tr>

            <tr class="details">
                <td>
                    @if ($invoice->payment_option == 'cod')
                        Cash on Delivery
                    @else
                        Online Payment
                    @endif
                </td>

                <td>

                </td>
            </tr>

            <tr class="heading">
                <td>
                    Item
                </td>

                <td>
                    Price
                </td>
            </tr>
            @foreach ($purchase_products as $purchase_product)
            <tr class="item">
                <td>
                    {{ $purchase_product->relationshiptoproduct->name }} x {{ $purchase_product->amount }}
                </td>

                <td>
                    {{ $purchase_product->purchase_price }}
                </td>
            </tr>
            @endforeach
            <tr class="total">
                <td></td>
                <td>
                   Sub Total: {{ $invoice->subtotal }}
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td>
                   Coupon Discount Amount: {{ $invoice->coupon_discount_amount }}
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td>
                   Total: {{ $invoice->total }}
                </td>
            </tr>
        </table>
        @if ($invoice->payment_status == 'unpaid')
            <img width="200" src="https://c8.alamy.com/comp/2G2ER10/payment-due-text-on-red-round-grungy-texture-stamp-2G2ER10.jpg" alt="">
        @else
            <img width="200" src="https://cdn.pixabay.com/photo/2020/04/10/13/23/paid-5025785_1280.png" alt="">
        @endif
    </div>
</body>
</html>
