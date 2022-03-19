@extends('layouts.siteLayout')

@section('content')
    <link href="{{ asset('ksy/css/site.css'); }}" rel="stylesheet" />
    <!-- Product Section Begin -->
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
    <section class="product spad product_pdt">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>지역</h4>
                            <input type="text" name="area" id="find_area_text" value=""/>
                            <i id="find_goods_area_icon" class="fa fa-search" aria-hidden="true"></i>
                        </div>
                        <div class="sidebar__item">
                            <h4>가격</h4>
                            <div class="price-range-wrap">
                                <div class="price-range goods-price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                    data-min="100" data-max="10000000">
                                    <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                </div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <input type="text" id="minprice" numberOnly/> ~
                                        <input type="text" id="maxprice" numberOnly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar__item">
                            <h4>상품 상태</h4>
                            <label for="goods_state_all"><input type="radio" name="state" id="goods_state_all" class="goods_state" value="3" checked/>&nbsp;&nbsp;전체</label><br>
                            <label for="goods_state1"><input type="radio" name="state" id="goods_state1" class="goods_state" value="0" />&nbsp;&nbsp;중고상품</label><br>
                            <label for="goods_state2"><input type="radio" name="state" id="goods_state2" class="goods_state" value="1" />&nbsp;&nbsp;새상품</label>  
                        </div>
                        <div class="sidebar__item">
                            <h4>판매 상태</h4>
                            <label for="goods_sale_state_all"><input type="radio" id="goods_sale_state_all" name="sale_state" class="goods_sale_state" value="3" checked/>&nbsp;&nbsp;전체</label><br>
                            <label for="goods_sale_state1"><input type="radio" id="goods_sale_state1" name="sale_state" class="goods_sale_state" value="0" />&nbsp;&nbsp;판매중</label><br>
                            <label for="goods_sale_state2"><input type="radio" id="goods_sale_state2" name="sale_state" class="goods_sale_state" value="1" />&nbsp;&nbsp;판매완료</label><br>
                            <label for="goods_sale_state3"><input type="radio" id="goods_sale_state3" name="sale_state" class="goods_sale_state" value="2" />&nbsp;&nbsp;예약중</label>
                        </div>
                        <div class="sidebar__item">
                            <div class="latest-product__text">
                                <h4>최근 상품</h4>
                                <div class="latest-product__slider owl-carousel">
                                    @if (count($lately_goods) >= 3)
                                        <div class="latest-prdouct__slider__item">
                                            @for ($i = 0; $i < 3; $i++)
                                                <a href="/goods/{{ $lately_goods[$i]->id }}" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img class="m_goods_img" src="{{ asset('storage/images/goods/'.$lately_goods[$i]->goods_image) }}" alt="상품 이미지">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6 class="i_goods_title">{{ $lately_goods[$i]->title }}</h6>
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
                                                            <h6 class="i_goods_title">{{ $lately_goods[$i]->title }}</h6>
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
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="i_category_pick">
                                @if (isset($sel_category_id))
                                    <button type="button">{{ $sel_category_id_name }}</button><i class="fa fa-caret-down arrow" aria-hidden="true"></i>
                                @else
                                    <button type="button">전체</button><i class="fa fa-caret-down arrow" aria-hidden="true"></i>
                                @endif
                            </div>
                            <div id="i_category_select_area">
                                <ul class="i_category_ul">
                                    <li><button type="button" value="0" class="i_category_select {{ isset($sel_category_id) ? '': 'ca_selected'}}">전체</button></li>
                                    @foreach ($categorys as $category)
                                        @if (isset($sel_category_id) && $category->id == $sel_category_id)
                                            <li><button type="button" value="{{ $category->id }}" class="i_category_select ca_selected">{{ $category->name }}</button></li>
                                        @else
                                            <li><button type="button" value="{{ $category->id }}" class="i_category_select">{{ $category->name }}</button></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <input type="hidden" name="category_id" id="category_id" value="{{ isset($sel_category_id) ? $sel_category_id : '0'}}"/>

                            <div id="category_de_box">
                                @if (isset($sel_category_de_id))
                                    <span class="category_between">></span>
                                    <div class="i_category_de_pick">
                                        <button type="button">{{ $sel_category_de_id_name }}</button><i class="fa fa-caret-down arrow" aria-hidden="true"></i>
                                    </div>
                                    <div id="i_category_de_select_area">
                                        <ul class="i_category_ul">
                                            <li><button type="button" value="0" class="i_category_de_select">전체</button></li>
                                            @foreach ($category_des as $category_de)
                                                @if ($category_de->category_id == $sel_category_id)
                                                    @if ($category_de->id == $sel_category_de_id)
                                                        <li><button type="button" value="{{ $category_de->id }}" class="i_category_de_select ca_selected">{{ $category_de->name }}</button></li>
                                                    @else
                                                        <li><button type="button" value="{{ $category_de->id }}" class="i_category_de_select">{{ $category_de->name }}</button></li>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" name="category_de_id" id="category_de_id" value="{{ $sel_category_de_id }}"/>
                                @elseif (!isset($sel_category_de_id) && isset($sel_category_id))
                                    <span class="category_between">></span>
                                    <div class="i_category_de_pick">
                                        <button type="button">전체</button><i class="fa fa-caret-down arrow" aria-hidden="true"></i>
                                    </div>
                                    <div id="i_category_de_select_area">
                                        <ul class="i_category_ul">
                                            <li><button type="button" value="0" class="i_category_de_select ca_selected">전체</button></li>
                                            @foreach ($category_des as $category_de)
                                                @if ($category_de->category_id == $sel_category_id)
                                                    <li><button type="button" value="{{ $category_de->id }}" class="i_category_de_select">{{ $category_de->name }}</button></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" name="category_de_id" id="category_de_id" value="{{ $sel_category_de_id }}"/>
                                @endif
                            </div>
                            
                            <div id="category_de_de_box">
                                @if (isset($sel_category_de_de_id))
                                    <span class="category_between">></span>
                                    <div class="i_category_de_de_pick">
                                        <button type="button">{{ $sel_category_de_de_id_name }}</button><i class="fa fa-caret-down arrow" aria-hidden="true"></i>
                                    </div>
                                    <div id="i_category_de_de_select_area">
                                        <ul class="i_category_ul">
                                            <li><button type="button" value="0" class="i_category_de_de_select">전체</button></li>
                                            @foreach ($category_de_des as $category_de_de)
                                                @if ($category_de_de->category_de_id == $sel_category_de_id)
                                                    @if ($category_de_de->id == $sel_category_de_de_id)
                                                        <li><button type="button" value="{{ $category_de_de->id }}" class="i_category_de_de_select ca_selected">{{ $category_de_de->name }}</button></li>
                                                    @else
                                                        <li><button type="button" value="{{ $category_de_de->id }}" class="i_category_de_de_select">{{ $category_de_de->name }}</button></li>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" name="category_de_de_id" id="category_de_de_id" value="{{ $sel_category_de_de_id }}"/>
                                @elseif (!isset($sel_category_de_de_id) && isset($sel_category_de_id))
                                    <span class="category_between">></span>
                                    <div class="i_category_de_de_pick">
                                        <button type="button">전체</button><i class="fa fa-caret-down arrow" aria-hidden="true"></i>
                                    </div>
                                    <div id="i_category_de_de_select_area">
                                        <ul class="i_category_ul">
                                            <li><button type="button" value="0" class="i_category_de_de_select ca_selected">전체</button></li>
                                            @foreach ($category_de_des as $category_de_de)
                                                @if ($category_de_de->category_de_id == $sel_category_de_id)
                                                    <li><button type="button" value="{{ $category_de_de->id }}" class="i_category_de_de_select">{{ $category_de_de->name }}</button></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" name="category_de_de_id" id="category_de_de_id" value="{{ $sel_category_de_de_id }}"/>
                                @endif
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="filter__item pdt">
                        <div class="row">
                            <div class="col-lg-12" id="sear_area">
                                <span id="search_result">{{ isset($search) ? $search : '' }}</span>&nbsp;&nbsp;검색결과&nbsp;&nbsp;&nbsp;<span id="goods_count_box">(<span id="goods_count">{{ $goods->total() }}</span>개)<span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-5">
                                <div class="filter__sort">
                                    <span>정렬</span>
                                    <select id="order" onchange="sel_order()">
                                        <option value="0">최신순</option>
                                        <option value="1">저가순</option>
                                        <option value="2">고가순</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="goods_area">
                        @include('sites.goods.goodsResult')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('ksy/js/site.js'); }}"></script>
@endsection