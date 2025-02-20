@extends('layouts.Main')
@section('title','وبلاگ')
@section('content')

    <!--Breadcrumb Area-->
    <section class="breadcrumb-area banner-5">
        <div class="text-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 v-center">
                        <div class="bread-inner">
                            <div class="bread-title">
                                <h2>آخرین مقالات</h2>
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
                @include('components.blog.posts', ['model'])
            </div>

            <div class="row my-3">
                <div class="col-lg-12">
                    {{$model->links('vendor.pagination')}}
                </div>
            </div>
        </div>
        <!-- // -->
@endsection
