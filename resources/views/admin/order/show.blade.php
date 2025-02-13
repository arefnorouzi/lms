@extends('layouts.Admin')
@section('title', "فاکتور $order->id")
@section('content')
    <?php $base_url = route('admin.admin-dashboard'); ?>
    <section class="my-5">
        @if(session()->has('message') || session()->has('error'))
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        @endif

        <div class="container-fluid" id="vueapp">
            <div class="row">
                <div class="col-md-7 mb-3">
                    <div class="card shadow">
                        <div class="card-header d-flex">
                            <h4>جزئیات فاکتور</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>عنوان</th>
                                    <th>جزئیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>شناسه</td>
                                    <td>{{$order->id}}</td>
                                </tr>
                                <tr>
                                    <td>کد فاکتور</td>
                                    <td>{{$order->uuid}}</td>
                                </tr>
                                <tr>
                                    <td>مبلغ</td>
                                    <td>{{number_format($order->total)}}</td>
                                </tr>
                                <tr>
                                    <td>هزینه ارسال</td>
                                    <td>{{number_format($order->shipping_cost)}}</td>
                                </tr>
                                <tr>
                                    <td>تخفیف</td>
                                    <td>{{number_format($order->discount)}}</td>
                                </tr>
                                <tr>
                                    <td>جمع</td>
                                    <td>{{number_format($order->amount)}}</td>
                                </tr>
                                <tr>
                                    <td>تاریخ ثبت فاکتور</td>
                                    <td class="td-date">{{verta($order->created_at)}}</td>
                                </tr>
                                <tr>
                                    <td>آخرین بروزرسانی</td>
                                    <td class="td-date">{{verta($order->updated_at)}}</td>
                                </tr>
                                <tr>
                                    <td>تاریخ پرداخت</td>
                                    <td class="td-date">{{$order->purchased_at ? verta($order->purchased_at) : '-'}}</td>
                                </tr>
                                <tr>
                                    <td>تاریخ ارسال</td>
                                    <td class="td-date">{{$order->shipped_at ? verta($order->shipped_at) : '-'}}</td>
                                </tr>
                                <tr>
                                    <td>روش ارسال</td>
                                    <td>{{$order?->shipping_method?->title}}</td>
                                </tr>
                                <tr>
                                    <td>کد رهگیری ارسال</td>
                                    <td>{{$order->post_tracking_code}}</td>
                                </tr>
                                <tr>
                                    <td>شماره تراکنش بانکی</td>
                                    <td>{{$order->bank_trans_id}}</td>
                                </tr>
                                <tr>
                                    <td>کد پرداخت</td>
                                    <td>{{$order->bank_payment_code}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <hr class="my-3">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>محصول</th>
                                    <th>تعداد</th>
                                    <th>قیمت</th>
                                    <th>جمع</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->order_items as $item)
                                <tr>
                                    <td>{{$item->product_name}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>{{number_format($item->unit_price)}}</td>
                                    <td>{{number_format($item->qty * $item->unit_price)}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="card shadow">
                        <div class="card-header">بروزرسانی وضعیت فاکتور</div>
                        <div class="card-body">
                            <form action="{{route('admin.order.update', $order->id)}}" method="post">
                                @csrf
                                {{method_field('PATCH')}}
                                <div class="mb-2">
                                    <label class="form-label">وضعیت فاکتور</label>
                                    <select name="status" class="form-select">
                                        @foreach($statuses as $status)
                                            <option value="{{$status->value}}"
                                                    @if($order->status == $status->value) selected @endif
                                            >{{$status->value}}</option>
                                        @endforeach
                                    </select>
                                    @error('status') <br /> <small class="error">{{ $message }}</small> @enderror

                                </div>
                                <div class="mb-2">
                                    <label class="form-label">نام مشتری</label>
                                    <input type="text" class="form-control" value="{{$order->customer_name}}"
                                           name="customer_name" minlength="3" maxlength="100">
                                    @error('customer_name') <br /> <small class="error">{{ $message }}</small> @enderror

                                </div>
                                <div class="mb-2">
                                    <label class="form-label">تلفن مشتری</label>
                                    <input type="text" class="form-control" value="{{$order->customer_phone}}"
                                           name="customer_phone" minlength="5" maxlength="30">
                                    @error('customer_phone') <br /> <small class="error">{{ $message }}</small> @enderror

                                </div>
                                <div class="mb-2">
                                    <label class="form-label">کد پستی مشتری</label>
                                    <input type="text" class="form-control" value="{{$order->customer_zip_code}}"
                                           name="customer_zip_code" minlength="10" maxlength="10">
                                    @error('customer_zip_code') <br /> <small class="error">{{ $message }}</small> @enderror

                                </div>
                                <div class="mb-2">
                                    <label class="form-label">آدرس مشتری</label>
                                    <input type="text" class="form-control" value="{{$order->customer_address}}"
                                           name="customer_address" minlength="3" maxlength="250">
                                    @error('customer_address') <br /> <small class="error">{{ $message }}</small> @enderror

                                </div>
                                <div class="mb-2">
                                    <label class="form-label">روش ارسال</label>
                                    <select name="shipping_method_id" class="form-select">
                                        @foreach($shipping_methods as $shipping_method)
                                            <option value="{{$shipping_method->id}}"
                                                    @if($order->shipping_method_id == $shipping_method->id) selected @endif
                                            >{{$shipping_method->title}}</option>
                                        @endforeach
                                    </select>
                                    @error('shipping_method_id') <br /> <small class="error">{{ $message }}</small> @enderror

                                </div>
                                <div class="mb-2">
                                    <label class="form-label">تاریخ ارسال</label>
                                    <input type="date" class="form-control" value="{{$order->shipped_at ?? null}}"
                                           name="shipped_at">
                                    @error('shipped_at') <br /> <small class="error">{{ $message }}</small> @enderror

                                </div>
                                <div class="mb-2">
                                    <label class="form-label">کد رهگیری ارسال</label>
                                    <input type="text" class="form-control" value="{{$order->post_tracking_code}}"
                                           name="post_tracking_code" minlength="5" maxlength="100">
                                    @error('post_tracking_code') <br /> <small class="error">{{ $message }}</small> @enderror

                                </div>
                                <div class="my-3 text-center">
                                    <button type="submit" class="btn btn-primary">بروزرسانی فاکتور</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
