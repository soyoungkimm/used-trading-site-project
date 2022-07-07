<style>
.link {
    color : #007bff !important;
    cursor: pointer !important;
}
</style>
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
                    X
                @else {{-- 구매확정 함 --}}
                    O
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

