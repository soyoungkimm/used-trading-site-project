<script>
//select가 클릭되었을 때, 상품 필터링
    $(document).ready(function(){
        const selector = document.querySelectorAll('.nice-select>.list>.option')
        const storeItems = document.querySelectorAll('.sell-item')

        selector.forEach(b=>b.addEventListener('click',(e)=>{

            e.preventDefault()

            const filter = e.target.dataset.value
            
            storeItems.forEach(i=>{
                if(filter ==='all'){
                    i.style.display = 'block';

                }else{
                    if(i.classList.contains(filter)){
                        i.style.display='block';

                    }
                    else{
                        i.style.display='none';
                    }
                }
            })
        })
        )
    });
</script>

<div class="sc-iYUSvU ikgsKY">
    <div>상품 <span class="sc-hdPSEv cGBwKR"> {{ count($goods) }}</span></div>
    <div class="sc-gleUXh fuJZOD">
        <div class="nice-select selector" tabindex="0">
            <span class="current">전체</span>
            <ul class="list">
                <li data-value="all" class="option selected">전체</li>
                @foreach($cate_arrs as $cate_arr)
                <li data-value="{{$cate_arr['categorys_id']}}" class="option">{{$cate_arr['categorys_name']}}</li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
<div id="area-good">
@if( count($goods) == 0 )
<div class="sc-bNQFlB ljYihu">등록된 상품이 없습니다.</div>
@else
<div class="sc-cmIlrE jmiReu goodsList">
    <div class="sc-doWzTn gyTSHV">
        <div class="sc-cHSUfg buZDUx">
            <div class="sc-cgHJcJ gMSqsm">
                <div>전체</div>
                <div class="sc-dRCTWM lnXGKB">{{ count($goods) }}</div>
            </div>
            <div class="goods-orders bqqFqe"><a class="goods-order dTzubM" value="0">최신순</a><a class="goods-order dbHxCD" value="1">저가순</a><a class="goods-order dbHxCD" value="2">고가순</a></div>
        </div>
    </div>

    <div class="sc-fKGOjr fALQdp" id="goodsList">
        @foreach($goods as $good)    
        <div class="sc-jvEmr gVELYp sell-item {{ $good->category_id }}"><a class="sc-fnwBNb hhKfvJ" href="/goods/{{$good->goods_id}}">
                <div class="sc-iNhVCk kwfsTP"><img src="{{ asset('storage/images/goods/'.$good->name) }}" alt="상품 이미지">
                    <div class="sc-kcbnda kADBJz"></div>
                </div>
                <div class="sc-eAKXzc brUNPn">
                    <div class="sc-bfYoXt eAzkkl">{{ $good->title}}</div>
                    <div class="sc-gkFcWv dOnitE">
                        <div class="sc-gbOuXE guxuzf">{{ number_format($good->price) }}</div>
                        <div class="sc-hUfwpO dOuGQt"><span>{{ $good->writeday }}</span></div>
                    </div>
                </div>
                <div class="sc-dRFtgE dzaIET"><i class="fa-solid fa-location-dot"></i>{{ $good->area }}</div>
            </a>
        </div>
        @endforeach
    </div>
    
    <div class="sc-dBaXSw FCGoA"></div>
</div>
@endif

</div>