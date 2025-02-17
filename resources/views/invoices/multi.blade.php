<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
    <style>
        @font-face {
            font-family: Vazir;
            font-style: normal;
            font-weight: normal;
            src: url('Vazir.eot');
            src: url('Vazir.eot?#iefix') format('embedded-opentype'),
            url('Vazir.woff2') format('woff2'),
            url('Vazir.woff') format('woff');
            url('Vazir.ttf') format('ttf');
        }
        body {
            font-family: Vazir, sans-serif !important;
            direction: rtl;
            text-align: right;
            justify-content: center;
            font-size: 13px;
        }
        .page-break { page-break-after: always; }

        .factor-content{
            max-width: 1748px;
            max-height: 1240px;
            width: auto;
            height: auto;
            justify-content: center;
            padding: 10px;
        }

        .factor-table{
            border: 1px solid #666666;
            border-radius: 0.5rem;
            font-size: 13px;
            width: 100%;
        }

        .factor-table td{
            padding: .5rem;
            text-align: center;
            border: 1px solid #ccc;
        }

        .items-row-dark{
            background-color: #CCCCCC;
        }

    </style>

</head>
<body>
@foreach ($invoices as $order)
    <div class="factor-content">
        <table class="table factor-table text-center">
            <thead>
            <tr>
                <td colspan="5">
                    <h5 style="font-weight: bold">caspiweb.ir</h5>
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    تلفن شرکت: 09192138510
                </td>
                <td colspan="3">آدرس شرکت: گیلان، رشت</td>
            </tr>
            <tr>
                <td colspan="2">شماره فاکتور:
                    {{$order->id}}
                </td>
                <td class="td-date" colspan="3">تاریخ:
                    {{verta($order->purchased_at)->format('d-m-Y')}}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="td-date">مشتری:
                    {{$order->customer_name}}
                </td>

                <td class="td-date">کد پستی
                    @if($order->zip_code): {{$order->zip_code}} @endif
                </td>
                <td colspan="2">تلفن:
                    {{$order->customer_phone}}
                </td>
            </tr>
            <tr>
                <td colspan="5">آدرس مشتری: {{$order->customer_address}}</td>
            </tr>

            </thead>
        </table>
        <hr />
        <table class="table factor-table text-center">
            <thead>
            <tr>
                <td>#</td>
                <td>محصول</td>
                <td>تعداد</td>
                <td>فی</td>
                <td>جمع</td>
            </tr>
            </thead>
            <tbody>
                <?php $counter = 0;?>
            @foreach($order->order_items as $item)
                    <?php $counter++;?>
                   <tr>
                    <td>{{$counter}}</td>
                    <td>{{$item->product_name}}</td>
                    <td>{{$item->qty}}</td>
                    <td>{{number_format($item->unit_price)}}</td>
                    <td>{{number_format($item->unit_price * $item->qty)}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2">جمع محصولات: {{number_format($order->total)}} تومان</td>
                <td>هزینه ارسال: {{number_format($order->shipping_cost)}} تومان</td>
                <td colspan="2">مبلغ پرداختی: {{number_format($order->amount)}} تومان</td>

            </tr>
            </tfoot>
        </table>
        <p class="pe-2">* مبالغ به تومان میباشد</p>
    </div>


    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>
