@extends('layouts.Admin')
@section('title', 'مدیریت دسته بندی ها')
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
                    <h5>مدیریت دسته بندی ها</h5>
                    <a href="{{route('admin.category.create')}}" class="btn btn-sm btn-primary me-auto">افزودن رکورد</a>

                </div>
                <div class="card-body">
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
                            <th>تصویر</th>
                            <th>نام</th>
                            <th>لینک</th>
                            <th>والد</th>
                            <th>صفحه اصلی</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in models" :key="index">
                            <td>@{{item.id}}</td>
                            <td class="td-image">
                                <img :src="item.image" class="img-fluid">
                            </td>
                            <td>@{{item.name}}</td>
                            <td>@{{item.slug}}</td>
                            <td>@{{item?.parent?.name}}</td>
                            <td>
                                <span v-if="item.home_page" class="text-success">بله</span>
                                <span v-else class="text-danger">خیر</span>
                            </td>
                            <td class="actions-btns d-inline">

                                <a :href="`{{$base_url}}/category/${item.id}/edit`" target="_blank"
                                   class="btn btn-outline-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                </a>
                                <button v-if="item.deleted_at" @click="restoreItem(item.id, index)" class="btn btn-sm btn-outline-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M48.5 224L40 224c-13.3 0-24-10.7-24-24L16 72c0-9.7 5.8-18.5 14.8-22.2s19.3-1.7 26.2 5.2L98.6 96.6c87.6-86.5 228.7-86.2 315.8 1c87.5 87.5 87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3c-62.2-62.2-162.7-62.5-225.3-1L185 183c6.9 6.9 8.9 17.2 5.2 26.2s-12.5 14.8-22.2 14.8L48.5 224z"/></svg>
                                </button>
                                <button v-else @click="deleteitem(item.id, index)"
                                        class="btn btn-outline-danger btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
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
                    error: ''
                }
            },
            mounted(){
                @if(isset($model))
                    this.models = <?=json_encode($model->items())?>
                    @endif
            },
            methods:{
                async restoreItem(id, index){
                    this.error = '';
                    this.message = '';
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    fetch("{{$base_url}}/restore-category/" + id, {
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
                    fetch("{{$base_url}}/category/" + id, {
                        headers: {
                            'Content-type': 'application/json',
                            'Accept': 'application/json'
                        },
                        method: 'DELETE',
                        body: JSON.stringify({
                            _token: token.content
                        })
                    }).then(res => {
                        if(res.status >= 200 && res.status <= 204)
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
