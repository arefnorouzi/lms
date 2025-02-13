@extends('layouts.Admin')
@section('title', 'مدیریت سفارشات')
@section('content')
    <?php $base_url = route('admin.admin-dashboard'); ?>
    <div>
        <section class="my-5">
            @if(session()->has('message') || session()->has('error'))
                <div class="card shadow">
                    <div class="card-body">
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
                    </div>
                </div>
            @endif

            <div class="card shadow">
                <div class="card-header">
                    <h5>سفارشات اخیر</h5>
                </div>
                <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>جزئیات</th>
                            <th>مشتری</th>
                            <th>وضعیت</th>
                            <th>مبلغ</th>
                            <th>ارسال</th>
                            <th>مبلغ نهایی</th>
                            <th>بروزرسانی</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($model as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    <a href="{{$base_url}}/order/{{$item->id}}"
                                       target="_blank"
                                       class="btn btn-primary btn-sm">مشاهده</a>
                                </td>
                                <td>{{$item->user->name}}</td>
                                <td>
                                    @if(in_array($item->status, array(\App\Enums\OrderStatuses::PAID->value, \App\Enums\OrderStatuses::SHIPPED->value)))
                                        <span class="text-success">{{$item->status}}</span>
                                    @elseif(in_array($item->status, array(\App\Enums\OrderStatuses::PROCESSING->value, \App\Enums\OrderStatuses::PENDING->value)))
                                        <span class="text-danger">{{$item->status}}</span>
                                    @else
                                        <span class="text-dark">{{$item->status}}</span>
                                    @endif
                                </td>
                                <td>{{number_format($item->total)}}</td>
                                <td>{{number_format($item->shipping_cost)}}</td>
                                <td>{{number_format($item->amount)}}</td>
                                <td class="td-date">{{verta($item->updated_at)}}</td>

                            </tr>


                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    @if($model)
                        {{$model->links()}}
                    @endif
                </div>

            </div>
        </section>
    </div>

@endsection
