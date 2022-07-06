<script>
    //판매상태 업데이트
    $(document).ready(function(){
        const selector = document.querySelectorAll('.changeStatus>.list>.option')
    
        selector.forEach(b=>b.addEventListener('click',(e)=>{

            e.preventDefault()

            const val = e.target.dataset.value;
            let id = e.target.parentNode.parentNode.parentNode.getAttribute('data-id');
            
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/shop/update_saleStatus/',
                type: "PUT",
                dataType: 'text',
                data: {
                    id : id,
                    sale_state : val
                },
                success : function(data) {
                    document.getElementById('modalBtn').click();
                },
                error: function(request,status,error){ 
                    alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
                    console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
                }
            });
        })
        );
    });
</script>
<table class="table text-center">
    <thead>
        <tr>
            <th class="col-3">사진</th>
            <th class="col-1">판매상태</th>
            <th class="col-3">상품명</th>
            <th class="col-">가격</th>
            <th class="col-1">찜/댓글</th>
            <th class="col-2">작성일</th>
        </tr>
    </thead>
    <tbody>
        @foreach($goods as $good)
        <tr >
            <td><img src="{{ asset('storage/images/goods/'.$good->image) }}" width="160" height="160" id="pic"></td>
            <td class="align-middle" data-id="{{$good->good_id}}">
                <div class="nice-select changeStatus">
                    <span class="current">
                        @if($good->sale_state==0)판매중
                        @elseif($good->sale_state==1)판매완료
                        @elseif($good->sale_state==3)예약 중@endif
                    </span>
                        <ul class="list">
                            <li data-value="0" class="option @if($good->sale_state==0)selected @endif">판매중</li>
                            <li data-value="1" class="option @if($good->sale_state==1)selected @endif">판매완료</li>
                            <li data-value="2" class="option @if($good->sale_state==2)selected @endif">예약 중</li>
                        </ul>
                </div>
            </td>
            <td class="align-middle">{{$good->title}}</td>
            <td class="align-middle">{{number_format($good->price)}}원</td>
            <td class="align-middle">{{$good->heart}} / {{$good->questions_cnt}}</td>
            <td class="align-middle">{{date('Y-m-d h:m',strtotime($good->writeday))}}</td>
        </tr>
        @endforeach
    </tbody>
</table>