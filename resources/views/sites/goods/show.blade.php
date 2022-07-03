@extends('layouts.siteLayout')

@section('content')
    <link href="{{ asset('ksy/css/site.css'); }}" rel="stylesheet" />
    <div id="pay_modal" class="modal">
        <div id="pay_area">
            <div id="pay_title">인덕안심페이&nbsp;&nbsp;<i class="fa fa-credit-card fa-lg" aria-hidden="true"></i></div>
            <br>
            <div id="induk_pay_content">
                <img src="{{ asset('img/indukPay.JPG') }}" />
                <b style="font-size : 15pt">인덕안심페이</b>&nbsp; 란?<br>
                인덕마켓 측에 먼저 금액을 입금하여 보관하고, 구매자가 구매 확정 버튼을 눌렀을 때
                판매자에게 금액이 입금되는 형태의 결제 방법입니다.<br><br>
                수수료 : 상품 금액의 3.5%<br>
                결제 방법 : 카카오페이 간편결제<br>
            </div>
            <br>
            <span class="close_pay_modal">&times;</span>
            <div style="text-align : center">
            <button id="pay_btn" onclick="requestPay({{ auth()->check() }})">안심페이로 구매하기</button>
            </div>
        </div>
    </div>

    
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

    <!-- Product Details Section Begin -->
    <section class="product-details spad" id="s_section">
        <div class="container">
            <div class="row" id="show_area">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img id="big_img" class="product__details__pic__item--large"
                                src="{{ asset('storage/images/goods/'.$images[0]->name) }}" alt="대표이미지">
                            <div id="origin_img_area">
                                <div id="origin">원본</div>
                                <i class="fa fa-search" aria-hidden="true" id="origin_search_icon"></i>
                            </div>
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            @foreach ($images as $image)
                                <img id="small_img" data-imgbigurl="{{ asset('storage/images/goods/'.$image->name) }}"
                                    src="{{ asset('storage/images/goods/'.$image->name) }}" alt="상품이미지">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <div id="goods_cate">{{ $good->category_name }} {{ $good->category_de_name ? ' > '.$good->category_de_name : ''}} 
                                        {{ $good->category_de_de_name ? ' > '.$good->category_de_de_name : '' }}</div>
                        <h3 id="goods_ti">{{ $good->title }}</h3>
                        <div id="goods_pri_d"><span id="goods_pri">{{ number_format($good->price) }}</span> <span id="goods_won">원</span></div>
                        <div id="goods_det_area">
                            <span id="goods_det"><i class="fa fa-heart fa-lg" aria-hidden="true"></i> <span id="heart_num">{{ $good->heart }}</span></span>
                            <span id="goods_det"><i class="fa fa-eye fa-lg" aria-hidden="true"></i> {{ $good->view }}</span>
                            <span><i class="fa fa-clock-o fa-lg" aria-hidden="true"></i> {{ $good->writeday }}</span>
                        </div>
                        <ul id="mar_b">
                            <li id="mar_t"><b>상품상태</b> <span>{{ $set_good['state'] }}</span></li>
                            <li><b>교환여부</b> <span>{{ $set_good['exchange'] }}</span></li>
                            <li><b>배송비</b> <span>{{ $set_good['delivery_fee'] }}</span></li>
                            <li><b>거래지역</b> <span>{{ $good->area }}</span></li>
                        </ul>
                        {{-- 현재 로그인한 사용자가 본인 글에 들어왔을 경우 --}}
                        @if (auth()->id() != $good->user_id)
                            <button type="button" id="call_btn" class="primary-btn">채팅하기</button>
                            <button type="button" id="now_buy_btn" class="primary-btn">바로구매</button>
                            <button onclick="clickHeartBtn({{ auth()->check() }})"type="button" id="heart_btn" class="primary-btn {{ $isHeart == 0 ? 'heart_btn_t' : 'heart_btn_f' }}"><i class="fa fa-heart fa-lg" aria-hidden="true"></i></button>
                            <input type="hidden" id="isHeart" value="{{ $isHeart }}" />
                        @else
                            <button onclick="location.href='{{ $good->id }}/edit'" type="button" id="my_store_button" class="primary-btn">상품 수정하기</button>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">상품정보</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">상품문의</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                    aria-selected="false">상점정보</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <div class="row">
                                        <div class="col-6">
                                            <h6>상품 정보</h6>
                                            <hr>
                                            <p>{{ $good->content }}</p>
                                            <br>
                                        </div>
                                        <div class="col-5" id="goods_info">
                                            <table class="g_s_table">
                                                <tr>
                                                    <td class="g_s_table_title" width="35%"><i class="fa fa-map-marker" id="area_icon" aria-hidden="true"></i><b>거래지역</b></td>
                                                    <td>{{ $good->area }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="g_s_table_title" width="35%"><i class="fa fa-bars" aria-hidden="true" id="category_icon"></i><b>카테고리</b></td>
                                                    <td>{{ $good->category_name }} {{ $good->category_de_name ? ' > '.$good->category_de_name : ''}} 
                                                        {{ $good->category_de_de_name ? ' > '.$good->category_de_de_name : '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="g_s_table_title" width="35%"><i class="fa fa-tag" id="ttag_icon" aria-hidden="true"></i><b>상품태그</b></td>
                                                    <td id="tag_td">
                                                        @foreach($tags as $tag)
                                                            #{{ $tag->name }}&nbsp;
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>상품문의 (<span id="que_num">{{ $total_question_num }}</span>)</h6>
                                    <hr>
                                    <br>
                                    <div class="que_area">
                                        <div class="row" class="margin-b">
                                            <div class="col-11">
                                                <textarea name="question" id="question" placeholder="상품문의를 입력하세요" rows="3"></textarea>
                                            </div>
                                            <div class="col-1 que_btn_area">
                                                <div id="num_count">(<span id="question_num">0</span>/200)</div>
                                                <button type="button" id="question_btn" onclick="create_question({{ $good->id }})">저장</button>
                                            </div>
                                        </div>
                                        <br>
                                        @if (isset($questions))
                                            @foreach ($questions as $question)
                                            <div class="que_block">
                                                <div class="row que" id="question_{{ $question->id }}">
                                                    <div class="col-1">
                                                        <div class="img_box">
                                                            {{-- 임시 --}}
                                                            <img src="{{ asset('template/ogani-master/pic.png'); }}" alt="img"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-10 com_a">
                                                        <div class="margin-b">{{ $question->user_name }}<span class="c_time">{{ $question->writeday }}</span></div>
                                                        <div><pre>{{ $question->content }}</pre></div>
                                                        <div class="com_btn">
                                                            <span class="com_btn_span" onclick="create_comment({{ $question->id }})"><i class="fa fa-comment-o" aria-hidden="true"></i>댓글달기</span>
                                                            @if ($question->user_id == auth()->id())
                                                                <span class="com_btn_span" onclick="delete_question({{ $question->id }})"><i class="fa fa-trash-o" aria-hidden="true"></i>삭제하기</span>   
                                                            @endif
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                                @if (isset($question_comments))
                                                    @foreach ($question_comments as $question_commentv)
                                                    @foreach ($question_commentv as $question_comment)
                                                        @if ($question_comment->question_id == $question->id)
                                                            <div class="row q_comment_{{ $question_comment->id }}" id="q_comment">
                                                                <div class="col-1" id="comment_arrow">
                                                                    <div id="arrow-right"></div>
                                                                </div>
                                                                <div class="col-1">
                                                                    <div class="img_box">
                                                                        {{-- 임시 --}}
                                                                        <img src="{{ asset('template/ogani-master/pic.png'); }}" alt="img"/> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-9 com_a">
                                                                    <div class="margin-b">{{ $question_comment->user_name }}<span class="c_time">{{ $question_comment->writeday }}</span></div>
                                                                    <div><pre>{{ $question_comment->content }}</pre></div>
                                                                    <div class="com_btn">
                                                                        @if ($question_comment->user_id == auth()->id())
                                                                            <span class="com_btn_span" onclick="delete_question_comment({{ $question_comment->id }})"><i class="fa fa-trash-o" aria-hidden="true"></i>삭제하기</span>   
                                                                        @endif
                                                                    </div>
                                                                    <hr>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    @endforeach
                                                @endif
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>상점 정보</h6>
                                    <hr><br>
                                    <div class="row">
                                        <div class="col-4" id="store_info_u">
                                            <div class="user_img_box">
                                                {{-- 임시 --}}
                                                <img src="{{ asset('template/ogani-master/pic.png'); }}" alt="img"/>
                                            </div>
                                            <div id="store_f">
                                                <p>{{ $good->store_name }}</p>
                                                <p>상품 {{ $good->goods_num }}<span id="v_bar">|</span>팔로워수 <span id="follow_num">{{ $good->follower }}</span></p>
                                            </div>
                                            <div>
                                                {{-- 현재 로그인한 사용자가 본인 글에 들어왔을 경우 --}}
                                                
                                                @if (auth()->id() != $good->user_id)
                                                    <button type="button" onclick="click_follow_btn({{ $good->user_id }}, {{ auth()->check() }})" id="follow_btn" class="{{ $isFollow == 0 ? 'follow_btn_t' : 'follow_btn_f' }}">
                                                        <i id="follow_icon" class="fa {{ $isFollow == 0 ? 'fa-check' :'fa-user-plus' }}" aria-hidden="true"></i> <span id="follow_val">{{ $isFollow == 0 ? '팔로잉' : '팔로우' }}</span>
                                                    </button>
                                                @else
                                                    <button type="button" id="my_store_btn">내 상점 관리</button>
                                                @endif
                                                <input type="hidden" id="isFollow" value="{{ $isFollow }}" />
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div id="u_goods">
                                                <p>상품<span id="f_r"><a class="more_a" href="#">더보기 ></a></span></p>
                                                <hr>
                                                @if (isset($user_goods))
                                                    @foreach ($user_goods as $user_good)
                                                        <a class="user_goods_a" href="/goods/{{ $user_good->id }}">
                                                            <div id="u_goods_a">
                                                                <div id="u_goods_img_box">   
                                                                    {{-- 임시 --}}
                                                                    <img src="{{ asset('storage/images/goods/'.$user_good->goods_image) }}" alt="상품이미지" id="u_goods_img"/>                
                                                                </div>
                                                                <div id="u_goods_t_won">
                                                                    <div id="u_goods_title">{{ $user_good->title }}</div>
                                                                    <h4>{{ number_format($user_good->price) }} 원</h4>
                                                                </div>                                      
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                @else 
                                                    <p id="p_none">없음</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div id="rev_area">
                                                <p>상점 후기<span id="f_r"><a class="more_a" href="#">더보기 ></a></span></p>
                                                <hr>
                                                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                                                <script src="{{ asset('ksy/js/site.js'); }}"></script>
                                                @if (isset($user_reviews))
                                                    @foreach ($user_reviews as $review)
                                                        <a class="user_goods_a" href="#">
                                                            <div class="row" id="rev_r">
                                                                <div class="col-2">
                                                                    <div class="review_img_box">
                                                                        {{-- 임시 --}}
                                                                        <img src="{{ asset('template/ogani-master/pic.png'); }}" alt="img"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-10">
                                                                    <div>
                                                                        <div id="rev_store_name">
                                                                            {{ $review->store_name }}
                                                                        </div>
                                                                        <div class="c_time">{{ $review->writeday }}</div>
                                                                    </div>
                                                                    <br>
                                                                    <div id="rev_star">
                                                                        <div id="review_star_{{ $review->id }}">
                                                                            <script>
                                                                                list_set_star({{ $review->star }}, 'review_star_{{ $review->id }}');
                                                                            </script>
                                                                        </div>
                                                                    </div>
                                                                    <div class="u_review_con">
                                                                        {{ $review->content }}
                                                                    </div>  
                                                                </div>    
                                                            </div> 
                                                            <hr id="hr_mar">                           
                                                        </a>
                                                    @endforeach
                                                @else 
                                                    <p id="p_none">없음</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2 id="rel_goods_b_title">연관상품</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($related_goods as $index=>$related_good)
                    <div class="col-lg-3 col-md-4 col-sm-6" onclick="location.href='/goods/{{ $related_good->id }}'">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ asset('storage/images/goods/'.$related_good->goods_image) }}">
                                <ul class="product__item__pic__hover">
                                    <li class="heart_pop">
                                        <a id="a" class="{{ $rel_isHearts[$index] == 0 ? 'rel_heart_t' : ''}}"><i id="icon" class="fa fa-heart"></i></a>
                                        <input type="hidden" name="{{ $related_good->id }}" value="{{ $rel_isHearts[$index]}}" />
                                    </li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6 id="today_goods_title"><a href="#">{{ $related_good->title }}</a></h6>
                                <h5>{{ number_format($related_good->price) }} 원</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->

    <!-- 상품 원본 이미지 보기 모달창 -->
    <div id="goodsModal" class="modal">
        <div id="origin_img_caption">{{ $good->title }}</div>
        <span class="close_modal">&times;</span>
        <img class="modal-content" id="original_img">
    </div>

<!-- iamport.payment.js -->
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script>
    var image_src = "{{ asset('template/ogani-master/pic.png') }}";
    var goods_id = '{{ $good->id }}';

    // 결제 시스템 변수
    var name = "{{ $good->title }}";
    var buyer_name = "";
    var buyer_tel = "";

    $('.heart_pop').click (function (e) {
        e.stopPropagation();

        let isLogin = '{{ auth()->check() }}';

        if (isLogin == '') {
            alert("로그인 후 사용할 수 있습니다.");
            return;
        }

        heart_pop_func(this);
    });

    $('#call_btn').click(function (e) {

        // 로그인 안돼있으면 alert 보내고 return하기
        let currentUser = '{{ auth()->id() }}';
        if (currentUser == ''){
            alert("로그인 후 이용 가능한 서비스입니다.");
            return;
        }

        let windowWidth = 500;
        let windowHeight = 700;

        var aa = (document.body.scrollTop + (window.innerHeight/2)) ;
        var x = (window.innerWidth - windowWidth) / 2 ;
        var y = (aa - (windowHeight / 2));
        let win = window.open('/chatting/' + {{ $good->user_id }}, '',"width=" + windowWidth + ",height=" + windowHeight);
        win.moveTo(x, y);
    });



    
    // 결제 시스템 ---------------------
    var IMP = window.IMP; 
    IMP.init("imp40019257"); 
    function requestPay(isLogin) {
        
        if (!isLogin) {
            alert("로그인 후 이용할 수 있습니다.");
            return;
        }

        // 값 세팅
        getCurrentUserInfo();
        let temp = getMerchantUid_setPrice();
        let merchant_uid = temp.merchant_uid;
        let pay_auth_id = temp.pay_auth_id;
        let amount = temp.price;
        

        IMP.request_pay({ // param
            pg: "kakao",
            pay_method: "kakaopay",
            merchant_uid: merchant_uid, //주문번호
            name: name,  //결제창에서 보여질 이름
            amount: amount,  //가격 
            buyer_name: buyer_name,// 구매자 이름
            buyer_tel: buyer_tel, // 구매자 전화번호
        }, function (rsp) { 
            if (rsp.success) { // 결제 성공

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "/pay/complete",
                    method: "POST",
                    dataType : "JSON",
                    data: {
                        imp_uid: rsp.imp_uid,
                        merchant_uid: rsp.merchant_uid,
                        pay_auth_id : pay_auth_id,
                        goods_id : goods_id,
                    },
                    success: function(data) {
                        if(data.result.code!=200){
                            //결제실패(웹서버측 실패)   
                            // 환불 코드 
                            alert("위조된 결제 시도에 의해 결제에 실패했습니다.");  
                            removePayAuth(pay_auth_id);// pay_auth 값 지우기
                            //console.log(data.result.message);
                        }else{
                            //결제성공(웹서버측 성공)
                            alert("결제에 성공했습니다.");
                            bye_modal(document.getElementById("pay_modal"));
                        }
                    },
                    error: function(data) {
                        console.log("error" +data);
                    }
                });
            } else {
                removePayAuth(pay_auth_id);// pay_auth 값 지우기
                alert("결제에 실패했습니다. : " +  rsp.error_msg);
                //console.log(rsp);
            }
        });
    }
    // 결제 시스템 끝 -----------------------
</script>
@endsection