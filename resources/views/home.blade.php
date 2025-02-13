@extends('layouts.Main')
@section('title', 'آموزش برنامه نویسی و طراحی سایت')
@section('header')

@endsection

@section('content')
    <!--Breadcrumb Area-->
    <section class="breadcrumb-areav2" data-background="images/banner/4.jpg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="bread-titlev2">
                        <h2 class="wow fadeInUp" data-wow-delay=".2s">
                            قالب های وب سایت، پلاگین ها و بازار دیجیتال گرافیکی
                        </h2>
                        <p class="mt20 wow fadeInUp" data-wow-delay=".4s">
                            برای شروع از کادر جستجوی زیر استفاده کنید. بهترین مکان برای خرید و فروش محصولات دیجیتال.
                        </p>
                        <div class="email-subs-form mt40">
                            <form>
                                <input class="no-shadow" name="search-shop" placeholder="جستجوی تم، افزونه ها.." type="text"/>
                                <button class="lnk btn-main bg-btn no-shadow" name="submit" type="submit">
                                    جستجو
                                    <i class="fas fa-chevron-left fa-icon">
                                    </i>
                                    <span class="circle">
                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @if(isset($categories) && count($categories))
                <div class="col-lg-12">
                    <div class="text-center">
                        <ul class="h-scroll pb0 tech-icons">
                            @foreach($categories as $category)
                            <li>
                                <a href="/shop/category/{{$category->name}}">
                                    <img alt="{{$category->name}}" src="{{$category->image}}"/>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    <!--end Breadcrumb Area-->
    <!--shop products-->
    <section class="blog-page pad-tb pt40">
        <div class="container">
            <div class="row">
                @include('components.shop.products', ['products'])
            </div>
        </div>
    </section>
    <!-- // -->
@endsection
