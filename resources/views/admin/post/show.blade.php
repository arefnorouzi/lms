@extends('layouts.Admin')
@section('title', $post->name)
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
                    @if($post->status)
                        <a class="btn btn-outline-dark" target="_blank" href="/blog/article/{{$post->sku}}">مشاهده مقاله</a>
                    @endif
                    <div class="card shadow mt-2">
                        <div class="card-header d-flex">
                            <h4>جزئیات مقاله</h4>
                            <a href="{{route('admin.post.edit', $post->id)}}" class="btn btn-sm btn-primary me-auto">ویرایش مقاله</a>

                        </div>
                        <div class="card-body">
                            <h4 class="mt-3">عنوان: {{$post->name}}</h4>
                            <hr class="my-2">
                            <img src="{{$post->image}}" class="td-image">
                            <hr class="my-2">
                            <p class="alert alert-primary">بازدید: {{number_format($post->views)}}</p>

                            <div class="post-content">
                                {!! $post->description !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <h3>نظرات</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


@endsection
@section('script')

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        const { createApp } = Vue

        createApp({
            data() {
                return {
                    models: [],
                    images: [],
                    message: '',
                    error: '',
                    property_name: '',
                    property_value: '',
                    priority: 0,
                    image: null,
                    product_id: {{$post->id}}
                }
            },
            mounted(){
                @if($post->properties)
                    this.models = <?=$post->properties ?>

                    @endif
            },
            methods:{
                async handleFileChange(event){
                    this.image = event.target.files[0];
                },
                async uploadImage(){
                    this.error = '';
                    this.message = '';
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    if(this.image)
                    {
                        const formData = new FormData();
                        formData.append("image", this.image);
                        formData.append("product_id", this.product_id);
                        formData.append("_token", token.content);
                        fetch("{{$base_url}}/gallery", {
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            },
                            method: 'POST',
                            body: formData
                        }).then(res => {
                            if(res.status >=200 && res.status <= 204)
                            {
                                return  res.json()
                            }
                            else if(res.status === 401){
                                this.error = 'لطفا وارد حساب کاربری خود شوید'
                                window.location.replace('/register')
                            }
                            else {
                                this.error = 'خطایی در بارگزاری رخ داد. لطفا دوباره تلاش نمایید'
                            }
                            return null;
                        }).then(data =>{
                            this.message = 'تصویر با موفقیت بارگزاری شد';
                            this.image = null;

                            this.images.push(data.image)
                        })
                            .catch((error) => {
                                console.log(error);
                                this.error = 'خطایی در بارگزاری رخ داد. لطفا دوباره تلاش نمایید'
                            });
                    }
                    else {
                        this.error = 'اطلاعات فرم نامعتبر است. لطفا دوباره تلاش نمایید'
                    }

                },
                async deleteImage(id, index){
                    this.error = '';
                    this.message = '';
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    fetch("{{$base_url}}/gallery/" + id, {
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
                            this.images.splice(index, 1);
                        }
                        else if(res.status === 401){
                            this.error = 'لطفا وارد حساب کاربری خود شوید'
                            window.location.replace('/register')
                        }
                        else {
                            this.error = 'خطایی در حذف تصویر رخ داد. لطفا دوباره تلاش نمایید'
                        }
                    }).catch((error) => {
                        console.log(error);
                        this.error = 'خطایی در حذف تصویر رخ داد. لطفا دوباره تلاش نمایید'
                    });
                },
                async addItem(){
                    this.error = '';
                    this.message = '';
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    if(this.property_name.length > 2 && this.property_value.length > 1)
                    {
                        fetch("{{$base_url}}/property", {
                            headers: {
                                'Content-type': 'application/json',
                                'Accept': 'application/json'
                            },
                            method: 'POST',
                            body: JSON.stringify({
                                property_name: this.property_name,
                                property_value: this.property_value,
                                product_id: this.product_id,
                                priority: this.priority,
                                _token: token.content
                            })
                        }).then(res => {
                            if(res.status >=200 && res.status <= 204)
                            {
                                return  res.json()
                            }
                            else if(res.status === 401){
                                this.error = 'لطفا وارد حساب کاربری خود شوید'
                                window.location.replace('/register')
                            }
                            else {
                                this.error = 'خطایی در انتشار مقاله رخ داد. لطفا دوباره تلاش نمایید'
                            }
                        }).then(data =>{
                            this.message = 'ویژگی با موفقیت منتشر شد';
                            this.property_name = '';
                            this.property_value = '';
                            this.priority = 0;

                            this.models.push(data.model)
                        })
                            .catch((error) => {
                                console.log(error);
                                this.error = 'خطایی در انتشار مقاله رخ داد. لطفا دوباره تلاش نمایید'
                            });
                    }
                    else {
                        this.error = 'اطلاعات فرم نامعتبر است. لطفا دوباره تلاش نمایید'
                    }

                },
                async deleteItem(id, index){
                    this.error = '';
                    this.message = '';
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    fetch("{{$base_url}}/property/" + id, {
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
                            this.models.splice(index, 1);
                        }
                        else if(res.status === 401){
                            this.error = 'لطفا وارد حساب کاربری خود شوید'
                            window.location.replace('/register')
                        }
                        else {
                            this.error = 'خطایی در غیرفعال کردن مقاله رخ داد. لطفا دوباره تلاش نمایید'
                        }
                    }).catch((error) => {
                        console.log(error);
                        this.error = 'خطایی در غیرفعال کردن مقاله رخ داد. لطفا دوباره تلاش نمایید'
                    });

                }
            }
        }).mount('#vueapp')
    </script>
@endsection
