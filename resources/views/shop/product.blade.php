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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end Breadcrumb Area-->
    <!--shop products-->
    <section class="shop-products-prvw pt20 pb60" id="vueapp">
        <div class="container shop-container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="rpb-shop-prevw">
                        <img alt="{{$product->subtitle ?? $product->name}}" class="w-100" src="{{$product->image}}"/>
                    </div>
                    <div class="rpb-item-info">
                        <div class="tab-17 tabs-layout">
                            <ul class="nav nav-tabs" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a aria-controls="tab1" aria-selected="true" class="nav-link active" data-bs-toggle="tab" href="#tab1" id="tab1a" role="tab">
                                        جزئیات
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a aria-controls="tab3" aria-selected="false" class="nav-link" data-bs-toggle="tab" href="#tab3" id="tab3c" role="tab">
                                        نظرات
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a aria-controls="tab4" aria-selected="false" class="nav-link" data-bs-toggle="tab" href="#tab4" id="tab4c" role="tab">
                                        خرید اقساطی
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent2">
                                <div aria-labelledby="tab1a" class="mt20 tab-pane fade show active" id="tab1" role="tabpanel">
                                    <h4 class="mb10">
                                        {{$product->subtitle ?? $product->name}}
                                    </h4>
                                    <div class="mb30 product-description">
                                        {!! $product->description !!}
                                    </div>

                                </div>
                                <div aria-labelledby="tab3c" class="tab-pane fade" id="tab3" role="tabpanel">
                                    <div class="rpb-commentss comments-block">
                                        @foreach($product->comments as $comment)
                                        <div class="media">
                                            <div class="user-image">
                                                <img alt="{{$comment->user->nick_name ?? $comment->user->name}}"
                                                     class="img-fluid" src="{{$comment->user->avatar}}"/>
                                            </div>
                                            <div class="media-body user-info">
                                                <h5 class="mb10">
                                                    {{$comment->user->nick_name ?? $comment->user->name}}
                                                    <small class="badges badge-success">
                                                        @if($comment->user->hasRole('teacher'))
                                                            (کارشناس پشتیبان)
                                                        @else
                                                        (دانشجو)
                                                        @endif

                                                    </small>
                                                    <span>
                                                       {{verta($comment->created_at)->format('Y-m-d')}}
                                                      <span class="reply-btn ms-1 text-info" @click="changeParentId({{$comment->id}})">
                                                        <i class="fas fa-reply">
                                                        </i>
                                                      </span>
                                                    </span>
                                                </h5>
                                                <p>{{$comment->content}}</p>
                                            </div>
                                        </div>
                                            @foreach($comment->replies as $reply)
                                                <div class="media replied bg-light">
                                                <div class="user-image">
                                                    <img alt="{{$reply->user->nick_name ?? $reply->user->name}}"
                                                         class="img-fluid" src="{{$reply->user->avatar}}"/>
                                                </div>
                                                <div class="media-body user-info">
                                                    <h5 class="mb10">
                                                        {{$reply->user->nick_name ?? $reply->user->name}}
                                                        <small class="badges badge-success">
                                                            @if($reply->user->hasRole('teacher'))
                                                                (کارشناس پشتیبان)
                                                            @else
                                                                (دانشجو)
                                                            @endif
                                                        </small>
                                                        <span>
                                                           {{verta($reply->created_at)->format('Y-m-d')}}

                                                        </span>
                                                    </h5>
                                                    <p>{!! $reply->content !!}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                    @auth
                                    <div class="rpb-comment-form mb-5">
                                        <div class="form-block form-blog mt40">

                                                <div class="fieldsets">
                                                    <label class="form-label">پاسخ به</label>
                                                    <select name="parent_id" v-model="comment.parent_id" class="form-control">
                                                        <option value="0">{{$product->name}}</option>
                                                        @foreach($product->comments as $comment)
                                                            <option value="{{$comment->id}}">{{strlen($comment->content) > 70 ? substr($comment->content, 0, 70) . '...' : $comment->content}}</option>
                                                            @foreach($comment->replies as $reply)
                                                                <option value="{{$reply->id}}" style="padding-right: 1rem">{{strlen($reply->content) > 70 ? substr($reply->content, 0, 70). '...' : $reply->content}}</option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="fieldsets">
                                                    <textarea v-model="comment.description" name="description" minlength="2" maxlength="250" placeholder="نظر خود را بنویسید" required></textarea>
                                                </div>
                                                <div class="fieldsets mt10">
                                                    <div v-if="comment_message" class="mb-2 alert alert-success">
                                                        <p>@{{ comment_message }}</p>
                                                    </div>
                                                    <p v-if="comment_error" class="mb-2 alert alert-danger">@{{ comment_error }}</p>
                                                    <button @click="sendComment" class="btn-main bg-btn3 lnk" type="submit">
                                                        ارسال پیام
                                                        <i class="fas fa-chevron-left fa-icon"></i>
                                                        <span class="circle"></span>
                                                    </button>
                                                </div>
                                        </div>
                                    </div>
                                    @endauth
                                </div>
                                <div aria-labelledby="tab4c" class="tab-pane fade" id="tab4" role="tabpanel">
                                    <div class="rpb-itm-support-txt mb-5">
                                        <h4>روش های سفارش دوره</h4>
                                        <p>شما عزیزان می توانید به دو روش نقد یا قسطی دوره ها را تهیه نمایید</p>
                                        <h5 class="mt30 mb10">خرید نقدی</h5>
                                        <p>برای خرید نقدی می توانید از دکمه خرید نقدی استفاده نمایید و سفارش خود را تکمیل نمایید و هزینه را بصورت آنلاین پرداخت نمایید</p>

                                        <h4 class="mt30 mb10">خرید قسطی</h4>
                                        <p>خرید قسطی تنها برای <strong class="text-danger">دوره های بالای 500 هزار تومان</strong> فعال می باشد</p>


                                        <div class="btns">
                                            <button type="button" class="mt30 btn-main bg-btn lnk" href="#">
                                                خرید نقدی
                                                @if($product->offer_price && $product->offer_end_date > $today)
                                                    <span>({{number_format($product->offer_price)}})</span>
                                                @else
                                                    <span>({{number_format($product->price)}})</span>

                                                @endif

                                                <i class="fas fa-chevron-left fa-icon">
                                                </i>
                                                <span class="circle"></span>
                                            </button>
                                            @if($product->price > 500000)
                                            <button type="button" class="mt-3 btn-main bg-btn3 lnk">
                                                خرید قسطی
                                                @if($product->offer_price && $product->offer_end_date > $today)
                                                    <span>({{number_format(intval($product->offer_price * 1.1))}})</span>
                                                @else
                                                    <span>({{number_format(intval($product->price * 1.1))}})</span>

                                                @endif

                                                <i class="fas fa-chevron-left fa-icon">
                                                </i>
                                                <span class="circle"></span>
                                            </button>
                                            @endif

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
                                    قیمت <small>(تومان)</small>
                                </strong>
                                <div class="nx-rt">
                                    <div class="rpb-itm-pric">
                                    @if($product->offer_price && $product->offer_end_date > $today)
                                            <span class="offer-prz">
                                            {{format_price($product->offer_price)}}
                                        </span>
                                            <span class="regular-prz me-1">
                                            {{format_price($product->price)}}
                                        </span>
                                    @else
                                        <span class="offer-prz">{{format_price($product->price)}}</span>
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
                                <div class="nx-rt">پشتیبانی توسط مدرس</div>
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
                            @guest
                            <li class="my-5">
                                <button type="button" data-bs-target="#auth-modal" data-bs-toggle="modal"
                                        class="btn-main niwax-btn4 w-100">ورود/عضویت</button>
                            </li>
                            @else
                                <li class="my-2">
                                    <div v-if="message" class="alert alert-success">
                                        <p>@{{ message }}</p>
                                        <br />
                                        <a href="/cart" class="nav-link text-primary font-weight-bold">مشاهده سبد خرید</a>
                                    </div>
                                    <p v-if="error" class="alert alert-danger">@{{ error }}</p>
                                </li>
                            @endguest
                            <li>
                                <button @click="addToCart" type="button" class="btn-main bg-btn lnk w-100">
                                    افزودن به سبد خرید
                                    <i class="fas fa-shopping-cart">
                                    </i>
                                    <span class="circle"></span>
                                </button>
                                <button class="btn-main bg-btn3 lnk w-100 mt10" type="button">
                                    خرید قسطی دوره
                                    <span class="circle"></span>
                                </button>
                            </li>
                        </ul>



                    </div>
                    <div class="rpb-item-infodv">
                        <h5 class="mb20">درباره مدرس</h5>
                        <div class="about-teacher">
                            <h6>{{$product->user->name}}</h6>
                            <p>{{$product->user->bio}}</p>
                            <div class="project-platform mt60 pl25">
                                @if($product->user->whatsapp)
                                <div class="project-platform-used -shadow">
                                    <a href="{{$product->user->whatsapp}}" target="_blank">
                                        <img class="author-social" alt="واتساپ" src="/icons/whatsapp.svg"/>
                                    </a>
                                </div>
                                @endif
                                @if($product->user->telegram)
                                <div class="project-platform-used -shadow">
                                    <a href="{{$product->user->telegram}}" target="_blank">
                                        <img class="author-social" alt="تلگرام" src="/icons/telegram.svg"/>
                                    </a>
                                </div>
                                @endif
                                @if($product->user->instagram)
                                    <div class="project-platform-used -shadow">
                                        <a href="{{$product->user->instagram}}" target="_blank">
                                            <img class="author-social" alt="اینستاگرام" src="/icons/instagram.svg"/>
                                        </a>
                                    </div>
                                @endif
                            </div>
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
                    stock: 1,
                    message: '',
                    error: '',
                    comment: {
                        description: '',
                        parent_id: 0,
                        product_id: {{$product->id}}
                    }
                }
            },
            methods:{
                async changeParentId(parent_id)
                {
                  this.comment.parent_id = Number(parent_id)
                },
                async sendComment(){
                    this.error = '';
                    this.message = '';
                    let token = document.head.querySelector('meta[name="csrf-token"]');
                    if(this.qty > this.stock)
                    {
                        this.error = 'لطفا تعداد را به درستی وارد نمایید. تعداد درخواستی بیشتر از موجودی انبار است'
                    }
                    else {
                        fetch("{{route('store_product_comment')}}", {
                            headers: {
                                'Content-type': 'application/json',
                                'Accept': 'application/json'
                            },
                            method: 'POST',
                            body: JSON.stringify({
                                description: this.comment.description,
                                parent_id: this.comment.parent_id,
                                product_id: this.comment.product_id,
                                _token: token.content
                            })
                        }).then(res => {
                            if(res.status >=200 && res.status <= 204)
                            {
                                this.comment.description = '';
                                this.comment_message = 'نظر شما با موفقیت ارسال شد'
                            }
                            else if(res.status === 401){
                                this.comment_error = 'لطفا وارد حساب کاربری خود شوید'
                                window.location.replace('/register')
                            }
                            else {
                                this.comment_error = 'خطایی در ارسال نظر رخ داد. لطفا دوباره تلاش نمایید'
                            }
                        }).catch((error) => {
                            console.log(error);
                            this.comment_error = 'خطایی در ارسال نظر رخ داد. لطفا دوباره تلاش نمایید'
                        });
                    }

                },
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
