<div class="row">
    @foreach ($goods as $index=>$good)
        <div class="col-lg-4 col-md-6 col-sm-6" onclick="location.href='/goods/{{ $good->id }}'">
            <div class="product__item">
                <div class="goods_image product__item__pic" style="background-image: url({{ asset('storage/images/goods/'.$good->goods_image) }});">
                    <ul class="product__item__pic__hover">
                        <li class="heart_pop">
                            <a class="{{ $isHearts[$index] == 0 ? 'rel_heart_t' : ''}}"><i class="fa fa-heart"></i></a>
                            <input type="hidden" name="{{ $good->id }}" value="{{ $isHearts[$index]}}" />
                        </li>
                    </ul>
                </div>
                <div style="background-image : url({{ asset('storage/images/goods/'.$good->goods_image) }})"></div>
                <div class="product__item__text">
                    <h6 id="today_goods_title">{{ $good->title }}</h6>
                    <h5>{{ number_format($good->price) }} 원<span id="m_goods_writeday">{{ $good->writeday }}</span></h5>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="product__pagination my_pagination">
    @if ($goods->currentPage() > 1)
        <a class="pagi" href="{{ $goods->previousPageUrl() }}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
    @endif
    @for($i = 1; $i <= $goods->lastPage(); $i++)
        <a class="pagi {{ $goods->currentPage() == $i ? 'active' : '' }}" href="{{$goods->url($i)}}">{{$i}}</a>
    @endfor
    @if ($goods->currentPage() < $goods->lastPage() )
        <a class="pagi" href="{{$goods->nextPageUrl()}}"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
    @endif
</div>
<script>
    $('.heart_pop').click (function (e) {
        e.stopPropagation();
        let isLogin = '{{ auth()->check() }}';

        if (isLogin == '') {
            alert("로그인 후 사용할 수 있습니다.");
            return;
        }

        heart_pop_func(this);
    });
    $('#goods_count').text('{{ $goods->total() }}');
</script>