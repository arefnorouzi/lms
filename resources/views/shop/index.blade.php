@extends('layouts.Main')
@section('title','فروشگاه')
@section('content')

    <!--Breadcrumb Area-->
    <section class="breadcrumb-area banner-5">
        <div class="text-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 v-center">
                        <div class="bread-inner">
                            <div class="bread-title">
                                <h2>جدیدترین دوره ها</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Breadcrumb Area-->

    <!--shop products-->
    <section class="blog-page pad-tb pt40">
        <div class="container">
            <div class="row">
                @include('components.shop.products', ['products'])
            </div>

            <div class="row my-3">
                <div class="col-lg-12">
                    {{$products->links('vendor.pagination')}}
                </div>
            </div>
        </div>
        <!-- // -->
@endsection
