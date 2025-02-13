@extends('layouts.Main')
@section('title', $product->name)
@section('header')
    <meta name="description" content="{{$product->meta}}">
    {{-- Open Graph (Facebook, WhatsApp) --}}
    <meta property="og:title" content="{{ $product->subtitle ?? $product->name }}">
    <meta property="og:description" content="{{ $product->meta ?? $product->name }}">
    <meta property="og:image" content="{{ url($product->image) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="product">
    @if($product->offer_price && $product->offer_end_date > $today)
    <meta property="product:price:amount" content="{{ $product->offer_price * 10 }}">
    @else
        <meta property="product:price:amount" content="{{ $product->price * 10 }}">
    @endif
    <meta property="product:price:currency" content="IRR">
    <meta property="product:availability" content="in stock">

    {{-- Twitter Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $product->subtitle ?? $product->name }}">
    <meta name="twitter:description" content="{{ $product->meta ?? $product->name }}">
    <meta name="twitter:image" content="{{ url($product->image) }}">


    <script type="application/ld+json">
        {
          "@context": "https://schema.org/",
          "@type": "Product",
          "sku": "{{$product->sku}}",
      "image": [
        "{{url($product->image)}}"
      ],
      "name": "{{$product->name}}",
      "description": "{{$product->meta}}",
      "brand": {
        "@type": "Brand",
        "name": "CLEANOVA"
      },
      @if($product->offer_price && $product->offer_end_date > $today)
        "offers": {
            "@type": "Offer",
            "url": "{{url("/shop/product/$product->sku")}}",
            "priceCurrency": "IRR",
            "price": "{{intval($product->price * 10)}}",
            "priceValidUntil": "{{$product->offer_end_time}}",
            "itemCondition": "https://schema.org/UsedCondition",
            "availability": "https://schema.org/InStock"
        }
        @else

            "offers": {
              "@type": "Offer",
              "url": "{{url("/shop/product/$product->sku")}}",
            "priceCurrency": "IRR",
            "price": "{{intval($product->price * 10)}}",
            "priceValidUntil": "{{now()->addDays(10)}}",
            "itemCondition": "https://schema.org/UsedCondition",
            "availability": "https://schema.org/InStock"
        }
        @endif
      }
    </script>
