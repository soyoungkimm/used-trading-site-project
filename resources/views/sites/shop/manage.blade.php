@extends('layouts.siteLayout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    //manage탭바 변경
    $(document).on('click','.tab-group .tab',function(){
        const num1 = $(".tab-group .tab").index($(this));
        const num2 = $(".tab-group .onTab").index();

        $(".tab-group .tab:eq("+num2+")").removeClass("onTab");
        $(".tab-content:eq("+num2+")").removeClass("Block");
        $(".tab-group .tab:eq("+num2+")").addClass("offTab");
        $(".tab-content:eq("+num2+")").addClass("None");

        $(".tab-group .tab:eq("+num1+")").removeClass("offTab");
        $(".tab-content:eq("+num1+")").removeClass("None");
        $(".tab-group .tab:eq("+num1+")").addClass("onTab");
        $(".tab-content:eq("+num1+")").addClass("Block");

    });

    //검색-테이블 다시 그리기
    $(document).on('click','.submit',function(){
        let id = {{ session()->get('id') }};
        let search = $('.search').val()
        let state = $('.searchState>.list>.selected').attr('data-value');
        $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/shop/ajax_manage/',
                type: "POST",
                dataType: 'text',
                data: {
                    id : id,
                    search : search,
                    state : state
                },
                success : function(data) {

                    $('.table-container').empty();
                    $('.table-container').html(data);
                },
                error: function(request,status,error){ 
                    alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
                    console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
                }
            });
    });

    $(document).on('click', '.historyBtn', function(){

        let id = {{ session()->get('id') }};
        let num = $(".historyBtn").index($(this));
        let type = "buy"; 

        let num2 = $(".historyBtns .btn-on").index();
        $(".historyBtn:eq("+num+")").removeClass("btn-off");
        $(".historyBtn:eq("+num+")").addClass("btn-on");

        $(".historyBtn:eq("+num2+")").removeClass("btn-on");
        $(".historyBtn:eq("+num2+")").addClass("btn-off");

        if(num != 0)
            type = "sale"; 
        
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/shop/ajax_payHistory/',
            type: "POST",
            dataType: 'text',
            data: {
                id : id,
                type : type
            },
            success : function(data) {

                $('.history-container').empty();
                $('.history-container').html(data);
            },
            error: function(request,status,error){ 
                alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
                console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
            }
        });
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
        <div class="tab-group">
            <div class="tab p-2 pr-4 my-4 d-inline-block border-right onTab" >상품관리</div>  
            <div class="tab m-4 d-inline-block offTab">거래내역</div>
        </div>
        
        <div class="tab-content Block">
        <h3>상품 관리</h3>
            <div class="row">
                <div class="sc-dznXNo gWvYUm my-3">
                    <input class="search" type="text" placeholder="상품명을 입력해주세요." value="">
                </div>
                <div class="searchState-container">
                    <select class="m-3 searchState">
                        <option value="all">전체</option>
                        <option value="0">판매중</option>
                        <option value="1">판매완료</option>
                        <option value="2">예약 중</option>
                    </select>
                </div>  
                <div class="m-3">
                    <button  class="sc-bqjOQT iOvVQ submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <button type="button" id="modalBtn" style="display:none;" class="btn btn-primary" data-toggle="modal" data-target="#stateSucess">모달</button>

                <div class="table-container">
                    @include('sites.shop.manageResult')
                </div>
                <div id="modal">
                    <div class="modal fade" id="stateSucess" tabindex="-1" role="dialog" aria-labelledby="stateSucessLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content" style="border:none; border-radius:0;">
                                <div class="modal-body my-3 text-center">
                                    상품 상태가 변경되었습니다
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-mainColor w-100" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content None">
        <h3>거래내역</h3> 
        <div class="historyBtns my-3 ">
            <button class="historyBtn buyHistory btn-on">구매내역</button>
            <button class="historyBtn saleHistory btn-off">판매내역</button>
        </div>
            <div class="row history-container">
                @include('sites.shop.payHistorys')
            </div>
        </div>
    </div>
</secssion>


<script src="https://kit.fontawesome.com/8ad9e88a63.js" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="{{ asset('cws/site.css'); }}" rel="stylesheet"/>


@endsection