@extends('layouts.siteLayout')

@section('content')
<style>
#cal_title:hover {
    color : rgb(138, 175, 255);
    cursor: pointer;
}
</style>
    <div id="buyc_modal" class="modal">
        <div id="buyc_area">
            <br>
            <div style=" text-align : center;">
                <b style="font-size : 15pt;">구매를 확정하시겠습니까?</b><br><br>
                구매를 확정하면 판매자에게 결제 금액이 송금됩니다.
                금액이 송금된 후에는 환불받기 어렵습니다.<br>
                그래도 구매를 확정하시겠습니까?<br><br><br>
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
                        <h3 class="font-weight-bold pb-4">정산</h3>
                        <table class="table" style="text-align : center">
                            <thead>
                                <tr>
                                    <th scope="col">결제번호</th>
                                    <th scope="col">상품</th>
                                    <th scope="col">가격</th>
                                    <th scope="col">결제날짜</th>
                                    <th scope="col">구매확정 여부</th>
                                    <th scope="col">정산 여부</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>
                                        <a href="/users/calculate/{{ $payment->merchant_uid }}" id="cal_title">
                                            <span>{{ $payment->merchant_uid }}</span>
                                        </a>
                                    </td>
                                    <td>{{ $payment->goods_title }}</td>
                                    <td>{{ number_format($payment->amount) }} &#8361;</td>
                                    <td>{{ $payment->created_at }}</td>
                                    <td>
                                        @if ($payment->buy_confirm == 0) {{-- 구매확정 안함 --}} 
                                            X
                                        @else {{-- 구매확정 함 --}}
                                            O
                                        @endif
                                    </td>
                                    <td>
                                        @if ($payment->calcul_state == 0) {{-- 구매확정 안함 --}} 
                                            X
                                        @else {{-- 구매확정 함 --}}
                                            O
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
