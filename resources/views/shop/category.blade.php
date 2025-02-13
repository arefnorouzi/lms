@extends('layouts.Main')
@section('title', $category->name)
@section('header')
    <meta name="description" content="{{$category->meta}}">
    <meta name="keywords" content="{{$category->keywords}}">
@endsection
@section('content')

    <!-- Main -->
    <section class="product product-sidebar footer-padding">
        <div class="container">
            <div class="product-sidebar-section" data-aos="fade-up">
                <div class="row g-5">
                    <div class="col-lg-12">
                        <div class="product-sorting-section">
                            <h5>{{$category->name}}</h5>
                        </div>
                    </div>

                    @foreach($products as $product)
                        <div class="col-lg-4 col-sm-6">
                            <a href="/shop/product/{{$product->sku}}">
                            <div class="product-wrapper" data-aos="fade-up">
                                <div class="product-img">
                                    @if($product->thumbnail)
                                        <img src="{{$product->thumbnail}}" alt="{{$product->name}}">
                                    @elseif($product->image)
                                        <img src="{{$product->image}}" alt="{{$product->name}}">
                                    @else
                                        -
                                    @endif
                                </div>
                                <div class="product-info">
                                    <div class="product-description">
                                        <a href="/shop/product/{{$product->sku}}" class="product-details">{{$product->name}}</a>
                                        @if($product->offer_price && $product->offer_end_date > $today)
                                            <div class="price">
                                                <span class="price-cut">{{number_format($product->price)}}</span>
                                                <span class="new-price">{{number_format($product->offer_price)}}</span>
                                            </div>
                                        @else
                                            <div class="price">
                                                <span class="new-price">{{number_format($product->price)}}</span>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="product-cart-btn">
                                    <a href="/shop/product/{{$product->sku}}" class="product-btn">سفارش محصول</a>

                                </div>
                            </div>
                            </a>
                        </div>
                    @endforeach


                    <!-- Ad section -->
                    <div class="col-lg-12">
                        {{$products->links('vendor.pagination')}}
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
