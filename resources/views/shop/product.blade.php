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
                                        <a href="/shop/category/{{$product->category->slug}}" target="_blank">
                                            {{$product->category->name}}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url()->current()}}">{{$product->name}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="bread-title">
                                <h2>{{$product->name}}</h2>
                                <p class="mt10">{{$product->subtitle}}</p>
                                <div class="btn-grp mt40">
                                    <a class="btn-main bg-btn lnk" href="#">
                                        پیش نمایش زنده
                                        <i class="fas fa-share">
                                        </i>
                                        <span class="circle"></span>
                                    </a>
                                    <a class="btn-main bg-btn3 lnk" href="#">
                                        هم اکنون خریداری کنید
                                        <i class="fas fa-shopping-cart">
                                        </i>
                                        <span class="circle"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end Breadcrumb Area-->
    <!--shop products-->
    <section class="shop-products-prvw pt20 pb60">
        <div class="container shop-container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="rpb-shop-prevw">
                        <img alt="تصویر" class="w-100" src="/images/shop/item-perview.jpg"/>
                    </div>
                    <div class="rpb-item-info">
                        <div class="tab-17 tabs-layout">
                            <ul class="nav nav-tabs" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a aria-controls="tab1" aria-selected="true" class="nav-link active" data-bs-toggle="tab" href="#tab1" id="tab1a" role="tab">
                                        جزئیات مورد
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a aria-controls="tab2" aria-selected="false" class="nav-link" data-bs-toggle="tab" href="#tab2" id="tab2b" role="tab">
                                        بررسی ها
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a aria-controls="tab3" aria-selected="false" class="nav-link" data-bs-toggle="tab" href="#tab3" id="tab3c" role="tab">
                                        نظر
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a aria-controls="tab4" aria-selected="false" class="nav-link" data-bs-toggle="tab" href="#tab4" id="tab4c" role="tab">
                                        پشتیبانی
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent2">
                                <div aria-labelledby="tab1a" class="mt20 tab-pane fade show active" id="tab1" role="tabpanel">
                                    <h4 class="mb10">
                                        توضیحات
                                    </h4>
                                    <p class="mb30">
                                        لورم ایپسوم به سادگی متن ساختگی صنعت چاپ و حروف چینی است. لورم ایپسوم از دهه 1500 به عنوان متن ساختگی استاندارد صنعت بوده است، زمانی که یک چاپگر ناشناخته یک گالری از نوع را برداشت و آن را به هم زد تا یک کتاب نمونه بسازد. لورم ایپسوم به سادگی متن ساختگی صنعت چاپ و حروف چینی است. لورم ایپسوم به سادگی متن ساختگی صنعت چاپ و حروف چینی است. به سادگی متن ساختگی صنعت چاپ و حروف چینی است.
                                    </p>
                                    <h4 class="mb10">
                                        24-ساعت پشتیبانی :
                                    </h4>
                                    <ul class="ul-list mb30">
                                        <li>
                                            پشتیبانی سریع، اختصاصی و حرفه ای
                                        </li>
                                        <li>
                                            لطفا با درخواست جزئیات خود به آدرس info@site.ir ایمیل بزنید. با تشکر!
                                        </li>
                                    </ul>
                                    <h4 class="mb10">
                                        ویژگی های قالب
                                    </h4>
                                    <ul class="ul-list mb30">
                                        <li>
                                            ارائه شده توسط بوت استرپ
                                        </li>
                                        <li>
                                            کدهای به خوبی مستند شده
                                        </li>
                                        <li>
                                            کاملا واکنشگرا
                                        </li>
                                        <li>
                                            فونت های رایگان گوگل
                                        </li>
                                        <li>
                                            owl carousel 2
                                        </li>
                                        <li>
                                            آیکون فونت آوسام
                                        </li>
                                        <li>
                                            پاپ‌آپ Magnific
                                        </li>
                                        <li>
                                            فرم تماس با پی‌اچ‌پی به همراه اعتبارسنجی
                                        </li>
                                        <li>
                                            اثر ذرات خانگی
                                        </li>
                                        <li>
                                            کد html و css معتبر W3C
                                        </li>
                                        <li>
                                            سازگار با مرورگرهای مختلف
                                        </li>
                                        <li>
                                            بروزرسانی رایگان
                                        </li>
                                    </ul>
                                </div>
                                <div aria-labelledby="tab2b" class="tab-pane fade" id="tab2" role="tabpanel">
                                    <div class="rpb-item-review">
                                        <div class="reviews-card">
                                            <div class="review-text pt0 pb20">
                                                <p>
                                                    لورم ایپسوم به سادگی متن ساختگی صنعت چاپ و حروف چینی است. لورم ایپسوم از دهه 1500 به عنوان متن ساختگی استاندارد صنعت بوده است، زمانی که یک چاپگر ناشناخته یک گالری از نوع را برداشت و آن را به هم زد تا یک کتاب نمونه بسازد.
                                                </p>
                                            </div>
                                            <div class="-client-details-">
                                                <div class="-reviewr">
                                                    <img alt="نظر خوب" class="img-fluid" src="images/client/reviewer-c.jpg"/>
                                                </div>
                                                <div class="reviewer-text">
                                                    <h4>
                                                        <small>
                                                            توسط:
                                                        </small>
                                                        آنا استزیا
                                                    </h4>
                                                    <p>
                                                        20  دی  1400
                                                    </p>
                                                    <div class="star-rate">
                                                        <ul>
                                                            <li>
                                                                <a class="chked" href="javascript:void(0)">
                                                                    <i aria-hidden="true" class="fas fa-star">
                                                                    </i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="chked" href="javascript:void(0)">
                                                                    <i aria-hidden="true" class="fas fa-star">
                                                                    </i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="chked" href="javascript:void(0)">
                                                                    <i aria-hidden="true" class="fas fa-star">
                                                                    </i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="chked" href="javascript:void(0)">
                                                                    <i aria-hidden="true" class="fas fa-star">
                                                                    </i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)">
                                                                    <i aria-hidden="true" class="fas fa-star">
                                                                    </i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="reviews-card">
                                            <div class="review-text pt0 pb20">
                                                <p>
                                                    لورم ایپسوم به سادگی متن ساختگی صنعت چاپ و حروف چینی است. لورم ایپسوم از دهه 1500 به عنوان متن ساختگی استاندارد صنعت بوده است، زمانی که یک چاپگر ناشناخته یک گالری از نوع را برداشت و آن را به هم زد تا یک کتاب نمونه بسازد.
                                                </p>
                                            </div>
                                            <div class="-client-details-">
                                                <div class="-reviewr">
                                                    <img alt="نظر خوب" class="img-fluid" src="images/client/reviewer-c.jpg"/>
                                                </div>
                                                <div class="reviewer-text">
                                                    <h4>
                                                        <small>
                                                            توسط:
                                                        </small>
                                                        آنا استزیا
                                                    </h4>
                                                    <p>
                                                        20  دی  1400
                                                    </p>
                                                    <div class="star-rate">
                                                        <ul>
                                                            <li>
                                                                <a class="chked" href="javascript:void(0)">
                                                                    <i aria-hidden="true" class="fas fa-star">
                                                                    </i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="chked" href="javascript:void(0)">
                                                                    <i aria-hidden="true" class="fas fa-star">
                                                                    </i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="chked" href="javascript:void(0)">
                                                                    <i aria-hidden="true" class="fas fa-star">
                                                                    </i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="chked" href="javascript:void(0)">
                                                                    <i aria-hidden="true" class="fas fa-star">
                                                                    </i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)">
                                                                    <i aria-hidden="true" class="fas fa-star">
                                                                    </i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div aria-labelledby="tab3c" class="tab-pane fade" id="tab3" role="tabpanel">
                                    <div class="rpb-commentss comments-block">
                                        <div class="media">
                                            <div class="user-image">
                                                <img alt="دختر" class="img-fluid" src="images/user-thumb/user3.jpg"/>
                                            </div>
                                            <div class="media-body user-info">
                                                <h5 class="mb10">
                                                    پیتی کروزر
                                                    <small class="badges badge-success">
                                                        خریدار:
                                                    </small>
                                                    <span>
                               آذر 1398
                              <a class="reply-btn" href="#">
                                <i class="fas fa-reply">
                                </i>
                              </a>
                            </span>
                                                </h5>
                                                <p>
                                                    لورم ایپسوم به سادگی متن ساختگی صنعت چاپ و حروف چینی است. لورم ایپسوم از سال 1500 متن ساختگی استاندارد صنعت بوده است.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="media replied">
                                            <div class="user-image">
                                                <img alt="دختر" class="img-fluid" src="images/user-thumb/user3.jpg"/>
                                            </div>
                                            <div class="media-body user-info">
                                                <h5 class="mb10">
                                                    تام مایکی
                                                    <small class="badges badge-success">
                                                        نویسنده:
                                                    </small>
                                                    <span>
                               آذر 1398
                              <a class="reply-btn" href="#">
                                <i class="fas fa-reply">
                                </i>
                              </a>
                            </span>
                                                </h5>
                                                <p>
                                                    لورم ایپسوم به سادگی متن ساختگی صنعت چاپ و حروف چینی است. لورم ایپسوم متن ساختگی استاندارد این صنعت بوده است.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rpb-comment-form">
                                        <div class="form-block form-blog mt40">
                                            <form action="#" method="post" name="#">
                                                <div class="fieldsets row">
                                                    <div class="col-md-6">
                                                        <input name="#" placeholder="نام" type="text"/>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input name="#" placeholder="پست الکترونیک " type="email"/>
                                                    </div>
                                                </div>
                                                <div class="fieldsets">
                                                    <textarea name="#" placeholder="نظر خود را بنویسید"></textarea>
                                                </div>
                                                <div class="fieldsets mt10">
                                                    <button class="btn-main bg-btn3 lnk" name="#" type="submit">
                                                        ارسال پیام
                                                        <i class="fas fa-chevron-left fa-icon">
                                                        </i>
                                                        <span class="circle">
                              </span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div aria-labelledby="tab4c" class="tab-pane fade" id="tab4" role="tabpanel">
                                    <div class="rpb-itm-support-txt">
                                        <h4>
                                            تماس با ما
                                        </h4>
                                        <p>
                                            لورم ایپسوم به سادگی متن ساختگی چاپ و از طریق فرم تماس با پست الکترونیک است.
                                        </p>
                                        <h4 class="mt30 mb10">
                                            پشتیبانی آیتم شامل:
                                        </h4>
                                        <ul class="ul-list mb30">
                                            <li>
                                                ارائه شده توسط بوت استرپ
                                            </li>
                                            <li>
                                                کدهای به خوبی مستند شده
                                            </li>
                                            <li>
                                                کاملا واکنشگرا
                                            </li>
                                            <li>
                                                فونت های رایگان گوگل
                                            </li>
                                        </ul>
                                        <a href="#">
                                            سیاست پشتیبانی را مشاهده کنید
                                        </a>
                                        <div class="btns">
                                            <a class="mt30 btn-main bg-btn3 lnk" href="#">
                                                دریافت پشتیبانی
                                                <i class="fas fa-chevron-left fa-icon">
                                                </i>
                                                <span class="circle">
                          </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="rpb-item-infodv">
                        <ul>
                            <li class="price">
                                <strong>
                                    قیمت
                                </strong>
                                <div class="nx-rt">
                                    <div class="rpb-itm-pric">
                                    @if($product->offer_price && $product->offer_end_date > $today)
                                        <span class="offer-prz">{{number_format($product->offer_price)}}</span>
                                        <span class="regular-prz">{{number_format($product->price)}}</span>
                                        <small>تومان</small>
                                    @else
                                        <span class="offer-prz">{{number_format($product->price)}}</span>
                                        <small>تومان</small>
                                    @endif
                                    </div>
                                </div>
                            </li>
                            <li>
                                <strong>
                                    آخرین بروزرسانی
                                </strong>
                                <div class="nx-rt">{{verta($product->updated_at)->format('Y-m-d')}}</div>
                            </li>
                            <li>
                                <strong>انتشار</strong>
                                <div class="nx-rt">{{verta($product->published_at)->format('Y-m-d')}}</div>
                            </li>
                            @if($product->lisense_status)
                            <li>
                                <strong>ارایه مدرک</strong>
                                <div class="nx-rt">
                                    بله
                                </div>
                            </li>
                            @endif
                            <li>
                                <strong>
                                    سورس کد
                                </strong>
                                <div class="nx-rt">
                                    دارد
                                </div>
                            </li>
                            <li>
                                <strong>
                                    پشتیبانی
                                </strong>
                                <div class="nx-rt">پشتیبانی رایگان توسط مدرس</div>
                            </li>
                            <li>
                                <strong>تعداد جلسات</strong>
                                <div class="nx-rt">{{$product->sessions}}</div>
                            </li>
                            <li>
                                <strong>مدت دوره</strong>
                                <div class="nx-rt">{{$product->course_time}}</div>
                            </li>
                            <li>
                                <strong>تعداد دانشجو</strong>
                                <div class="nx-rt">{{number_format($product->sales)}}</div>
                            </li>
                            <li>
                                <strong>مدرس دوره</strong>
                                <div class="nx-rt">{{$product->user->name}}</div>
                            </li>
                            <li>
                                <a class="btn-main bg-btn lnk w-100" href="#">
                                    افزودن به سبد خرید
                                    <i class="fas fa-shopping-cart">
                                    </i>
                                    <span class="circle">
                    </span>
                                </a>
                                <a class="btn-main bg-btn3 lnk w-100 mt10" href="#">
                                    هم اکنون خریداری کنید
                                    <span class="circle">
                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="rpb-item-infodv">
                        <h4 class="mb20">
                            برچسب های آیتم
                        </h4>
                        <div class="tabs">
                            <a href="#">
                                طراحی وب
                            </a>
                            <a href="#">
                                طرح
                            </a>
                            <a href="#">
                                طراحی گرافیک
                            </a>
                            <a href="#">
                                سایت اینترنتی
                            </a>
                            <a href="#">
                                بازاریابی
                            </a>
                            <a href="#">
                                برندسازی
                            </a>
                            <a href="#">
                                توسعه وب
                            </a>
                            <a href="#">
                                طراح وب
                            </a>
                            <a href="#">
                                طراحی گرافیک
                            </a>
                            <a href="#">
                                سایت اینترنتی
                            </a>
                            <a href="#">
                                بازاریابی
                            </a>
                            <a href="#">
                                برندسازی
                            </a>
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
