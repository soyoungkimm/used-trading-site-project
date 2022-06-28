@extends('layouts.siteLayout')

@section('content')
<style>
    #buyc_title {
    color :rgb(90, 90, 90);
    font-size : 18pt;
}

#buyc_area {
    background : #fff;
    padding : 40px;
    display: inline-block;
    width : 450px;

    /* 화면 중앙에 오게 정렬 */
    position: fixed;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}

#buyc_title {
    color :rgb(90, 90, 90);
    font-size : 18pt;
}

.close_buyc_modal {
    position: absolute;
    top: 0px;
    right: 20px;
    color: #484848;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close_buyc_modal:hover,
.close_buyc_modal:focus {
    color: rgb(112, 112, 112);
    text-decoration: none;
    cursor: pointer;
}

.modal {
    display: none; /* 화면에서 숨김 */
    position: fixed; 
    z-index: 2; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; /* 화면에 modal이 꽉차게 */
    height: 100%; /* 화면에 modal이 꽉차게 */
    overflow: auto; /* 사진이 크면 scroll되게 */
    background-color: rgba(0,0,0,0.9); /* 뒷배경 색 */
}

#no_btn {
    background-color : #FF9900;
    border : none;
    border-radius: 8px;
    width : 80px;
    height: 35px;
}

#yes_btn {
    background-color : #fff;
    border : solid 2px #FF9900;
    border-radius: 8px;
    width : 80px;
    height: 35px;
}

#no_btn:hover {
    background-color : #e28800;
}

#yes_btn:hover {
    background-color : #e28800;
    border : solid 2px #e28800;
}

#pp_title:hover{
    color : rgb(138, 175, 255);
    cursor: pointer;
}
</style>
    <div id="buyc_modal" class="modal">
        <div id="buyc_area">
            <br>
            <div style=" text-align : center;">
                <b style="font-size : 15pt;">구매확정 하시겠습니까?</b><br><br>
                구매확정을 하면 판매자에게 결제 금액이 송금됩니다.
                금액이 송금된 후에는 환불받기 어렵습니다.<br>
                그래도 구매확정 하시겠습니까?<br><br><br>
                <div style="text-align : center">
                    <button id="yes_btn">예</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button id="no_btn">아니오</button>
                    
                </div>
            </div>
            <br>
            <span class="close_buyc_modal">&times;</span>
        </div>
    </div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <main class="m-auto">
                        <h3 class="font-weight-bold pb-4">결제 내역</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">결제번호</th>
                                    <th scope="col">상품</th>
                                    <th scope="col">가격</th>
                                    <th scope="col">구매확정 여부</th>
                                    <th scope="col">결제날짜</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>
                                        <a href="/users/pay-history/{{ $payment->merchant_uid }}" id="pp_title">
                                            <span>{{ $payment->merchant_uid }}</span>
                                        </a>
                                    </td>
                                    <td>{{ $payment->goods_title }}</td>
                                    <td>{{ number_format($payment->amount) }} &#8361;</td>
                                    <td>
                                        @if ($payment->buy_confirm == 0) {{-- 구매확정 안함 --}} 
                                            <button type="button" class="btn btn-danger" onclick="click_buyc('{{ $payment->merchant_uid }}')">구매확정</button>
                                        @else {{-- 구매확정 함 --}}
                                            <button type="button" class="btn btn-danger" disabled>구매확정</button>
                                        @endif
                                    </td>
                                    <td>{{ $payment->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form id="updateBuyc" action="/users/pay-history/update" method="POST">
                            @csrf
                            <input type="hidden" id="current_mer" name="current_mer" value="" />
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('ksy/js/site.js'); }}"></script>
    <script>
        function click_buyc(value) {
            $("#current_mer").val(value);

            // modal 과련 노드들 가져오기
            let modal = document.getElementById("buyc_modal");
            let adress_area = document.getElementById("buyc_area");
        
            modal.style.display = "block";
            let span = document.getElementsByClassName("close_buyc_modal")[0];
        
            span.onclick = function() { 
                bye_modal(modal); // 재사용함
            }
        }

        $("#yes_btn").click(function () {
            $("#updateBuyc").submit();
        });

        $("#no_btn").click(function () {
            bye_modal(document.getElementById("buyc_modal"));
        });
    </script>
@endsection
