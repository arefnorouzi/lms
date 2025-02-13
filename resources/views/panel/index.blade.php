@extends('layouts.Dashboard')
@section('title', 'حساب کاربری')
@section('content')

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
                            <th>وضعیت</th>
                            <th>مبلغ</th>
                            <th>ارسال</th>
                            <th>مبلغ نهایی</th>
                            <th>بروزرسانی</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    <a href="/order/{{$item->uuid}}" class="btn btn-primary btn-md">مشاهده</a>

                                </td>
                                <td>{{$item->status}}</td>
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
                    @if($orders)
                    {{$orders->links()}}
                    @endif
                </div>

            </div>
        </section>
    </div>

@endsection
