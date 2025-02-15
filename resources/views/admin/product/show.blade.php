@extends('layouts.Admin')
@section('title', $product->name)
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
                    @if($product->status)
                        <a class="btn btn-outline-dark" target="_blank" href="/shop/product/{{$product->sku}}">مشاهده محصول</a>
                    @endif
                        <div class="card shadow mt-2">
                        <div class="card-header d-flex">
                            <h4>جزئیات محصول</h4>
                            <a href="{{route('admin.product.edit', $product->id)}}" class="btn btn-sm btn-primary me-auto">ویرایش محصول</a>

                        </div>
                        <div class="card-body">
                            <h4 class="mt-3">عنوان: {{$product->name}}</h4>
                            <hr class="my-2">
                            <img src="{{$product->image}}" class="td-image">
                            <hr class="my-2">
                            <p class="alert alert-primary">موجودی انبار: {{number_format($product->stock)}}</p>
                            <p class="alert alert-primary">قیمت: {{number_format($product->price)}}</p>
                            <p class="alert alert-primary">قیمت تخفیفی: {{number_format($product->offer_price)}}</p>
                            <div class="alert alert-primary">اعتبار تخفیف:
                            <p class="td-date">{{verta($product->offer_end_date)}}</p></div>
                            <hr class="my-3">
                            <div class="post-content">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">عنوان ویژگی</label>
                                <input type="text" v-model="property_name" minlength="2" maxlength="100" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">مقدار ویژگی</label>
                                <input type="text" v-model="property_value" minlength="2" maxlength="100" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">نمایش در سربرگ محصول</label>
                                <input type="checkbox" v-model="priority" class="form-check">
                            </div>
                            <div class="mb-3 text-center">
                                <button @click="addItem" class="btn btn-primary">افزودن ویژگی</button>
                            </div>
                            <hr class="my-3">

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>عنوان</th>
                                    <th>مقدار</th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in models" :key="index">
                                    <td>@{{ item.id }}</td>
                                    <td>@{{ item.property_name }}</td>
                                    <td>@{{ item.property_value }}</td>
                                    <td>
                                        <button @click="deleteItem(item.id, index)" class="btn btn-sm btn-danger">حذف</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                    product_id: {{$product->id}}
                }
            },
            mounted(){
                @if($product->properties)
                this.models = <?=$product->properties ?>

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
                                this.error = 'خطایی در انتشار محصول رخ داد. لطفا دوباره تلاش نمایید'
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
                            this.error = 'خطایی در انتشار محصول رخ داد. لطفا دوباره تلاش نمایید'
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
