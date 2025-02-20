@extends('layouts.Main')
@section('title', $model->name)
@section('header')

@endsection

@section('content')
    <!--Breadcrumb Area-->
    <section class="breadcrumb-area banner-2">
        <div class="text-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 v-center">
                        <div class="bread-inner">
                            <div class="bread-menu">
                                <ul>
                                    <li>
                                        <a href="/">
                                            صفحه اصلی
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/blog">
                                            وبلاگ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/blog/article/{{$model->sku}}">
                                            {{$model->name}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="bread-title">
                                <h2>{{$model->name}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Breadcrumb Area-->
    <!--Start Blog Details-->
    <section class="blog-page pad-tb">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-header">
                        <h1>{{$model->subtitle ?? $model->name}}</h1>
                        <div class="row mt20 mb20">
                            <div class="col-md-8 col-9">
                                <div class="media">
                                    <div class="user-image bdr-radius">
                                        <img alt="{{$model->user->nick_name ?? $model->user->name}}"
                                             class="img-fluid" src="{{$model->user->avatar}}"/>
                                    </div>
                                    <div class="media-body user-info">
                                        <h5>
                                            توسط: {{$model->user->nick_name ?? $model->user->name}}
                                        </h5>
                                        <p>{{verta($model->published_at)->format('Y-m-d')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-3">
                                <div class="postwatch">
                                    <i class="far fa-eye">
                                    </i>
                                    {{number_format($model->views)}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="image-set">
                        <img alt="{{$model->name}}" class="img-fluid" src="{{$model->image}}"/>
                    </div>
                    <div class="blog-content mt30">
                        {!! $model->description !!}

                    </div>
                </div>
                <!--End Blog Details-->
                <!--Start Sidebar-->
                <div class="col-lg-4">
                    <div class="sidebar">
                        <!--Start block for offer/ads-->
                        <div class="offer-image">
                            <a href="https://melipayamak.com/?aff=5YPYP" target="_blank" rel="nofollow">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <img src="/ads/melipayamak.png" class="img-fluid">
                                        <p class="mt-2">سرویس پیامکی ملی پیامک</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="offer-image">
                            <div id="pos-article-display-63671"></div>
                        </div>
                        <!--End block for offer/ads-->
                        <!--Start Recent post-->
                        <div class="recent-post widgets mt60">
                            <h3 class="mb30">
                                مطالب مرتبط
                            </h3>
                            @foreach($related_posts as $post)


                            <div class="media">
                                <div class="post-image bdr-radius">
                                    <a href="/blog/article/{{$post->sku}}">
                                        <img alt="{{$post->name}}" class="img-fluid" src="{{$post->image}}"/>
                                    </a>
                                </div>
                                <div class="media-body post-info">
                                    <h5>
                                        <a href="/blog/article/{{$post->sku}}" target="_blank">{{$post->name}}</a>
                                    </h5>
                                    <p>{{verta($post->published_at)->format('Y-m-d')}}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                <!--End Sidebar-->
            </div>
        </div>
    </section>
@endsection
