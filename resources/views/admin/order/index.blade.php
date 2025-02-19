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

            <div class="card shadow" id="vueapp">
                <div class="card-header">
                    <h5>سفارشات اخیر</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <input type="text" class="form-control" placeholder="جستجو..."
                               @keyup.enter="search" v-model="search_text"
                               style="max-width: 300px; float: right; margin-left: .5rem">
                        <button class="btn btn-md btn-outline-primary" @click="search">
                            جستجو
                        </button>
                    </div>
                    <hr />
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>جزئیات</th>
                            <th>مشتری</th>
                            <th>وضعیت</th>
                            <th>مبلغ</th>
                            <th>مبلغ نهایی</th>
                            <th>بروزرسانی</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in models" :key="index">
                                <td>@{{item.id}}</td>
                                <td>
                                    <a :href="`{{$base_url}}/order/${item.id}`"
                                       target="_blank"
                                       class="btn btn-primary btn-sm">مشاهده</a>
                                </td>
                                <td>@{{item?.user?.name}}</td>
                                <td>
                                    <span v-if="item.status === 'پرداخت نشده' || item.status === 'درحال پردازش'"
                                          class="text-danger">@{{ item.status }}</span>
                                    <span v-else class="text-success">@{{ item.status }}</span>
                                </td>
                                <td>@{{item.total.toLocaleString()}}</td>
                                <td>@{{item.shipping_cost.toLocaleString()}}</td>
                                <td>@{{item.amount.toLocaleString()}}</td>
                                <td class="td-date">@{{gregorianToJalali(item.updated_at)}}</td>
                            </tr>

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
@section('script')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        const { createApp } = Vue

        createApp({
            data() {
                return {
                    models: [],
                    message: '',
                    error: '',
                    search_text: ''
                }
            },
            mounted(){
                @if(isset($model))
                    this.models = <?=json_encode($model->items())?>
                    @endif
            },
            methods:{
                gregorianToJalali(date){
                    let formatted_date = new Date(date)
                    return new Intl.DateTimeFormat('fa-IR-u-ca-persian', {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    }).format(formatted_date);
                },
                async search(){
                    this.error = '';
                    this.message = '';
                    fetch("{{$base_url}}/search-order?search=" + this.search_text, {
                        headers: {
                            'Content-type': 'application/json',
                            'Accept': 'application/json'
                        },
                        method: 'GET'
                    }).then(res => {
                        if(res.status >=200 && res.status <= 204)
                        {
                            return res.json()
                        }
                        else if(res.status === 401){
                            this.error = 'لطفا وارد حساب کاربری خود شوید'
                            window.location.replace('/register')
                        }
                        else {
                            this.error = 'خطایی در دریافت رکوردها رخ داد. لطفا دوباره تلاش نمایید'
                        }
                    }).then(data => {
                        this.models = data.data
                    })
                        .catch((error) => {
                            console.log(error);
                            this.error = 'خطایی در دریافت رکوردها رخ داد. لطفا دوباره تلاش نمایید'
                        });
                },
                async restoreItem(id, index){
                    this.error = '';
                    this.message = '';
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    fetch("{{$base_url}}/restore-order/" + id, {
                        headers: {
                            'Content-type': 'application/json',
                            'Accept': 'application/json'
                        },
                        method: 'DELETE',
                        body: JSON.stringify({
                            _token: token.content
                        })
                    }).then(res => {
                        if(res.status >=200 && res.status <= 204)
                        {
                            this.message = 'رکورد با موفقیت بازیابی شد';
                            this.models[index].deleted_at = null
                        }
                        else if(res.status === 401){
                            this.error = 'لطفا وارد حساب کاربری خود شوید'
                            window.location.replace('/register')
                        }
                        else {
                            this.error = 'خطایی در بازیابی رکورد رخ داد. لطفا دوباره تلاش نمایید'
                        }
                    }).catch((error) => {
                        console.log(error);
                        this.error = 'خطایی در بازیابی رکورد رخ داد. لطفا دوباره تلاش نمایید'
                    });

                },
                async deleteitem(id, index){
                    this.error = '';
                    this.message = '';
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    fetch("{{$base_url}}/order/" + id, {
                        headers: {
                            'Content-type': 'application/json',
                            'Accept': 'application/json'
                        },
                        method: 'DELETE',
                        body: JSON.stringify({
                            _token: token.content
                        })
                    }).then(res => {
                        if(res.status >=200 && res.status <= 204)
                        {
                            this.message = 'رکورد با موفقیت حذف شد';
                            this.models[index].deleted_at = true
                        }
                        else if(res.status === 401){
                            this.error = 'لطفا وارد حساب کاربری خود شوید'
                            window.location.replace('/register')
                        }
                        else {
                            this.error = 'خطایی در حذف رکورد رخ داد. لطفا دوباره تلاش نمایید'
                        }
                    }).catch((error) => {
                        console.log(error);
                        this.error = 'خطایی در حذف رکورد رخ داد. لطفا دوباره تلاش نمایید'
                    });

                }
            }
        }).mount('#vueapp')
    </script>
@endsection
