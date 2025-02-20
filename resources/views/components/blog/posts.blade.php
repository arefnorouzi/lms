<?php $color_status = false;?>
@foreach($model as $post)
        <?php $color_status = !$color_status;?>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mt60">
        <div class="single-blog-post- shdo">
            <div class="single-blog-img-">
                <a href="/blog/article/{{$post->sku}}" target="_blank">
                    <img alt="{{$post->subtitle ?? $post->name}}" class="img-fluid"
                         src="{{$post->image}}"/>
                </a>
                <div class="entry-blog-post @if($color_status) bg-gradient12 @else dg-bg2 @endif">
                              <span class="bypost-">
                                <a href="/blog/category/{{$post->category->slug}}" target="_blank">
                                  <i class="fas fa-tag">
                                  </i>
                                   {{$post->category->name}}
                                </a>
                              </span>
                    <span class="posted-on-">
                    <a href="#">
                      <i class="fas fa-clock">
                      </i>
                        {{$post->course_time}}
                    </a>
                  </span>
                </div>
            </div>
            <div class="blog-content-tt">
                <div class="single-blog-info-">
                    <h4 class="product-title">
                        <a href="/blog/article/{{$post->sku}}" target="_blank">{{$post->name}}</a>
                    </h4>
                    <p class="subtitle">{{$post->subtitle}}</p>
                </div>
                <div class="post-social">
                    <div class="rpb-shop-items-flex">
                        <div class="rpb-shop-inf-ll">
                            <div class="rpb-itm-sale">
                                {{number_format($post->sales)}} دانشجو
                            </div>
                        </div>
                        <div class="rpb-shop-inf-rr">
                            <div class="rpb-itm-pric">
                                @if($post->offer_price && $post->offer_end_date > $today)
                                    <span class="offer-prz">{{format_price($post->offer_price)}}</span>
                                    <span class="regular-prz">{{format_price($post->price)}}</span>
                                    <small>تومان</small>
                                @else
                                    <span class="offer-prz">{{format_price($post->price)}}</span>
                                    <small>تومان</small>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
