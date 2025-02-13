<?php $color_status = false;?>
@foreach($products as $product)
        <?php $color_status = !$color_status;?>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mt60">
        <div class="single-blog-post- shdo">
            <div class="single-blog-img-">
                <a href="/shop/product/{{$product->sku}}" target="_blank">
                    <img alt="{{$product->name}}" class="img-fluid" src="/images/blog/blog-dg-1.jpg"/>
                </a>
                <div class="entry-blog-post @if($color_status) bg-gradient12 @else dg-bg2 @endif">
                              <span class="bypost-">
                                <a href="/shop/category/{{$product->category->slug}}" target="_blank">
                                  <i class="fas fa-tag">
                                  </i>
                                   {{$product->category->name}}
                                </a>
                              </span>
                    <span class="posted-on-">
                    <a href="#">
                      <i class="fas fa-clock">
                      </i>
                        {{$product->course_time}}
                    </a>
                  </span>
                </div>
            </div>
            <div class="blog-content-tt">
                <div class="single-blog-info-">
                    <h4 class="product-title">
                        <a href="/shop/product/{{$product->sku}}" target="_blank">{{$product->name}}</a>
                    </h4>
                    <p class="subtitle">{{$product->subtitle}}</p>
                </div>
                <div class="post-social">
                    <div class="rpb-shop-items-flex">
                        <div class="rpb-shop-inf-ll">
                            <div class="rpb-itm-sale">
                                {{number_format($product->sales)}} دانشجو
                            </div>
                        </div>
                        <div class="rpb-shop-inf-rr">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
