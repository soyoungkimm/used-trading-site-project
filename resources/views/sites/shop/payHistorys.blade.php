<style>
.link {
    color : #007bff !important;
    cursor: pointer !important;
}
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

.con-btn {
    padding: 0px 0.5rem;
    height: 2rem;
    border: 0px;
    border-radius: 20px;
    text-align: center;
    font-size: 13px;
    background-color: #FF9900;
    color:#fff;
    width : 60px;
}

.con-no-btn {
    padding: 0px 0.5rem;
    height: 2rem;
    border: 0px;
    border-radius: 20px;
    text-align: center;
    font-size: 13px;
    background-color: rgb(244, 244, 250);
    color:rgb(155, 153, 169);
    width : 60px;
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
<table class="table text-center mt-3">
    <thead>
        <tr>
            <th class="col-1">사진</th>
            <th class="col-2">상품</th>
            <th class="col-2">가격</th>
            <th class="col-1">구매확정</th>
            <th class="col-1">정산여부</th>
            <th class="col-3">결제일</th>
            <th class="col-3">결제번호</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td><img src="{{ asset('storage/images/goods/'.$payment->pic) }}" width="80" height="80" id="pic"></td>
            <td class="align-middle" ><a href="/goods/{{$payment->good_id}}" class="link">{{$payment->goods_title}}</a></td>
            <td class="align-middle">{{number_format($payment->price)}}원</td>
            <td class="align-middle">
                @if ($payment->buy_confirm == 0) {{-- 구매확정 안함 --}} 
                    <button type="button" class="con-btn" onclick="click_buyc('{{ $payment->merchant_uid }}')">확정</button>
                @else {{-- 구매확정 함 --}}
                    <button type="button" class="con-no-btn" disabled>확정</button>
                @endif
            </td>
            <td class="align-middle">
                @if ($payment->calcul_state == 0) {{-- 정산 안함 --}} 
                    X
                @else {{-- 정산 함 --}}
                    O
                @endif
            </td>
            <td class="align-middle">{{$payment->created_at}}</td>
            <td class="align-middle">
                <a href="/users/calculate/{{ $payment->merchant_uid }}" class="link">{{$payment->merchant_uid}}</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<form id="updateBuyc" action="/shop/ajax_updateBuyConfirm" method="POST">
    @csrf
    <input type="hidden" id="current_mer" name="current_mer" value="" />
</form>

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
