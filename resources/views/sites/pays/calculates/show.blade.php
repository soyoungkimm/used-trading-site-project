@extends('layouts.siteLayout')

@section('content')

<style>
#p_back_btn{
    border-radius: 5px; 
    background : #FF9900; 
    border : none;
    font-size : 12pt; 
    padding : 7px;
    color : #fff;
}

#p_back_btn:hover{
    background : #e58a00;
}


</style>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <main class="m-auto">
                        <h3 class="font-weight-bold pb-4">결제 내역 상세&nbsp;&nbsp;
                            <button onclick="javascript:history.back();" id="p_back_btn">뒤로가기</button></h3>
                        <br>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width : 20%">결제번호</th>
                                    <td>{{ $payment->merchant_uid }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">상품</th>
                                    <td>{{ $payment->goods_title }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">금액</th>
                                    <td>{{ number_format($payment->amount) }} &#8361;</td>
                                </tr>
                                <tr>
                                    <th scope="row">보낸사람</th>
                                    <td>{{ $buy_user }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">받은사람</th>
                                    <td>{{ $sale_user }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">결제날짜</th>
                                    <td>{{ $payment->created_at }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">구매확정 여부</th>
                                    <td>
                                        @if ($payment->buy_confirm == 0) O
                                        @else X
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">정산 여부</th>
                                    <td>
                                        @if ($payment->calcul_state == 0) O
                                        @else X
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </main>
                </div>
            </div>
        </div>
    </section>

@endsection
