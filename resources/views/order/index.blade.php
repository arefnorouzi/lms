@extends('layouts.Main')
@section('title', 'فاکتور')
@section('content')
    <style>
        .form-select{
            background-position: left .75rem center;
        }
    </style>

    <!-- Header blog -->
    <section class="blog about-blog blog-white">
        <div class="background"></div>
        <div class="container details">
            <div class="blog-bradcrum">
                <span><a href="/">خانه</a></span>
                <span class="devider">/</span>
                <span><a href="/order">صورتحساب</a></span>
            </div>
            <div class="blog-heading about-heading">
                <h1 class="heading">پرداخت</h1>
            </div>
        </div>
    </section>

    <!-- Main -->
    <section class="checkout product footer-padding">
        <div class="container">
            <table class="table table-bordered table-striped order-table">
                <thead>
                <tr>
                    <tH>#</tH>
                    <tH>جزئیات</tH>
                    <tH>مبلغ</tH>
                    <tH>وضعیت</tH>
                    <tH>کد رهگیری</tH>
                    <tH>تاریخ</tH>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>
                        <a href="/order/{{$order->uuid}}" class="btn btn-primary btn-md">مشاهده</a>
                    </td>

                    <td>{{number_format($order->amount)}}</td>
                    <td>
                        @if(in_array($order->status, array(\App\Enums\OrderStatuses::PAID->value, \App\Enums\OrderStatuses::SHIPPED->value)))
                        <span class="text-success">{{$order->status}}</span>
                        @elseif(in_array($order->status, array(\App\Enums\OrderStatuses::PROCESSING->value, \App\Enums\OrderStatuses::PENDING->value)))
                            <span class="text-danger">{{$order->status}}</span>
                        @else
                            <span class="text-dark">{{$order->status}}</span>
                        @endif
                    </td>
                    <td>
                        {{$order->post_tracking_code}}<br />
                        <span>{{$order?->shipping_method?->title}}</span>
                    </td>
                    <td class="td-date">{{verta($order->updated_at)}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

@endsection
