@extends('layouts.Admin')
@section('title', 'مدیریت روش های ارسال')
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


            <div class="card shadow" id="vueapp">

                <div class="card-header d-flex">
                    <h5>مدیریت روش های ارسال</h5>
                </div>
                <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>هزینه</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($model as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->title}}</td>
                            <td>{{number_format($item->price)}} تومان</td>
                            <td>
                                @if($item->status)
                                    <span class="text-success">فعال</span>
                                @else
                                    <span class="text-danger">غیرفعال</span>
                                @endif
                            </td>
                            <td class="d-inline">
                                <button class="btn btn-info btn-sm" type="button"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal-{{$item->id}}"
                                >ویرایش</button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel-{{$item->id}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel-{{$item->id}}">ویرایش: {{$item->title}}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('admin.shipping.update', $item->id)}}" method="post">
                                        @csrf
                                        {{method_field('PATCH')}}

                                    <div class="modal-body">
                                        <p>ویرایش روش ارسال</p>
                                        <div class="my-3">
                                            <label class="form-label">عنوان</label>
                                            <input type="text" name="title" class="form-control" value="{{$item->title}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">هزینه</label>
                                            <input type="text" name="price" class="form-control" value="{{$item->price}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">وضعیت</label>
                                            <select name="status" class="form-select">
                                                <option value="0" @if($item->status == 0) selected @endif>غیرفعال</option>
                                                <option value="1" @if($item->status == 1) selected @endif>فعال</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                                        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    @if($model)
                        {{$model->links('vendor.pagination')}}
                    @endif
                </div>

            </div>
        </section>
    </div>

@endsection
