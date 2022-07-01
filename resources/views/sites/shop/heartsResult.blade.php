    <div class="sc-iYUSvU ikgsKY">
        <div>찜<span class="sc-aewfc gZJZxx">{{ count($hearts) }}</span></div>
    </div>
    @if( count($hearts) == 0 )
        <div class="sc-dvpmds iOuKDC">찜한 상품이 없습니다.</div>
    @else
        <div class="sc-dXfzlN dSkUMt">
            <div class="sc-iIHjhz ikTeLI">
                <div class="heart-box dIDDMH">
                    <div class="allCheckBox notAllChekced"></div><button class="Delete-hearts iHTyYv">선택삭제</button>
                </div>
                <div class="heart-orders qbrJx"><a class="heart-order bTGwPH" value="0">최신순</a><a class="heart-order fApKPX" value="1">저가순</a><a class="heart-order fApKPX" value="2">고가순</a></div>
            </div>
            <div class="sc-fvLVrH kiTElI">
                @foreach($hearts as $heart)
                <div class="heart-block fGcQcm" data-id="{{$heart->goods_id}}">
                    <a class="heart-item irufUT" href="/goods/{{$heart->goods_id}}">
                        <div class="heart-box eiboyg">
                            <div class="checkBox noCheck"></div>
                        </div>
                        <div class="sc-eNNmBn dGHWnZ"><img src="{{ asset('storage/images/goods/'.$heart->name) }}" alt="상품 이미지">
                            @if($heart->delivery_fee==1)
                            <div class="sc-dEfkYy bOJzhO">배송비포함</div>
                            @endif
                            <div class="sc-gNJABI fWoSnB"></div>
                        </div>
                        <div class="sc-RbTVP freGkr">
                            <div class="sc-eEieub eLKElK">
                                <div class="sc-hMrMfs cOyliR">{{$heart->title}}</div>
                                <div class="sc-bIqbHp llJioU">
                                    <div>{{$heart->price}}</div>
                                </div>
                                <div class="sc-drlKqa gWeMgW">{{$heart->writeday}}</div>
                            </div>
                            <div class="sc-jxGEyO bobDt"><i class="fa-solid fa-location-dot"></i>{{$heart->area}}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    @endif