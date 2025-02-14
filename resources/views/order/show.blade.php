@extends('layouts.Main')
@section('title', "فاکتور $order->id")
@section('content')
    <style>
        .form-select{
            background-position: left .75rem center;
        }
    </style>
    <!--Breadcrumb Area-->
    <section class="breadcrumb-area banner-2" data-background="/images/banner/4.jpg">
        <div class="text-block">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 v-center">
                        <div class="bread-inner">
                            <div class="bread-menu">
                                <ul>
                                    <li>
                                        <a href="/">
                                            صفحه اصلی
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/order">
                                            تسویه  حساب
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="bread-title">
                                <h2>
                                    تسویه حساب
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end Breadcrumb Area-->

    <!-- Main -->
    <section class="shop-products-bhv pt60 pb60" id="vueapp">

            @if(session('message'))
                <p class="alert alert-success">{{session('message')}}</p>
            @endif
            @if(session('error'))
                <p class="alert alert-danger">{{session('error')}}</p>
            @endif
            <div class="container shop-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="rpb-cart-table">
                            <table class="cart_table div-for-data">
                                <thead>
                                <tr>
                                    <th class="product-name">
                                        نام آیتم
                                    </th>
                                    <th class="product-price">
                                        قیمت
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->order_items as $item)
                                <tr class="rpb-cart-item-td">
                                    <td class="product-name rpbrs-titl" data-title="نام آیتم">
                                        <a href="/shop/product/{{$item->product->sku}}" target="_blank">{{ $item->product_name }}</a>
                                    </td>
                                    <td class="product-price rpbrs-titl" data-title="قیمت">
                                      <span>
                                        {{number_format($item->unit_price)}}
                                      </span>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" id="vueapp">
                    <div class="col-lg-6">
                        <div class="cart-extra-sevc div-for-data mt60">
                            <h5 class="mb-3">مشخصات دانشجو</h5>
                            @if(in_array($order->status, array(\App\Enums\OrderStatuses::PENDING->value, \App\Enums\OrderStatuses::PROCESSING->value)))
                                <div class="mb-3">
                                    <label for="fname" class="form-label">نام و نام خانوادگی</label>
                                    <input type="text" v-model="name" id="fname" class="form-control" placeholder="نام">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">شماره موبایل* (11 رقمی)</label>
                                    <input type="tel" id="phone" v-model="mobile" class="form-control"
                                           placeholder="09123456789">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">ایمیل (اختیاری)</label>
                                    <input type="email" id="phone" v-model="email" class="form-control"
                                           placeholder="yourusername@gmail.com">
                                    <small class="text-danger" style="font-size: .8rem">بهتر است از آدرس <strong>جیمیل</strong> استفاده شود</small>
                                </div>

                                <div class="my-2">
                                    <div v-if="message" class="alert alert-success">
                                        <p>@{{ message }}</p>
                                    </div>
                                    <p v-if="error" class="alert alert-danger">@{{ error }}</p>
                                    <p v-for="(er, index) in errors" class="alert alert-danger" :key="index">@{{ er }}</p>
                                </div>
                                <button class="btn-main bg-btn3 lnk w-100" @click="updateInvoice">
                                    پرداخت و تکمیل سفارش
                                    <i class="fas fa-chevron-left fa-icon">
                                    </i>
                                    <span class="circle"></span>
                                </button>
                            @else
                                <div class="mb-2">
                                    <label for="fname" class="form-label">نام دانشجو</label>
                                    <input type="text" value="{{$order->customer_name}}" id="fname" class="form-control disabled" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="phone" class="form-label">شماره تماس</label>
                                    <input type="tel" id="phone" value="{{$order->customer_phone}}" class="form-control"
                                           placeholder="شماره تماس" disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="status" class="form-label">وضعیت سفارش</label>
                                    <input type="text" id="status" value="{{$order->status}}" class="form-control text-success"
                                            disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="created_at" class="form-label">تاریخ ثبت سفارش</label>
                                    <input type="text" id="created_at" value="{{verta($order->created_at)->timezone('ASIA/TEHRAN')}}" class="form-control"
                                           disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="purchased_at" class="form-label">تاریخ پرداخت</label>
                                    <input type="text" id="purchased_at" value="{{verta($order->purchased_at)->timezone('ASIA/TEHRAN')}}" class="form-control"
                                           disabled>
                                </div>
                            @endif

                        </div>
                    </div>

                    @if(in_array($order->status, array(\App\Enums\OrderStatuses::PAID->value, \App\Enums\OrderStatuses::SHIPPED->value)))
                        <div class="col-lg-6">
                            <div class="cart-extra-sevc div-for-data mt60">
                                <h5 class="mb-3">دریافت فایل های دوره</h5>
                                <p class="alert alert-info">برای دریافت فایل های دوره می توانید به روش های زیر اقدام نمایید</p>
                                <hr class="my-2">

                                <div class="alert alert-primary">
                                    <h6>دریافت بصورت ایمیل</h6>
                                    <p class="alert-text">برای دریافت فایل های دوره بصورت ایمیل، نیاز است تا آدرس <strong>GMAIL</strong> خود را در پروفایل ثبت نمایید</p>
                                    <ol class="order-details-ul mt-2">
                                        <li>به <a href="/profile" target="_blank"> صفحه پروفایل</a> بروید</li>
                                        <li>آدرس جیمیل خود را ثبت نمایید</li>
                                        <li>پس از ثبت، برای تایید آدرس ایمیل خود اقدام نمایید</li>
                                        <li>فایل های دوره در عرض چند ساعت برای شما ارسال خواهد شد</li>
                                    </ol>
                                    <p class="alert-text text-danger mt-2">چنانچه، مشکلی در این روند پیش آمد، به <a href="/contact" target="_blank">پشتیبانی</a> پیام ارسال نمایید</p>

                                </div>

                                <div class="alert alert-primary">
                                    <h6>پیام به پشتیبانی</h6>
                                    <p class="alert-text mb-3">می توانید بصورت مستقیم به پشتیبانی پیام ارسال نمایید تا فایل ها را بصورت دلخواه شما برایتان ارسال نماییم</p>


                                    <a class="btn-main bg-btn3 lnk mb-2 w-100" href="#">
                                        چت تلگرام
                                        <i class="fab fa-telegram">
                                        </i>
                                    </a>
                                    <a class="btn-main bg-btn-4 lnk mb-2 w-100" href="#">
                                        چت واتساپ
                                        <i class="fab fa-whatsapp">
                                        </i>
                                    </a>
                                    <a class="btn-main bg-btn2 lnk mb-2 w-100" href="#">
                                        چت اینستاگرام
                                        <i class="fab fa-instagram">
                                        </i>
                                    </a>
                                </div>


                            </div>
                        </div>
                    @endif
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
                    qty: 1,
                    message: '',
                    error: '',
                    errors: null,
                    cart_items: [],
                    total: {{$order->total}},
                    shipping_cost: 0,
                    sub_total: 0,
                    item_count: 0,
                    item_total_count: 0,
                    name: "{{$user['name']}}",
                    mobile: "{{$user['mobile']}}",
                    email: "{{$user['email']}}",
                    shipping_method: 1,
                    shipping_methods: null,
                }
            },
            mounted(){
            },
            methods:{
                calculateInvoice(){
                    if(this.cart_items.length)
                    {
                        this.total = 0;
                        this.sub_total = 0;
                        this.item_total_count = 0;
                        this.item_count = 0;

                    }
                },
                async changeShipping(){
                    this.shipping_methods.forEach((item) => {
                        if(Number(item.id) === Number(this.shipping_method))
                        {
                            this.shipping_cost = item.price;
                        }
                    })
                },
                async updateInvoice(){
                    this.error = ''
                    this.message = ''
                    this.errors = null
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    const response = await fetch("{{route('update_invoice', $order->id)}}", {
                        headers: {
                            'Content-type': 'application/json',
                            'Accept': 'application/json'
                        },
                        method: 'PATCH',
                        body: JSON.stringify({
                            name: this.name,
                            phone: this.mobile,
                            email: this.email,
                            shipping_method: this.shipping_method,
                            _token: token.content
                        })
                    });
                    if(!response.ok)
                    {
                        if(response.status === 422)
                        {

                            let data = await response.json()
                            this.errors = data?.errors
                            console.log("****  errors list *****")
                            console.log(this.errors.json())
                        }
                        else {
                            this.error = 'خطایی در ایجاد فاکتور رخ داد. لطفا دوباره تلاش نمایید'
                        }
                    }
                    else if(response.ok)
                    {
                        let data = await response.json()
                        this.message = 'فاکتور با موفقیت ایجاد شد'
                        // Simulate an HTTP redirect:
                        window.location.replace('/payment/zarinpal/pay/' + "{{$order->id}}");
                    }
                },
            }
        }).mount('#vueapp')
    </script>
@endsection