@endsection
@section('content')

    <!-- Product info section -->
    <section class="product product-info">
        <div class="container">
            <!-- Breadcrumb -->
            <div class="blog-bradcrum">
                <span><a href="/">خانه</a></span>
                <span class="devider">/</span>
                <span><a href="/shop">فروشگاه</a></span>
                <span class="devider">/</span>
                <span><a href="#">{{$product->name}}</a></span>
            </div>
            <div class="product-info-section">
                <div class="row ">
                    <div class="col-md-6">
                        <!-- Gallery -->
                        <div class="product-info-img" data-aos="fade-right">
                            <div class="swiper product-top">
                                @if($product->offer_price && $product->offer_end_date > $today)
                                <div class="product-discount-content">
                                    <p class="text-black fs-3" dir="ltr">
                                        %{{round((floatval(($product->price - $product->offer_price) / $product->price) * 100))}}
                                    </p>
                                </div>
                                @endif
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide slider-top-img">
                                        <img src="{{$product->image}}" alt="{{$product->name}}">
                                    </div>
                                    @foreach($product->galleries as $gallery)
                                        <div class="swiper-slide slider-top-img">
                                            <img src="{{$gallery->image}}" alt="{{$product->name}}">
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="swiper product-bottom">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide slider-bottom-img">
                                        <img src="{{$product->image}}" alt="{{$product->name}}">
                                    </div>
                                    @foreach($product->galleries as $gallery)
                                        <div class="swiper-slide slider-bottom-img">
                                            <img src="{{$gallery->image}}" alt="{{$product->subtitle}}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product-info-content" id="vueapp" data-aos="fade-left">
                            <h5>{{$product->subtitle}}</h5>

                            <!-- Price -->

                            @if($product->offer_price && $product->offer_end_date > $today)
                                <div class="price">
                                    <span class="price-cut">{{number_format($product->price)}}</span>
                                    <span class="new-price">{{number_format($product->offer_price)}} تومان</span>
                                </div>
                            @else
                                <div class="price">
                                    <span class="new-price">{{number_format($product->price)}} تومان</span>
                                </div>
                            @endif
                            <!-- Description -->
                            <hr />


                            @if($product->properties)

                            <div class="d-flex flex-wrap overflow-scroll">
                                @foreach($product->properties as $property)
                                    <div class="property-item">
                                        <div class="property-name">{{$property->property_name}}</div>
                                        <div class="property-value">
                                            {{$property->property_value}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                            <hr />
                            <!-- Abailability -->
                            @if($product->stock > 1)
                            <div class="product-availability">
                                <span>موجودی: </span>
                                <span class="inner-text">{{$product->stock}} محصول</span>
                            </div>
                            <div v-if="message" class="alert alert-success">
                                <p>@{{ message }}</p>
                                <br />
                                <a href="/cart" class="nav-link text-primary font-weight-bold">مشاهده سبد خرید</a>
                            </div>
                            <p v-if="error" class="alert alert-danger">@{{ error }}</p>
                            <!-- Quanity -->
                            <div class="product-quantity">
                                <input type="number" min="1" max="{{$product->stock}}"
                                       class="form-control quantity-input"
                                       v-model="qty"
                                       required>
                                <button class="shop-btn" @click="addToCart()">
                                    <span>
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.25357 3.32575C8.25357 4.00929 8.25193 4.69283 8.25467 5.37583C8.25576 5.68424 8.31536 5.74439 8.62431 5.74439C9.964 5.74603 11.3031 5.74275 12.6428 5.74603C13.2728 5.74767 13.7397 6.05663 13.9246 6.58104C14.2209 7.42098 13.614 8.24232 12.6762 8.25052C11.5919 8.25982 10.5075 8.25271 9.4232 8.25271C9.17714 8.25271 8.93107 8.25216 8.68501 8.25271C8.2913 8.2538 8.25412 8.29154 8.25412 8.69838C8.25357 10.0195 8.25686 11.3412 8.25248 12.6624C8.25029 13.2836 7.92603 13.7544 7.39891 13.9305C6.56448 14.2088 5.75848 13.6062 5.74863 12.6821C5.73824 11.7251 5.74645 10.7687 5.7459 9.81173C5.7459 9.41965 5.74754 9.02812 5.74535 8.63604C5.74371 8.30849 5.69012 8.2538 5.36204 8.25326C4.02235 8.25162 2.68321 8.25545 1.34352 8.25107C0.719613 8.24943 0.249902 7.93008 0.0710952 7.40348C-0.212153 6.57065 0.388245 5.75916 1.31017 5.74658C2.14843 5.73564 2.98669 5.74384 3.82495 5.74384C4.30779 5.74384 4.79062 5.74384 5.274 5.74384C5.72184 5.7433 5.7459 5.71869 5.7459 5.25716C5.7459 3.95406 5.74317 2.65096 5.74699 1.34786C5.74863 0.720643 6.0625 0.253102 6.58799 0.0704598C7.40875 -0.213893 8.21803 0.370671 8.25248 1.27349C8.25303 1.29154 8.25303 1.31013 8.25303 1.32817C8.25357 1.99531 8.25357 2.66026 8.25357 3.32575Z"
                                                fill="white" />
                                        </svg>
                                    </span>
                                    <span>اضافه به سبد</span>
                                </button>
                            </div>
                            @else
                                <div class="product-availability">
                                    <span class="inner-text">ناموجود</span>
                                </div>

                            @endif
                            <hr>
                            <!-- Details -->
                            <div class="product-details">
                                <p class="category">دسته: <span class="inner-text">{{$product->category->name}}</span></p>
                                <p class="sku">کد محصول: <span class="inner-text">{{$product->id}}</span></p>
                            </div>
                            <hr>
                            <!-- Share -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Product description -->
    <section class="product product-description">
        <div class="container">
            <div class="product-detail-section">

                @if($product->properties and count($product->properties))
                <h3 class="intro-heading properties-title mb-3">ویژگی ها</h3>
                    <table class="table table-striped table-responsive properties-table">
                        <tbody>
                        @foreach($product->properties as $property)
                            <tr>
                                <td>{{$property->property_name}}</td>
                                <td>{{$property->property_value}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif

                <div class="product-intro-section product-description-content">
                    <h1 class="product-description-title">{{$product->subtitle}}</h1>
                    {!! $product->description !!}

                </div>

            </div>
        </div>
    </section>


    <!-- Top selling this week section -->
    <section class="product weekly-sale product-weekly footer-padding">
        <div class="container">
            <div class="section-title">
                <h5>محصولات مرتبط</h5>
                <a href="/shop/category/{{$product->category->slug}}" target="_blank" class="view">مشاهده همه</a>
            </div>
            <div class="weekly-sale-section">
                <div class="row g-5">
                    @foreach($related_products as $p)
                    <div class="col-lg-3 col-md-6">
                        <a href="/shop/product/{{$p->sku}}">
                        <div class="product-wrapper" data-aos="fade-up">
                            <div class="product-img">
                                @if($p->thumbnail)
                                    <img src="{{$p->thumbnail}}" alt="{{$p->name}}">
                                @elseif($p->image)
                                    <img src="{{$p->image}}" alt="{{$p->name}}">
                                @else
                                    -
                                @endif
                            </div>
                            <div class="product-info">
                                <div class="product-description">
                                    <a href="/shop/product/{{$p->sku}}" class="product-details">{{$p->name}}</a>
                                    @if($p->offer_price && $p->offer_end_date > $today)
                                        <div class="price">
                                            <span class="price-cut">{{number_format($p->price)}}</span>
                                            <span class="new-price">{{number_format($p->offer_price)}}</span>
                                        </div>
                                    @else
                                        <div class="price">
                                            <span class="new-price">{{number_format($p->price)}}</span>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="product-cart-btn">
                                <a href="/shop/product/{{$p->sku}}" class="product-btn">سفارش محصول</a>

                            </div>
                        </div>
                        </a>
                    </div>
                        @endforeach
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
                    stock: {{$product->stock}},
                    message: '',
                    error: ''
                }
            },
            methods:{
                async addToCart(){
                    this.error = '';
                    this.message = '';
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    if(this.qty > this.stock)
                    {
                        this.error = 'لطفا تعداد را به درستی وارد نمایید. تعداد درخواستی بیشتر از موجودی انبار است'
                    }
                    else {
                        fetch("{{route('add_to_cart')}}", {
                            headers: {
                                'Content-type': 'application/json',
                                'Accept': 'application/json'
                            },
                            method: 'POST',
                            body: JSON.stringify({
                                product_id: {{$product->id}},
                                qty: Number(this.qty),
                                _token: token.content
                            })
                        }).then(res => {
                            if(res.status >=200 && res.status <= 204)
                            {
                                this.message = 'محصول به سبد خرید اضافه شد'
                            }
                            else if(res.status === 401){
                                this.error = 'لطفا وارد حساب کاربری خود شوید'
                                window.location.replace('/register')
                            }
                            else {
                                this.error = 'خطایی در افزودن محصول به سبد خرید رخ داد. لطفا دوباره تلاش نمایید'
                            }
                        }).catch((error) => {
                            console.log(error);
                            this.error = 'خطایی در افزودن محصول به سبد خرید رخ داد. لطفا دوباره تلاش نمایید'
                        });
                    }

                }
            }
        }).mount('#vueapp')
    </script>
@endsection
