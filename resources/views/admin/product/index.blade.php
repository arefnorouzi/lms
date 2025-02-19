@extends('layouts.Admin')
@section('title', 'مدیریت محصولات')
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
                    <h5>مدیریت محصولات</h5>
                    <a href="{{route('admin.product.create')}}" class="btn btn-sm btn-primary me-auto">افزودن محصول</a>
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
                        <div style="min-height: 70px;">
                            <div v-if="message" class="alert alert-success">
                                @{{ message }}
                            </div>
                            <div v-if="error" class="alert alert-danger">
                                @{{ error }}
                            </div>
                        </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>محصول</th>
                            <th>قیمت</th>
                            <th>قیمت تخفیفی</th>
                            <th>موجودی</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in models" :key="index">
                                <td>@{{item.id}}</td>
                                <td>@{{item.name}}</td>
                                <td>@{{item.price.toLocaleString()}}</td>
                                <td>
                                    <span v-if="item.offer_price && item.offer_end_date > today" class="text-success">
                                        @{{item.offer_price.toLocaleString()}}</span>
                                    <span v-else-if="item.offer_price">
                                        @{{item.offer_price.toLocaleString()}}</span>
                                </td>
                                <td>@{{item.stock}}</td>
                                <td class="actions-btns d-inline">
                                    <a :href="`{{$base_url}}/product/${item.id}`" target="_blank"
                                       class="btn btn-outline-info btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/></svg>
                                    </a>
                                    <a :href="`{{$base_url}}/product/${item.id}/edit`" target="_blank"
                                       class="btn btn-outline-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                    </a>

                                    <button v-if="item.status" @click="deleteitem(item.id, index)"
                                        class="btn btn-warning btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"/></svg>
                                    </button>
                                    <button v-else @click="restoreItem(item.id, index)"
                                            class="btn btn-sm btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"/></svg>
                                    </button>


                                </td>
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
                    search_text: '',
                    today: "{{today()->format('Y-m-d')}}"
                }
            },
            mounted(){
                @if(isset($model))
                    this.models = <?=json_encode($model->items())?>
                    @endif
            },
            methods:{
                async search(){
                    this.error = '';
                    this.message = '';
                    fetch("{{$base_url}}/search-product?search=" + this.search_text, {
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
                    fetch("{{$base_url}}/restore-product/" + id, {
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
                            this.message = 'محصول با موفقیت منتشر شد';
                            this.models[index].status = true
                        }
                        else if(res.status === 401){
                            this.error = 'لطفا وارد حساب کاربری خود شوید'
                            window.location.replace('/register')
                        }
                        else {
                            this.error = 'خطایی در انتشار محصول رخ داد. لطفا دوباره تلاش نمایید'
                        }
                    }).catch((error) => {
                        console.log(error);
                        this.error = 'خطایی در انتشار محصول رخ داد. لطفا دوباره تلاش نمایید'
                    });

                },
                async deleteitem(id, index){
                    this.error = '';
                    this.message = '';
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    fetch("{{$base_url}}/product/" + id, {
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
                            this.message = 'محصول غیرفعال شد';
                            this.models[index].status = false
                        }
                        else if(res.status === 401){
                            this.error = 'لطفا وارد حساب کاربری خود شوید'
                            window.location.replace('/register')
                        }
                        else {
                            this.error = 'خطایی در غیرفعال کردن محصول رخ داد. لطفا دوباره تلاش نمایید'
                        }
                    }).catch((error) => {
                        console.log(error);
                        this.error = 'خطایی در غیرفعال کردن محصول رخ داد. لطفا دوباره تلاش نمایید'
                    });

                }
            }
        }).mount('#vueapp')
    </script>
@endsection
