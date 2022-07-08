@extends('layouts.siteLayout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    //프로필 뒷 배경 설정
    $(function() {
        $(document).ready(function() {
            var src = $('#profile').attr("src");
            $("#bHTJYK").css({"background-image":"url("+src+")"});
        });
    });

    //상점명 수정-폼 생성
    $(document).on('click','#editStoreName',function(){
        $('#nameArea').empty();
        var html = "<div class='input-group editStore'><input id='inputStoreName' value='{{ $user->store_name }}'><div class='input-group-append'><button class='btn' id='btn1'>수정</button></div>";
        $('#nameArea').html(html);
    });

    //상점명 수정- DB업데이트 및 화면수정
    $(document).on('click','#btn1',function(){
        var name= document.getElementById('inputStoreName').value;
        //var intro = document.getElementById('inputIntoruduction').value;
        var id = {{ session()->get('id') }};
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/shop/update_StoreName/',
            type: "PUT",
            dataType: 'text',
            data: {
                id : id,
                store_name : name
            },
            success : function(data) {

                let html ='<div class="sc-BngTV hgrllz">' + data +'<button class="sc-eIHaNI jHdWCJ" id="editStoreName">상점명 수정</button></div>';
                $('#nameArea').empty();
                $('#nameArea').html(html);
                $('#nameArea2').empty();
                $('#nameArea2').html(data);
            },
            error: function(request,status,error){ 
                alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
                console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
            }
        });
    });

    //소개글 수정-폼 생성
    $(document).on('click','#editIntro',function(){
        $('#IntroArea').empty();
        var html = "<div class='input-group editStore'style='height:100%'><textarea id='inputIntro' style='width:90%;'>{{ $user->introduction }}</textarea><div class='input-group-append'><button class='btn' id='btn2'>수정</button></div>";
        $('#IntroArea').html(html);
        $("#editIntro").attr("disabled", true);
    });

    //소개글 수정- DB업데이트 및 화면수정
    $(document).on('click','#btn2',function(){
        var intro= document.getElementById('inputIntro').value;
        var id = {{ session()->get('id') }};
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/shop/update_StoreIntro/',
            type: "PUT",
            dataType: 'text',
            data: {
                id : id,
                intro : intro
            },
            success : function(data) {

                $('#IntroArea').empty();
                $('#IntroArea').html(data);
            },
            error: function(request,status,error){ 
                alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
                console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
            }
        });
    });

    //찜 선택삭제
    $(document).on('click','.Delete-hearts',function(){
        let id = {{ session()->get('id') }};
        let block_arr = Array.from(document.querySelectorAll('.heart-block'));
        var id_arr = [];

        //선택된 block만 id 저장
        block_arr.forEach(function(block,i){
            if(block.querySelector('.checked') != null)
                id_arr.push(block.getAttribute('data-id'));
        });
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/shop/ajax_heart',
            type: "POST",
            dataType: 'text',
            data: {
                id : id,
                num : -1,
                id_arr : id_arr
            },
            success : function(data) {

                $('#area-heart').empty();
                $('#area-heart').html(data);
            },
            error: function(request,status,error){ 
                alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
                console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
            }
        });
    });

    //찜상품 정렬
    $(document).on('click','.heart-orders>.heart-order',function(){
        let id = {{ session()->get('id') }};
        const num = $(".heart-orders .heart-order").index($(this));

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/shop/ajax_heart',
            type: "POST",
            dataType: 'text',
            data: {
                id : id,
                num : num,
                id_arr : 0
            },
            success : function(data) {

                $('#area-heart').empty();
                $('#area-heart').html(data);
                $('heart-num').empty();
                $('heart-num').html(data.length);
                
            },
            error: function(request,status,error){ 
                alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
                console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
            }
        });
    });

    //상품 정렬
    $(document).on('click','.goods-orders>.goods-order',function(){
        let id = {{ $id }};
        const num = $(".goods-orders .goods-order").index($(this));

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/shop/ajax_good',
            type: "POST",
            dataType: 'text',
            data: {
                id : id,
                num : num
            },
            success : function(data) {

                $('#area-goods').empty();
                $('#area-goods').html(data);
                // $('good-num').empty();
                // $('good-num').html(data.length);
                
            },
            error: function(request,status,error){ 
                alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
                console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
            }
        });
    });


    function list_set_star(star, tag_id) {

        let arr = set_star(star);
        let str =  '<i class="' + arr['star1'] + '" id="star1"></i>\n' + 
                '<i class="' + arr['star2'] + '" id="star2"></i>\n' +
                '<i class="' + arr['star3'] + '" id="star3"></i>\n' +
                '<i class="' + arr['star4'] + '" id="star4"></i>\n' +
                '<i class="' + arr['star5'] + '" id="star5"></i>\n';

        $('#' + tag_id).html(str);
    }

    
    function set_star(val1) {
        let val = Math.floor(val1);

        let arr = new Array();
        let empty_star = 'fa fa-star-o fa-lg';
        let half_star = 'fa fa-star-half-o fa-lg';
        let full_star = 'fa fa-star fa-lg';
        if (val == 0 || val == null) {
            arr['star1'] = empty_star;
            arr['star2'] = empty_star;
            arr['star3'] = empty_star;
            arr['star4'] = empty_star;
            arr['star5'] = empty_star;
        } 
        else if (val == 1) {
            arr['star1'] = half_star;
            arr['star2'] = empty_star;
            arr['star3'] = empty_star;
            arr['star4'] = empty_star;
            arr['star5'] = empty_star;
        } 
        else if (val == 2) {
            arr['star1'] = full_star;
            arr['star2'] = empty_star;
            arr['star3'] = empty_star;
            arr['star4'] = empty_star;
            arr['star5'] = empty_star;
        } 
        else if (val == 3) {
            arr['star1'] = full_star;
            arr['star2'] = half_star;
            arr['star3'] = empty_star;
            arr['star4'] = empty_star;
            arr['star5'] = empty_star;
        } 
        else if (val == 4) {
            arr['star1'] = full_star;
            arr['star2'] = full_star;
            arr['star3'] = empty_star;
            arr['star4'] = empty_star;
            arr['star5'] = empty_star;
        } 
        else if (val == 5) {
            arr['star1'] = full_star;
            arr['star2'] = full_star;
            arr['star3'] = half_star;
            arr['star4'] = empty_star;
            arr['star5'] = empty_star;
        } 
        else if (val == 6) {
            arr['star1'] = full_star;
            arr['star2'] = full_star;
            arr['star3'] = full_star;
            arr['star4'] = empty_star;
            arr['star5'] = empty_star;
        } 
        else if (val == 7) {
            arr['star1'] = full_star;
            arr['star2'] = full_star;
            arr['star3'] = full_star;
            arr['star4'] = half_star;
            arr['star5'] = empty_star;
        } 
        else if (val == 8) {
            arr['star1'] = full_star;
            arr['star2'] = full_star;
            arr['star3'] = full_star;
            arr['star4'] = full_star;
            arr['star5'] = empty_star;
        } 
        else if (val == 9) {
            arr['star1'] = full_star;
            arr['star2'] = full_star;
            arr['star3'] = full_star;
            arr['star4'] = full_star;
            arr['star5'] = half_star;
        }
        else if (val == 10) {
            arr['star1'] = full_star;
            arr['star2'] = full_star;
            arr['star3'] = full_star;
            arr['star4'] = full_star;
            arr['star5'] = full_star;
        }

        return arr;
    }

    $(document).on('click','#call_btn',function (e) {
        
        //로그인 안돼있으면 alert 보내고 return하기
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
        let win = window.open('/chatting/' + {{ $id }}, '',"width=" + windowWidth + ",height=" + windowHeight);
        win.moveTo(x, y);
    });

