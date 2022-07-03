@extends('layouts.siteLayout')

@section('big_advertisement')
<link href="{{ asset('ksy/css/site.css'); }}" rel="stylesheet" />
<div id="heart-layer">
    <div id="heart-content">
        <i id="heart_icon" class="fa fa-heart fa-3x" aria-hidden="true"></i><br>
        <span id="h_span">찜!</span>
    </div>
</div>

<div id="heart-del-layer">
    <div id="heart-content">
        <i id="heart_icon" class="fa fa-heart-o fa-3x" aria-hidden="true"></i><br>
        <span id="h_span">찜 해제</span>
    </div>
</div>

<div class="row" style="margin-top : 10px;">
    <div class="col">
        <div class="hero__item set-bg" data-setbg="{{ asset('template/ogani-master/pic.png'); }}">
        </div>
    </div>
</div>
@endsection

@section('content')
<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('template/ogani-master/pic.png'); }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('template/ogani-master/pic.png'); }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('template/ogani-master/pic.png'); }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('template/ogani-master/pic.png'); }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="{{ asset('template/ogani-master/pic.png'); }}">
                    </div>
                </div>
            </div>    
        </div>
    </div>
</section>
<!-- Categories Section End -->
<br><br>
<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h4>오늘의 상품 추천</h4>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            @foreach ($today_goods as $index=>$today_good)
                <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat" onclick="location.href='/goods/{{ $today_good->id }}'" id="today_goods_area">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="{{ asset('storage/images/goods/'.$today_good->goods_image) }}">
                            <ul class="featured__item__pic__hover">
                                <li class="heart_pop">
                                    <a class="{{ $isHearts[$index] == 0 ? 'rel_heart_t' : ''}}"><i class="fa fa-heart"></i></a>
                                    <input type="hidden" name="{{ $today_good->id }}" value="{{ $isHearts[$index]}}" />
                                </li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6 id="today_goods_title">{{ $today_good->title }}</h6>
                            <h5>{{ number_format($today_good->price) }} 원<span id="m_goods_writeday">{{ $today_good->writeday }}</span></h5> 
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Section End -->

<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>최근에 올라온 상품</h4>
                    <div class="latest-product__slider owl-carousel">
                        @if (count($lately_goods) >= 3)
                            <div class="latest-prdouct__slider__item">
                                @for ($i = 0; $i < 3; $i++)
                                    <a href="/goods/{{ $lately_goods[$i]->id }}" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img class="m_goods_img" src="{{ asset('storage/images/goods/'.$lately_goods[$i]->goods_image) }}" alt="상품 이미지">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6 id="m_goods_title">{{ $lately_goods[$i]->title }}</h6>
                                            <span class="lately_goods_writeday"><i class="fa fa-clock-o fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;{{ $lately_goods[$i]->writeday }}</span>
                                            <span>{{ number_format($lately_goods[$i]->price) }} 원</span>
                                        </div>
                                    </a>
                                @endfor
                            </div>
                            @if (count($lately_goods) >= 4)
                                <div class="latest-prdouct__slider__item">
                                    @for ($i = $i; $i < count($lately_goods); $i++)
                                        <a href="/goods/{{ $lately_goods[$i]->id }}" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img class="m_goods_img" src="{{ asset('storage/images/goods/'.$lately_goods[$i]->goods_image) }}" alt="상품 이미지">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6 id="m_goods_title">{{ $lately_goods[$i]->title }}</h6>
                                                <span class="lately_goods_writeday"><i class="fa fa-clock-o fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;{{ $lately_goods[$i]->writeday }}</span>
                                                <span>{{ number_format($lately_goods[$i]->price) }} 원</span>
                                            </div>
                                        </a>
                                    @endfor
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>찜 개수 높은 상품</h4>
                    <div class="latest-product__slider owl-carousel">
                        @if (count($heart_high_goods) >= 3)
                            <div class="latest-prdouct__slider__item">
                                @for ($i = 0; $i < 3; $i++)
                                    <a href="/goods/{{ $heart_high_goods[$i]->id }}" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img class="m_goods_img" src="{{ asset('storage/images/goods/'.$heart_high_goods[$i]->goods_image) }}" alt="상품 이미지">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6 id="m_goods_title">{{ $heart_high_goods[$i]->title }}</h6>
                                            <span class="heart_high_goods_h"><i class="fa fa-heart fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;{{ $heart_high_goods[$i]->heart }}</span>
                                            <span>{{ number_format($heart_high_goods[$i]->price) }} 원</span>
                                        </div>
                                    </a>
                                @endfor
                            </div>
                            @if (count($heart_high_goods) >= 4)
                                <div class="latest-prdouct__slider__item">
                                    @for ($i = $i; $i < count($heart_high_goods); $i++)
                                        <a href="/goods/{{ $heart_high_goods[$i]->id }}" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img class="m_goods_img" src="{{ asset('storage/images/goods/'.$heart_high_goods[$i]->goods_image) }}" alt="상품 이미지">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6 id="m_goods_title">{{ $heart_high_goods[$i]->title }}</h6>
                                                <span class="heart_high_goods_h"><i class="fa fa-heart fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;{{ $heart_high_goods[$i]->heart }}</span>
                                                <span>{{ number_format($heart_high_goods[$i]->price) }} 원</span>
                                            </div>
                                        </a>
                                    @endfor
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>후기가 좋은 상품</h4>
                    <div class="latest-product__slider owl-carousel">
                        @if (count($star_high_goods) >= 3)
                            <div class="latest-prdouct__slider__item">
                                @for ($i = 0; $i < 3; $i++)
                                    <a href="/goods/{{ $star_high_goods[$i]->id }}" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img class="m_goods_img" src="{{ asset('storage/images/goods/'.$star_high_goods[$i]->goods_image) }}" alt="상품 이미지">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6 id="m_goods_title">{{ $star_high_goods[$i]->title }}</h6>
                                            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                                            <script src="{{ asset('ksy/js/site.js'); }}"></script>   
                                            <div id="review_star_{{ $star_high_goods[$i]->id }}" class="star_high_goods_s">
                                                <script>
                                                    list_set_star_not_num({{ $star_high_goods[$i]->star }}, 'review_star_{{ $star_high_goods[$i]->id }}');
                                                </script>
                                            </div>
                                            <span>{{ number_format($star_high_goods[$i]->price) }} 원</span>
                                        </div>
                                    </a>
                                @endfor
                            </div>
                            @if (count($star_high_goods) >= 4)
                                <div class="latest-prdouct__slider__item">
                                    @for ($i = $i; $i < count($star_high_goods); $i++)
                                        <a href="/goods/{{ $star_high_goods[$i]->id }}" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img class="m_goods_img" src="{{ asset('storage/images/goods/'.$star_high_goods[$i]->goods_image) }}" alt="상품 이미지">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6 id="m_goods_title">{{ $star_high_goods[$i]->title }}</h6>
                                                <div id="review_star_{{ $star_high_goods[$i]->id }}" class="star_high_goods_s">
                                                    <script>
                                                        list_set_star_not_num({{ $star_high_goods[$i]->star }}, 'review_star_{{ $star_high_goods[$i]->id }}');
                                                    </script>
                                                </div>
                                                <span>{{ number_format($star_high_goods[$i]->price) }} 원</span>
                                            </div>
                                        </a>
                                    @endfor
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
                    
<script>
    $('.heart_pop').click (function (e) {
        e.stopPropagation();
        let isLogin = '{{ auth()->check() }}';

        if (isLogin == '') {
            alert("로그인 후 사용할 수 있습니다.");
            return;
        }

        heart_pop_func(this);
    });
</script>
@endsection