<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>چاپ فاکتور</title>

    <link rel="stylesheet" href="/css/print-styles.css">
</head>
<body>

<main>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8" id="factor-print">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="factor-content">
                            <table class="table table-bordered factor-table text-center">
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
                                    <td class="td-date">مشتری:
                                        {{$order->customer_name}}
                                    </td>

                                    <td class="td-date">کد پستی
                                        @if($order->zip_code): {{$order->zip_code}} @endif
                                    </td>
                                    <td colspan="3">تلفن:
                                        {{$order->customer_phone}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">آدرس مشتری: {{$order->customer_address}}</td>
                                </tr>

                                </thead>
                            </table>
                            <hr />
                            <table class="table table-bordered table-striped">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>