</script>
<style>
    .header__top__right__social a:hover{
        font-size: 11pt;
        cursor: pointer;
        color: rgb(29, 29, 29);
    }
</style>

<secssion class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4 style="text-align:center;">Shop</h4>
            <div class="sc-kIWQTW vYdwB">

                <div class="sc-jOBXIr iFwjPv">
                    <div class="sc-fyjhYU jIbgyD">
                        <div class="sc-ugnQR WjsBc">
                            <div class="sc-gpHHfC fnqfNl">
                                <div size="310" class="sc-gVyKpa gfUMTh">
                                    <div class="sc-gPzReC hbVKzb">
                                        <div class="sc-jrIrqw bHTJYK" id="bHTJYK">
                                        </div>
                                    </div>
                                    <div class="sc-eXNvrr eqKfAa">
                                        @if( empty($user->image) )
                                            <img src="{{ asset('storage/images/users/noProfile.png') }}" width="100" height="100" id="profile" class="sc-cpmKsF kokTJU">
                                        @else
                                            <img src="{{ asset('storage/images/users/'.$user->image) }}" width="100" height="100" id="profile" class="sc-cpmKsF kokTJU">
                                        @endif
                                        <div class="sc-kQsIoO YgUrz" id="nameArea2">{{ $user->store_name }}</div>
                                        <div class="sc-hIVACf eHVdaG" id="stars">
                                            <script>
                                                list_set_star({{ $stars }}, 'stars');
                                            </script>
                                        </div>
                                        <div class="sc-hjRWVT fPlNlP">
                                            @if($id == session()->get('id'))
                                                <a class="sc-exkUMo jxncag" href="/shop/manage">내 상점 관리</a>
                                            @elseif( in_array(session()->get('id'),$arr_fwr))
                                                <button class="user-fo following" data-storeid="{{$id}}" style="width:100px; color:white">
                                                    <i class="fa-solid fa-check">팔로잉</i>
                                                </button>
                                                <button type="button" id="call_btn" onclick="clickChatting({{ auth()->id() }})"><i class="fa-solid fa-comment-dots mr-1"></i>채팅</button>
                                            @else
                                                <button class="user-fo follow" data-storeid="{{$id}}" style="width:100px; color:white">
                                                    <i class="fa-solid fa-user-plus">팔로우</i>
                                                </button>
                                                <button type="button" id="call_btn" onclick="clickChatting({{ auth()->id() }})"><i class="fa-solid fa-comment-dots mr-1"></i>채팅</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="sc-jwKygS gSsteC">
                                </div>
                            </div>
                        </div>
                        <div class="sc-eTpRJs jYfwLF" >
                            <div class="sc-dxZgTM kaLeab" id="nameArea">
                                <div class="sc-BngTV hgrllz">{{ $user->store_name }}
                                    @if($id == session()->get('id'))
                                    <button class="sc-eIHaNI jHdWCJ" id="editStoreName">상점명 수정</button>
                                    @endif
                                </div>
                            </div>
                            <div class="sc-iomxrj hLGebF">
                                <div class="sc-dvCyap bPBpdJ"><i class="fa-solid fa-store"></i>상점오픈일<div class="sc-iFMziU kMdfYQ">{{ $open_day }}일 전</div>
                                </div>
                                <div class="sc-dvCyap bPBpdJ"><i class="fa-solid fa-person"></i>상점방문수<div class="sc-iFMziU kMdfYQ">{{ $user->store_visit }} 명</div>
                                </div>
                                <div class="sc-dvCyap bPBpdJ"><i class="fa-solid fa-basket-shopping"></i>상품판매<div class="sc-iFMziU kMdfYQ">{{ $user->sale_num }} 회</div>
                                </div>
                                <div class="sc-dvCyap bPBpdJ"><i class="fa-solid fa-box"></i>택배발송<div class="sc-iFMziU kMdfYQ">{{ $user->delivery_num}} 회</div>
                                </div>
                            </div>
                            <div class="sc-keVrkP QdtSU" id="IntroArea">{{ $user->introduction }}</div>
                            @if($id == session()->get('id'))
                            <div class="sc-cBdUnI hThOPJ">
                                <button class="sc-eIHaNI jHdWCJ" id="editIntro">소개글 수정</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 메뉴 시작 -->
                <div class="sc-gCwZxT hbbGSy">
                    <div class="sc-fUdGnz caKLIw">
                        <div class="tab-group bJTIh">
                            <a class="tab TabTrue" id="tabs-1">상품 <span class="good-num kjUuFF">{{ count($goods) }}</span></a>
                            <a class="tab TabFalse" id="tabs-2">찜 <span class="heart-num kjUuFF">{{ count($hearts) }}</span></a>
                            <a class="tab TabFalse" id="tabs-3">상점후기 <span class="review-num kjUuFF" id="l">{{ count($reviews) }}</span></a>
                            <a class="tab TabFalse" id="tabs-4">팔로잉 <span class="follow-num kjUuFF" id="follow-num">{{ count($follows) }}</span></a>
                            <a class="tab TabFalse" id="tabs-5">팔로워 <span class="follower-num kjUuFF">{{ count($followers) }}</span></a>
                        </div>
                    </div>
                    <div class="content sc-giOsra dnwkyQ">
                        <div class="tab-content Block" id="area-goods" > 
                            @include('sites.shop.goodsResult')
                        </div>
                        <div class="tab-content None" id="area-heart">
                            @include('sites.shop.heartsResult')
                        </div>
                        <div class="tab-content None">
                            <div class="sc-iYUSvU ikgsKY">
                                <div>상점후기 <span class="sc-glUWqk dLMFot">{{ count($reviews) }}</span></div>
                            </div>
                            @if( count($reviews)==0 )
                            <div class="sc-fFTYTi lbZBQ">상점후기가 없습니다.</div>
                            @else
                            <div class="sc-bYTsla fLFyAJ">
                                @foreach($reviews as $review)
                                <div class="sc-dwztqd bDCRQQ">
                                    <a class="sc-fgrSAo AXChy" href="/shop/main/{{$review->user_id}}">
                                        @if( empty($review->image))
                                            <img src="{{ asset('storage/images/users/noProfile.png') }}" width="60" height="60" alt="리뷰어 이미지">
                                        @else
                                            <img src="{{ asset('storage/images/users/'.$review->image) }}" width="60" height="60" alt="리뷰어 이미지">
                                        @endif
                                    </a>
                                    <div class="sc-bOCYYb gFodBE">
                                        <div class="sc-iFUGim hoITQQ">
                                            <div class="sc-cNQqM eokRlZ"><a class="sc-eqPNPO bQTojy" href="/shop/main/{{$review->user_id}}">{{$review->name}}</a>
                                                <div class="sc-ileJJU jZmVej">{{$review->writeday}}</div>
                                            </div>
                                            <a class="sc-hAnkBK grDwfy" href="/shop/main/{{$review->user_id}}">
                                                <div class="sc-hIVACf eHVdaG" id="star-{{$review->name}}">
                                                    <script>
                                                        list_set_star({{ $review->star }}, 'star-{{$review->name}}');
                                                    </script>
                                                </div>
                                            </a>
                                        </div><a class="sc-jotlie ccIUoD" href="/goods/{{$review->goods_id}}"><button class="sc-bYnzgO nwMWR">{{$review->title}}<i class="fa-solid fa-chevron-right"></i></button></a>
                                        <div class="sc-fdQOMr hsWyMo">{{$review->content}}</div>
                                        <div class="sc-cNnxps amrNP">

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                            </div>
                            @endif
                        </div>
                        <div class="tab-content None">
                            <div class="area-following ejYOno">
                                <div class="sc-iYUSvU ikgsKY">
                                    <div>팔로잉<span class="follow-num hhxeJe">{{ count($follows) }}</span></div>
                                </div>
                                @if( count($follows) == 0 )
                                <div class="sc-dAOnuy ddPTol">아직 팔로우한 사람이 없습니다.</div>
                                @else
                                    <div class="sc-bQmweE ecwGGF">
                                        <div class="sc-iEPtyo bnvnpY">
                                            @foreach($follows as $follow)
                                            <div class="sc-gUlUPW fisZng">
                                                <div class="sc-dHaUqb hGHIcc">
                                                    <a class="sc-LAuEU iitCmj" href="/shop/main/{{$follow->id}}">
                                                        @if( empty($follow->image))
                                                            <img src="{{ asset('storage/images/users/noProfile.png') }}" width="120" height="120" alt="프로필 이미지"></a><a class="sc-fcTNbh dLTnOt" href="/shop/main/{{$follow->id}}">{{$follow->store_name}}
                                                        @else
                                                            <img src="{{ asset('storage/images/users/'.$follow->image) }}" width="120" height="120" alt="프로필 이미지"></a><a class="sc-fcTNbh dLTnOt" href="/shop/main/{{$follow->id}}">{{$follow->store_name}}
                                                        @endif
                                                    </a>
                                                    <div class="sc-ghUbLI ddTIuq">
                                                        <a class="sc-hrBRpH ekUNbH" href="/shop/main/{{$follow->id}}">상품<b>{{$follow->good_num}}</b></a>
                                                        <a class="sc-ljUfdc bzESTy" href="/shop/main/{{$follow->id}}">팔로워<b>{{$follow->follower}}</b></a>
                                                    </div>
                                                    @if($id == session()->get('id'))
                                                    <div class="fo-box eekpGe">
                                                        <button class="fo-check following" data-storeid="{{$follow->store_id}}">
                                                            <i class="fa-solid fa-check">팔로잉</i>
                                                        </button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-content None">
                            <div class="sc-dBfaGr hECoBb">
                                <div class="sc-iYUSvU ikgsKY">
                                    <div>팔로워<span class="sc-jgVwMx tFsce">{{ count($followers) }}</span></div>
                                </div>
                                @if( count($followers) == 0)
                                <div class="sc-ijnzTp kUDvRT">아직 이 상점을 팔로우한 사람이 없습니다.</div>
                                @else
                                    <div class="area-follower ecwGGF">
                                        <div class="sc-iEPtyo bnvnpY">
                                            @foreach($followers as $follower)
                                            <div class="sc-gUlUPW fisZng">
                                                <div class="sc-dHaUqb hGHIcc">
                                                    <a class="sc-LAuEU iitCmj" href="/shop/main/{{$follower->user_id}}">
                                                        @if( empty($follower->image) )
                                                            <img src="{{ asset('storage/images/users/noProfile.png') }}" width="120" height="120" alt="프로필 이미지"></a><a class="sc-fcTNbh dLTnOt" href="/shop/main/{{$follower->user_id}}">{{$follower->store_name}}
                                                        @else
                                                            <img src="{{ asset('storage/images/users/'.$follower->image) }}" width="120" height="120" alt="프로필 이미지"></a><a class="sc-fcTNbh dLTnOt" href="/shop/main/{{$follower->user_id}}">{{$follower->store_name}}
                                                        @endif
                                                    </a>
                                                    <div class="sc-ghUbLI ddTIuq">
                                                        <a class="sc-hrBRpH ekUNbH" href="/shop/main/{{$follower->user_id}}">상품<b>{{$follower->good_num}}</b></a>
                                                        <a class="sc-ljUfdc bzESTy" href="/shop/main/{{$follower->user_id}}">팔로워<b>{{$follower->follower}}</b></a>
                                                    </div>
                                                    @if($id == session()->get('id'))
                                                    <div class="fwr-box eekpGe">
                                                        @if( $isfollow[$loop->index] == 1)
                                                        <button class="fwr-check following" data-storeid="{{$follower->user_id}}">
                                                            <i class="fa-solid fa-check">팔로잉</i>
                                                        </button>
                                                        @else
                                                        <button class="fwr-check follow" data-storeid="{{$follower->user_id}}">
                                                            <i class="fa-solid fa-user-plus">팔로우</i>
                                                        </button>
                                                        @endif
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sc-jwKygS gSsteC">
                    <div class="sc-kAdXeD cRwlCh">
                        <div class="sc-hCaUpS cpcDvE">
                            <div class="sc-bvTASY bnrEqO">신고하기</div><button class="sc-cFlXAS hJvCHs"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAAXNSR0IArs4c6QAAAiBJREFUaAXtmM1xwjAQRrFvcE+aSJoIPaSI5MCNHmC4caCK1ECaCE0kBTBccPxl0MyO0C6r1drkIF/Q6Gf3vbU9kplM6lUrUCtQK/BvK7Bard622+3DvQCRGwxS/pYbvCzcHY/H/T0kkBO5e76dJMEKzGazj6Zpvrquex5bIsAjNxjAwhW64QbQHweaTqfzxWLxI60pHcvNKQqMLZELD76bAmNJWODVAkNLWOGzBIaSKIHPFvCWKIU3CXhJeMCbBUolvOCLBKwSnvDFAgmJQ7/ZvXCb3QX+s99hn7DDemyMqn0AoNIVgSUlNHOkHNyYiwCCS4DSGAem7XcT4CTQ3x8Gw2OTvDta2NQ8VwEkiKuNvssz7w6P2O4CCEol/pI0zSDwiM1+D2DQep1Op6vCpPqs8em6q0R00NLebDaP5/N5Hx4bxAjttm3ny+Xy2xKXW+MqEMMDGImpkLeEm0AKPlRbGuMqq+13EdAAauZooem8YoEcsJy5FFJqFwlYgCxrBhEoASlZG8uY7oAHgEcMyGQLeCVGco9YWQIeCQFOr9KY6qNEaSIKTdvYK7C59R84B+zY2PRwlqJzpLZKAAGH3E1jCRy/tRI3HyF6skSVvI8CtLrxXZY+T8M6USCG1wQMga2/uTlZgdxAVuDUupzc7DvQP4ev4Rg8RuWpCP7VQM7wYoOFjqvb6/X6HdVQL3CeiHcCDM5ha7hagVqBWgHHCvwCWAH5e5bAf84AAAAASUVORK5CYII=" width="24" height="24" alt="닫기 버튼 아이콘"></button>
                        </div>
                        <div class="sc-koErNt hoSImv">
                            <div class="sc-gJqsIT fFOOZG">
                                <div class="sc-kDhYZr jaHNwd"><span>광고 (상점 및 타사이트 홍보, 상품도배)</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                                <div class="sc-dHIava kMwaJm">
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">상점 및 타사이트 홍보</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">상품 도배</button></div>
                                </div>
                            </div>
                            <div class="sc-gJqsIT fFOOZG">
                                <div class="sc-kDhYZr jaHNwd"><span>상품 정보 부정확 (상품명, 이미지, 가격, 태그 등)</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                                <div class="sc-dHIava kMwaJm">
                                    <div class="sc-guztPN jSLYYi"><textarea placeholder="신고 내용을 직접 작성해주세요.
            자세하게 적어주시면 신고처리에 큰 도움이 됩니다."></textarea><button type="button">등록</button></div>
                                </div>
                            </div>
                            <div class="sc-gJqsIT fFOOZG">
                                <div class="sc-kDhYZr jaHNwd"><span>거래 금지 품목</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                                <div class="sc-dHIava kMwaJm">
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">가품(위조품/이미테이션)</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">개인정보 거래(SNS계정, 인증번호 등)</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">게임계정/아이템/대리육성</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">담배</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">반려동물(분양/입양 글)</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">비매품 판매(화장품 샘플 등)</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">음란물/성인용품(중고속옷 포함)</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">의약품/의료기기</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">조건부 무료나눔</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">주류</button></div>
                                    <div class="sc-bSbAYC klJWzk"><input type="text" placeholder="기타 (사유)" value=""><button type="button">등록</button></div>
                                </div>
                            </div>
                            <div class="sc-gJqsIT fFOOZG">
                                <div class="sc-kDhYZr jaHNwd"><span>안전결제 허위매물(안전결제 표시 상품 안전결제 거부)</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                                <div class="sc-dHIava kMwaJm">
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">안전결제 거부</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">배송전 구매확정 요청</button></div>
                                    <div class="sc-jhaWeW dYHhYh"><button type="button">추가 금액 요청</button></div>
                                </div>
                            </div>
                            <div class="sc-gJqsIT fFOOZG">
                                <div class="sc-kDhYZr jaHNwd"><span>사기의심(외부채널 유도)</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                                <div class="sc-dHIava kMwaJm">
                                    <div class="sc-guztPN jSLYYi"><textarea placeholder="신고 내용을 직접 작성해주세요.
            자세하게 적어주시면 신고처리에 큰 도움이 됩니다."></textarea><button type="button">등록</button></div>
                                </div>
                            </div>
                            <div class="sc-gJqsIT fFOOZG">
                                <div class="sc-kDhYZr jaHNwd"><span>기타(사유)</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                                <div class="sc-dHIava kMwaJm">
                                    <div class="sc-guztPN jSLYYi"><textarea placeholder="신고 내용을 직접 작성해주세요.
            자세하게 적어주시면 신고처리에 큰 도움이 됩니다."></textarea><button type="button">등록</button></div>
                                </div>
                            </div>
                        </div>
                        <div class="sc-jwKygS gSsteC">
                            <div class="sc-btzYZH loGZtw">
                                <h2 class="sc-lhVmIH hWqodb">신고하기</h2>
                                <p class="sc-bYSBpT kYaBSe">신고 내용은 번개장터 이용약관 및 정책에 의해서 처리되며, 허위신고 시 번개장터 이용이 제한될 수 있습니다.</p>
                                <div class="sc-elJkPf cgZVKM"><button type="button" class="sc-jtRfpW caPtxQ">확인</button><button type="button" class="sc-kTUwUJ cFsfis">취소</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</secssion>


<link href="{{ asset('cws/site.css'); }}" rel="stylesheet"/>
<script src="{{ asset('cws/site.js'); }}"></script>
<script src="https://kit.fontawesome.com/8ad9e88a63.js" crossorigin="anonymous"></script>
<script>
    function clickChatting(userId){
        // 로그인 안돼있으면 alert 보내고 return하기
        if (userId == null){
            alert("로그인 후 이용 가능한 서비스입니다.");
            return;
        }

        let windowWidth = 500;
        let windowHeight = 700;

        var aa = (document.body.scrollTop + (window.innerHeight/2)) ;
        var x = (window.innerWidth - windowWidth) / 2 ;
        var y = (aa - (windowHeight / 2));
        let win = window.open('/chatting/' + {{ $user->id }}, '',"width=" + windowWidth + ",height=" + windowHeight);
        win.moveTo(x, y);
    }
</script>
@endsection