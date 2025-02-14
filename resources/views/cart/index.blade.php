@extends('layouts.Main')
@section('title','سبد خرید')
@section('content')

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
                                        <a href="/cart">
                                            سبد خرید
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="bread-title">
                                <h2>
                                    سبد خرید
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end Breadcrumb Area-->
    <!--shop products-->
    <section class="shop-products-bhv pt60 pb60" id="vueapp">
        <div class="container shop-container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="rpb-cart-table">
                        <table class="cart_table div-for-data">
                            <thead>
                            <tr>
                                <th class="product-remove">
                                </th>
                                <th class="product-thumbnail">
                                </th>
                                <th class="product-name">
                                    نام آیتم
                                </th>
                                <th class="product-price">
                                    قیمت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in cart_items" :key="index" class="rpb-cart-item-td">
                                <td class="product-remove">
                                    <button class="btn btn-sm btn-danger" @click="removeFromCart(item.id, index)">
                                        ×
                                    </button>
                                </td>
                                <td class="product-thumbnail">
                                    <a :href="`/shop/product/${item.product.sku}`" target="_blank">
                                        <img v-if="item.product.thumbnail" :src="item.product.thumbnail"
                                             :alt="item.product.name">
                                        <img v-else-if="item.product.image" :src="item.product.image"
                                             :alt="item.product.name">
                                    </a>
                                </td>
                                <td class="product-name rpbrs-titl" data-title="نام آیتم">
                                    <a  :href="`/shop/product/${item.product.sku}`" target="_blank">@{{ item.product.name }}</a>
                                </td>
                                <td class="product-price rpbrs-titl" data-title="قیمت">
                                  <span>
                                    @{{item.unit_price.toLocaleString()}}
                                  </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="cart-extra-sevc div-for-data mt60">
                        <h4 class="mb30">
                            مجموع سبد خرید
                        </h4>
                        <table class="table border">
                            <tbody>
                            <tr>
                                <th>
                                    تعداد محصولات
                                </th>
                                <td>
                                    @{{ item_count }} محصول
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    جمع قیمت محصولات
                                </th>
                                <td>
                                    @{{ sub_total.toLocaleString() }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    تخفیف
                                </th>
                                <td>
                                    @{{Number(sub_total - total).toLocaleString()}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    مالیات
                                </th>
                                <td>
                                    0
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    قابل پرداخت
                                </th>
                                <td>
                                    @{{ total.toLocaleString() }} <small>تومان</small>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <button class="btn-main bg-btn3 lnk w-100" v-if="total" @click="generateInvoice()">
                            برای تسویه حساب اقدام کنید
                            <i class="fas fa-chevron-left fa-icon">
                            </i>
                            <span class="circle"></span>
                        </button>
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
                    qty: 1,
                    message: '',
                    error: '',
                    cart_items: [],
                    total: 0,
                    sub_total: 0,
                    item_count: 0,
                    item_total_count: 0,

                }
            },
            mounted(){
              @if($cart && $cart->cart_items)
                this.cart_items = <?=$cart->cart_items;?>;
              @endif
              if(this.cart_items.length)
                {
                    this.cart_items.forEach((item) => {
                        this.total += item.qty * item.unit_price;
                        this.sub_total += item.qty * item.product.price;
                        this.item_total_count += item.qty;
                        this.item_count += 1;
                    })
                }
            },
            methods:{
                calculateCart(){
                  if(this.cart_items.length)
                  {
                      this.total = 0;
                      this.sub_total = 0;
                      this.item_total_count = 0;
                      this.item_count = 0;
                      this.cart_items.forEach((item) => {
                          this.total += item.qty * item.unit_price;
                          this.sub_total += item.qty * item.product.price;
                          this.item_total_count += item.qty;
                          this.item_count += 1;
                      })
                  }
                },
                async generateInvoice(){
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    await fetch("{{route('generate_invoice')}}", {
                        headers: {
                            'Content-type': 'application/json',
                            'Accept': 'application/json'
                        },
                        method: 'POST',
                        body: JSON.stringify({
                            _token: token.content
                        })
                    }).then(res => {
                        if(res.status >=200 && res.status <= 204)
                        {
                            this.message = 'فاکتور با موفقیت ایجاد شد'

                            return res.json()
                            // Simulate an HTTP redirect:
                            //window.location.replace('/order/' + data.order_id);
                        }
                        else {
                            this.error = 'خطایی در ایجاد فاکتور رخ داد. لطفا دوباره تلاش نمایید'
                        }
                        return null
                    }).then(data =>{
                        window.location.replace('/order/' + data.order_id);
                    }).catch((error) => {
                        console.log(error);
                        this.error = 'خطایی در ایجاد فاکتور رخ داد. لطفا دوباره تلاش نمایید'
                    });
                },
                async removeFromCart(id, index){
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    await fetch("{{route('remove_from_cart')}}", {
                        headers: {
                            'Content-type': 'application/json',
                            'Accept': 'application/json'
                        },
                        method: 'DELETE',
                        body: JSON.stringify({
                            item_id: Number(id),
                            _token: token.content
                        })
                    }).then(res => {
                        if(res.status >=200 && res.status <= 204)
                        {
                            this.message = 'محصول از سبد خرید حذف شد'
                            this.cart_items.splice(index, 1);
                            this.calculateCart();

                        }
                        else {
                            this.error = 'خطایی در حذف محصول از سبد خرید رخ داد. لطفا دوباره تلاش نمایید'
                        }
                    }).catch((error) => {
                        console.log(error);
                        this.error = 'خطایی در حذف محصول از سبد خرید رخ داد. لطفا دوباره تلاش نمایید'
                    });
                }
            }
        }).mount('#vueapp')
    </script>
@endsection
