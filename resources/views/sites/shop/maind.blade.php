@extends('layouts.siteLayout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });



    //프로필 뒷 배경 설정
    $(function() {
        $(document).ready(function() {
            var src = $('#profile').attr("src");
            $("#bHTJYK").css('background-image',src);
        });

    });



</script>
<secssion class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4 style="text-align:center;">Shop</h4>
            <div class="sc-kIWQTW vYdwB">
    <div class="sc-jOBXIr iFwjPv">
        <div class="sc-fyjhYU jIbgyD">
            <div class="sc-ugnQR WjsBc">
                <div class="sc-gpHHfC fnqfNl">
                    <div size="310" class="sc-gVyKpa gfUMTh">
                        <div class="sc-gPzReC hbVKzb">
                            <div class="sc-jrIrqw bHTJYK" id="bHTJYK">

                            </div>
                        </div>
                        <div class="sc-eXNvrr eqKfAa">
                            <img src="{{ asset('storage/images/users/'.$user->image) }}" width="100" height="100" id="profile" class="sc-cpmKsF kokTJU">
                            <div class="sc-kQsIoO YgUrz">{{ $user->store_name }}</div>
                            <div class="sc-hIVACf eHVdaG">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAcCAYAAAB2+A+pAAAAAXNSR0IArs4c6QAAAqNJREFUSA2tVk1rE0EYzrYbSKQXRYIfCaUiggaJJiH+AIsnL1poRQ+CBy8VvOivUA8evHgoeNCbRz3pH5B8HlIvYpG0VULxJBqMZn2eZWc7O5nZ7I5deJl33vf5yMzsTpvJWD6tVussw5KembMlgnc9CCsJa2PP81YYVq4gOTbEXq+3NB6PP5ObzWZPVSqVrbQ6ViuGKbfZf+Rc1JKMVsaO44RbLOdJDAUm9Va32+0TONtthM+FsYcoVqvVXSGaZEy9YhheE6Y0YM5aEjMZk9oY5PB8JSFdTWpPp6m2utlsHoXEN8S8IvUX82P1en1PqRunbrfbvYitOmRESI3JZLIMrGpKxDzOeb3T6byT4MYU2J8Orz2IvQLqghF5sI0ujG/O1Wq1j/l8/hImjxHewXrsq1GbHvSiZ+SM8alcxupfIE7uU/4/g+EO4jY+ufdCLWLMYr/fPzIajZ7DPLwkBNhmhOHrXC53t1wuf5f5U8aiidXfgflTxIKopRlh+ANxH6vc0PGMxgTjxTsN45dIGzpyTO0DTG/hLD+ZMLHGJMHYxep7GM+ZROQ6DDexygrGP3JdzWfeXPg2D8P0jEo0zYklx9QX9ZnGAPIlcwUhwUjszBdzpjFWcCOBWQSShBN7xribj+Os+Cdw6gei7l+P6C1HXDFBb4J6EXf3V7Un5lOCohGMq6opRH+j9wAv0BUG86AWUgPOaljQJLHGEFyTOZhvIhpYyROMvAK9IG+wp2AjXLnH3LjV+IQW8cu3ED4Gws8KhcLDUqn0SxXhfDAY5IfD4SPg1zkPftgSduUL5+pjXDEEuM3gO0OQruIyuGcypSh7xBBLDrnUYE/3xBnzbX7ruu55bOcbHVlXI5YccmGc7ovA/81FXJf+lunEk9aoQS0d/h/pAwlu3rYpxwAAAABJRU5ErkJggg==" width="15" height="14" alt="작은 별점 0점 이미지"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAcCAYAAAB2+A+pAAAAAXNSR0IArs4c6QAAAqNJREFUSA2tVk1rE0EYzrYbSKQXRYIfCaUiggaJJiH+AIsnL1poRQ+CBy8VvOivUA8evHgoeNCbRz3pH5B8HlIvYpG0VULxJBqMZn2eZWc7O5nZ7I5deJl33vf5yMzsTpvJWD6tVussw5KembMlgnc9CCsJa2PP81YYVq4gOTbEXq+3NB6PP5ObzWZPVSqVrbQ6ViuGKbfZf+Rc1JKMVsaO44RbLOdJDAUm9Va32+0TONtthM+FsYcoVqvVXSGaZEy9YhheE6Y0YM5aEjMZk9oY5PB8JSFdTWpPp6m2utlsHoXEN8S8IvUX82P1en1PqRunbrfbvYitOmRESI3JZLIMrGpKxDzOeb3T6byT4MYU2J8Orz2IvQLqghF5sI0ujG/O1Wq1j/l8/hImjxHewXrsq1GbHvSiZ+SM8alcxupfIE7uU/4/g+EO4jY+ufdCLWLMYr/fPzIajZ7DPLwkBNhmhOHrXC53t1wuf5f5U8aiidXfgflTxIKopRlh+ANxH6vc0PGMxgTjxTsN45dIGzpyTO0DTG/hLD+ZMLHGJMHYxep7GM+ZROQ6DDexygrGP3JdzWfeXPg2D8P0jEo0zYklx9QX9ZnGAPIlcwUhwUjszBdzpjFWcCOBWQSShBN7xribj+Os+Cdw6gei7l+P6C1HXDFBb4J6EXf3V7Un5lOCohGMq6opRH+j9wAv0BUG86AWUgPOaljQJLHGEFyTOZhvIhpYyROMvAK9IG+wp2AjXLnH3LjV+IQW8cu3ED4Gws8KhcLDUqn0SxXhfDAY5IfD4SPg1zkPftgSduUL5+pjXDEEuM3gO0OQruIyuGcypSh7xBBLDrnUYE/3xBnzbX7ruu55bOcbHVlXI5YccmGc7ovA/81FXJf+lunEk9aoQS0d/h/pAwlu3rYpxwAAAABJRU5ErkJggg==" width="15" height="14" alt="작은 별점 0점 이미지"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAcCAYAAAB2+A+pAAAAAXNSR0IArs4c6QAAAqNJREFUSA2tVk1rE0EYzrYbSKQXRYIfCaUiggaJJiH+AIsnL1poRQ+CBy8VvOivUA8evHgoeNCbRz3pH5B8HlIvYpG0VULxJBqMZn2eZWc7O5nZ7I5deJl33vf5yMzsTpvJWD6tVussw5KembMlgnc9CCsJa2PP81YYVq4gOTbEXq+3NB6PP5ObzWZPVSqVrbQ6ViuGKbfZf+Rc1JKMVsaO44RbLOdJDAUm9Va32+0TONtthM+FsYcoVqvVXSGaZEy9YhheE6Y0YM5aEjMZk9oY5PB8JSFdTWpPp6m2utlsHoXEN8S8IvUX82P1en1PqRunbrfbvYitOmRESI3JZLIMrGpKxDzOeb3T6byT4MYU2J8Orz2IvQLqghF5sI0ujG/O1Wq1j/l8/hImjxHewXrsq1GbHvSiZ+SM8alcxupfIE7uU/4/g+EO4jY+ufdCLWLMYr/fPzIajZ7DPLwkBNhmhOHrXC53t1wuf5f5U8aiidXfgflTxIKopRlh+ANxH6vc0PGMxgTjxTsN45dIGzpyTO0DTG/hLD+ZMLHGJMHYxep7GM+ZROQ6DDexygrGP3JdzWfeXPg2D8P0jEo0zYklx9QX9ZnGAPIlcwUhwUjszBdzpjFWcCOBWQSShBN7xribj+Os+Cdw6gei7l+P6C1HXDFBb4J6EXf3V7Un5lOCohGMq6opRH+j9wAv0BUG86AWUgPOaljQJLHGEFyTOZhvIhpYyROMvAK9IG+wp2AjXLnH3LjV+IQW8cu3ED4Gws8KhcLDUqn0SxXhfDAY5IfD4SPg1zkPftgSduUL5+pjXDEEuM3gO0OQruIyuGcypSh7xBBLDrnUYE/3xBnzbX7ruu55bOcbHVlXI5YccmGc7ovA/81FXJf+lunEk9aoQS0d/h/pAwlu3rYpxwAAAABJRU5ErkJggg==" width="15" height="14" alt="작은 별점 0점 이미지"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAcCAYAAAB2+A+pAAAAAXNSR0IArs4c6QAAAqNJREFUSA2tVk1rE0EYzrYbSKQXRYIfCaUiggaJJiH+AIsnL1poRQ+CBy8VvOivUA8evHgoeNCbRz3pH5B8HlIvYpG0VULxJBqMZn2eZWc7O5nZ7I5deJl33vf5yMzsTpvJWD6tVussw5KembMlgnc9CCsJa2PP81YYVq4gOTbEXq+3NB6PP5ObzWZPVSqVrbQ6ViuGKbfZf+Rc1JKMVsaO44RbLOdJDAUm9Va32+0TONtthM+FsYcoVqvVXSGaZEy9YhheE6Y0YM5aEjMZk9oY5PB8JSFdTWpPp6m2utlsHoXEN8S8IvUX82P1en1PqRunbrfbvYitOmRESI3JZLIMrGpKxDzOeb3T6byT4MYU2J8Orz2IvQLqghF5sI0ujG/O1Wq1j/l8/hImjxHewXrsq1GbHvSiZ+SM8alcxupfIE7uU/4/g+EO4jY+ufdCLWLMYr/fPzIajZ7DPLwkBNhmhOHrXC53t1wuf5f5U8aiidXfgflTxIKopRlh+ANxH6vc0PGMxgTjxTsN45dIGzpyTO0DTG/hLD+ZMLHGJMHYxep7GM+ZROQ6DDexygrGP3JdzWfeXPg2D8P0jEo0zYklx9QX9ZnGAPIlcwUhwUjszBdzpjFWcCOBWQSShBN7xribj+Os+Cdw6gei7l+P6C1HXDFBb4J6EXf3V7Un5lOCohGMq6opRH+j9wAv0BUG86AWUgPOaljQJLHGEFyTOZhvIhpYyROMvAK9IG+wp2AjXLnH3LjV+IQW8cu3ED4Gws8KhcLDUqn0SxXhfDAY5IfD4SPg1zkPftgSduUL5+pjXDEEuM3gO0OQruIyuGcypSh7xBBLDrnUYE/3xBnzbX7ruu55bOcbHVlXI5YccmGc7ovA/81FXJf+lunEk9aoQS0d/h/pAwlu3rYpxwAAAABJRU5ErkJggg==" width="15" height="14" alt="작은 별점 0점 이미지"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAcCAYAAAB2+A+pAAAAAXNSR0IArs4c6QAAAqNJREFUSA2tVk1rE0EYzrYbSKQXRYIfCaUiggaJJiH+AIsnL1poRQ+CBy8VvOivUA8evHgoeNCbRz3pH5B8HlIvYpG0VULxJBqMZn2eZWc7O5nZ7I5deJl33vf5yMzsTpvJWD6tVussw5KembMlgnc9CCsJa2PP81YYVq4gOTbEXq+3NB6PP5ObzWZPVSqVrbQ6ViuGKbfZf+Rc1JKMVsaO44RbLOdJDAUm9Va32+0TONtthM+FsYcoVqvVXSGaZEy9YhheE6Y0YM5aEjMZk9oY5PB8JSFdTWpPp6m2utlsHoXEN8S8IvUX82P1en1PqRunbrfbvYitOmRESI3JZLIMrGpKxDzOeb3T6byT4MYU2J8Orz2IvQLqghF5sI0ujG/O1Wq1j/l8/hImjxHewXrsq1GbHvSiZ+SM8alcxupfIE7uU/4/g+EO4jY+ufdCLWLMYr/fPzIajZ7DPLwkBNhmhOHrXC53t1wuf5f5U8aiidXfgflTxIKopRlh+ANxH6vc0PGMxgTjxTsN45dIGzpyTO0DTG/hLD+ZMLHGJMHYxep7GM+ZROQ6DDexygrGP3JdzWfeXPg2D8P0jEo0zYklx9QX9ZnGAPIlcwUhwUjszBdzpjFWcCOBWQSShBN7xribj+Os+Cdw6gei7l+P6C1HXDFBb4J6EXf3V7Un5lOCohGMq6opRH+j9wAv0BUG86AWUgPOaljQJLHGEFyTOZhvIhpYyROMvAK9IG+wp2AjXLnH3LjV+IQW8cu3ED4Gws8KhcLDUqn0SxXhfDAY5IfD4SPg1zkPftgSduUL5+pjXDEEuM3gO0OQruIyuGcypSh7xBBLDrnUYE/3xBnzbX7ruu55bOcbHVlXI5YccmGc7ovA/81FXJf+lunEk9aoQS0d/h/pAwlu3rYpxwAAAABJRU5ErkJggg==" width="15" height="14" alt="작은 별점 0점 이미지">
                            </div>
                            <div class="sc-hjRWVT fPlNlP">
                                <a class="sc-exkUMo jxncag" href="/products/manage">내 상점 관리</a>
                            </div>
                        </div>
                    </div>
                    <div class="sc-jwKygS gSsteC">
                        <div class="sc-btzYZH loGZtw">
                            <h2 class="sc-lhVmIH hWqodb">프로필 수정</h2>
                            <p class="sc-bYSBpT kYaBSe">프로필 사진 추가/수정은 번개장터 앱에서만 가능해요</p>
                            <div class="sc-elJkPf cgZVKM"><button type="button" class="sc-jtRfpW caPtxQ">앱으로 이동하기</button>
                                <button type="button" class="sc-kTUwUJ cFsfis">취소</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sc-eTpRJs jYfwLF">
                <div class="sc-dxZgTM kaLeab">
                    <div class="sc-BngTV hgrllz">{{ $user->store_name }}<button class="sc-eIHaNI jHdWCJ" id="editStoreName">상점명 수정</button></div>
                </div>
                <div class="sc-iomxrj hLGebF">
                    <div class="sc-dvCyap bPBpdJ"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAAAXNSR0IArs4c6QAAAfBJREFUSA3tU79rFFEQntkcuBesDF5pdyRFrjNaiJBgERA0pEh1P4yCC4rWFiH/gIWN1W4iIclZeKRIlS6gSZkUQQsbOwtBwUp2n4f3xm827LK32eICd90NHDvvm+/N9+bHMcGioHEkInfVH7Yx86ey155n2WlWTCQ/hMQZtojmY6ae67gVxxhaGpWIConQhBFzH1XYZQVGaWL5obbr3ihFNDcTLVLoN06KhICfdTdbt/IxE9SfG7/xLI93/ebtKGi+y+N6DoPGTwfD+iNbq26WIAcvr+AV1Z6V6SyuvhDVLNMFvEdSw6xrF/jIzUKfIcR7pvvvjXQ6E3EiEY6+/36NS5OY3yvZbk0ll8PNR3dI+DEe8eSvvzqT4JHfugF/HZOfMxtNL8E1p+ZWDdyJS3vLIovYxVM8WV82m5CB/QL2EcRrxDKvW6QxJg5R3eG5Lwvwr2bunID/DcI3QfxQ9t6vlzSIsr5YkRcIVFNy4ohch7uCRHHfUjiumB7k4PMwKgN/Tg8lLu3rdyR/Uk2ct7FQviMDn+NlyLOxUW12+DiLW2v95Ix1PcavnZzzX7Gyhs3VlU+tWAgi7tPdIGXBCf16KoR1/+p6/fE+blD3wOkTGi9DtkOX8gtnpIPvm8mlUhaTxzMq7ssA6Lh1AzSpmPIfjjO10v2iE7IAAAAASUVORK5CYII=" width="14" height="13" alt="상점오픈일 아이콘">상점오픈일<div class="sc-iFMziU kMdfYQ">{{ $open_day }}일 전</div>
                    </div>
                    <div class="sc-dvCyap bPBpdJ"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAAAXNSR0IArs4c6QAAAQBJREFUSA1jZCASNOz/z3L34Z1aBkaGZLCW/wxzleVVmhscGf8QYwQLMYpAakCW/GdgqGMAElBQBxQDMethAvhoJnySKHIwnyALYhNDlkdiE28RkiZymMRbBIwTDAuwiWEogggQHUegiAfHCSy4oIkBh7kjQJgxdtHtUIZ/jJP+M/yXoIV/GRkYXzAw/c9joqUlIIeDPQD0CPGpjkLvMoG8BfYehQbh0g4LOkZcCkDiMQtuIwocfAqhcksSVHGaR8egI8Kl1FAy6iOyQ5HoQhVkA3qqIiVVjsYR2XE0woIOubBFZsPCD1kMmQ2TR6bxBx20ZAcbAmQjawSzCckjaQAAJL9HBV3GwxoAAAAASUVORK5CYII=" width="14" height="13" alt="상점방문수 아이콘">상점방문수<div class="sc-iFMziU kMdfYQ">{{ $user->store_visit }} 명</div>
                    </div>
                    <div class="sc-dvCyap bPBpdJ"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAAAXNSR0IArs4c6QAAAl1JREFUSA21Vc9PE1EQnnktW2yIFy9GiCduSki4QjSGwA3qj248q/HCwQtnwg//CxKrMd4WMO2RQrxwkbQmBI0XExMxqQk3TTAt7Q4zu91l231btrq85KWz33wz39v3vn0F6HOYO7nHMvssA+ynwPxgXrebjc9So9LGbeue9StuvYpLFJ592lgHomsynbiP4thC+XLuCQDN8Rb8limxi8VTi7V1Ztm8SVQ/JICriPhUWhNRwRHFzJg1Y/24SO7CN+KGSNAotEVKGzPF1zJZsCSYk2POfwvld+8vsNg0dzq+klXPvYYSCyY54Xh41G/PlbDLRu3T+gEXZ1UKH1rTxffBRuZu7oHdoi3GTtRAZpxd+C2YD8aRW7dCK4pF3jA5y9v0tltEmggmOeEIV2oE143IxJedT4tcMAmARwjGC12xYG4Oj4TbrtFSMV+e/0kEw9psYiDWFBDuJ9YvohEiVWXrPkbkk4QrSim69DcCTFXV0CBUENBOcvndvQYNrKrCVOkPXyhfu5OhZ4SmAlxWqcyIMzlmyzVDvBCAtXd3tmppB0c2BNGtECcAKMKX1mxxLQCtmds5sIFWA1goFCMI6H5HGMMQKeNVqIsOC5Gg4gvxfXV5hmAj+EJj6YlDvkr+hhcTQFqNZ4EnN9RhXSQxgkD+pfpoe36Pn/nKiRhiBj4n8LaLRWykJSBwz1lbhrXN2eINSfkkfqN93sJoIW7oHHyrfn74/IfUa3hGEI5/qWIcQ/Tqqs85RugQggEjeUO0jdAhZN21vvOBHesX9m+oZ4QOIaeVfLiJDfdG8NqdARu11RN7gt5lAAAAAElFTkSuQmCC" width="14" height="13" alt="상품판매 아이콘">상품판매<div class="sc-iFMziU kMdfYQ">{{ $user->sale_num }} 회</div>
                    </div>
                    <div class="sc-dvCyap bPBpdJ"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAAAXNSR0IArs4c6QAAAQlJREFUSA1jZEACoceOcf5k+HqV4T+DIpIwnMnEzGyywcLpLEgg4MQ+439//56BSyIzGBnuszNwa6+2svoOE2aCMUD0r/9fq3FZgqyOIBvoULBZSArhFvmd3qfOwMhQiiRHGRNoFthMqClwixh//536/z8DG2WmI3SDzAKZCRMBWxRwbG8kUMIZJkgtGmQmyGyQeUzRJ07w/WP430ctw9HNAZkNsoPly9+vLQwM/yXQFVCN//+/BMgOFkZWpnmM/xgXEmOwGAvfdZg6EPsVwycTGB8vzcT4F6/8kJRkDDi2J40eLmf59///THpYBM+wtLZs1CKyQ3g06EaDDh4Co4kBHhSkMoZf0AEAMN1RWGgFcjgAAAAASUVORK5CYII=" width="14" height="13" alt="상퓸발송 아이콘">택배발송<div class="sc-iFMziU kMdfYQ">{{ $user->delivery_num}} 회</div>
                    </div>
                </div>
                <div class="sc-keVrkP QdtSU">{{ $user->introduction }}</div>
                <div class="sc-cBdUnI hThOPJ"><button class="sc-eIHaNI jHdWCJ" id="editIntro">소개글 수정</button></div>
            </div>
        </div>
    </div>

    <!-- 메뉴 시작 -->
    <div class="col-lg-12 sc-gCwZxT hbbGSy">
        <div class="product__details__tab sc-fUdGnz caKLIw">
            <ul class="nav nav-tabs sc-drKuOJ bJTIh" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#tabs-1"role="tab"
                        data-toggle="tab" aria-selected="true">상품 <span class="sc-sdtwF kjUuFF">{{ count($goods) }}</span></a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link " href="#tabs-2"role="tab"
                        data-toggle="tab" aria-selected="false">상점문의 <span class="sc-sdtwF kjUuFF">{{ count($questions) }}</span></a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link " href="#tabs-3"role="tab"
                        data-toggle="tab" aria-selected="false">찜 <span class="sc-sdtwF kjUuFF">{{ count($hearts) }}</span></a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-4" role="tab"
                        data-toggle="tab" aria-selected="false">상점후기 <span class="sc-sdtwF kjUuFF"></span></a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link " href="#tabs-5" role="tab"
                        data-toggle="tab" aria-selected="false">팔로잉 <span class="sc-sdtwF kjUuFF">{{ count($follows) }}</span></a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link"  href="#tabs-6" role="tab"
                        data-toggle="tab" aria-selected="false">팔로워 <span class="sc-sdtwF kjUuFF">{{ count($follwers) }}</span></a>
                </li>    
            </ul>
        </div>
        <div class="tab-content sc-giOsra dnwkyQ">
            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                <div class="sc-iYUSvU ikgsKY">
                    <div>상품 <span class="sc-hdPSEv cGBwKR"> {{ count($goods) }}</span></div>
                    <div class="sc-gleUXh fuJZOD">
                        <div class="sc-hycgNl hMqMBc">
                            <div class="sc-dTLGrV bKYuqq">전체<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAOCAYAAAAvxDzwAAAAAXNSR0IArs4c6QAAASVJREFUOBGlks9qwkAQxrMLihRKQXyUHjx58dBLEXqxUPCavIKvkpCQgxcTD0LpSQQfoBfpRXwHj16av37fYWWrJhvqwDCbb2d+O5NdYcFc120hzIQQkW3bS2pNzPf9blEUC+ROUffNGkEYQWVZvuE7xfq9CRR1T8hfw5/hR/jIcZyN8DyPsDEEZUZoEASPeZ6vUNdXRYi/aOZVYjGHp9pGC4kRDmLHV4bOHrIs+7qAWYDtoW0lx+OYqDRCwzDsIO8TPtBPQv0PYEOMfGCHVhNoHMftJEl4YcMqGHWhb3JMjguNt64slVJOoH/AR0pk1DtT+h8gxQqoyj/HWzBuXgEpmqBVsEpgHbQOVgu8BTXBjEAdCthOPQ3qdxn+6QsedO8uyH+LT8nvvwPGjeHzAAAAAElFTkSuQmCC" width="10" height="6" alt="카테고리 화살표 아이콘"></div>
                            <div class="sc-chAAoq eeSTNK">
                                <a class="sc-ivVeuv dBnGno">전체</a>
                                <a class="sc-bvTASY dpDnHy">신발</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                @if( count($goods) == 0 )
                <div class="sc-bNQFlB ljYihu">등록된 상품이 없습니다.</div>
                @else
                <div class="sc-cmIlrE jmiReu">
                    <div class="sc-doWzTn gyTSHV">
                        <div class="sc-cHSUfg buZDUx">
                            <div class="sc-cgHJcJ gMSqsm">
                                <div>전체</div>
                                <div class="sc-dRCTWM lnXGKB">{{ count($goods) }}</div>
                            </div>
                            <div class="sc-cTjmhe bqqFqe"><a class="sc-cugefK dTzubM">최신순</a><a class="sc-cugefK dbHxCD">인기순</a><a class="sc-cugefK dbHxCD">저가순</a><a class="sc-cugefK dbHxCD">고가순</a></div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">상품</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">상점문의</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">찜</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">상점후기</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">팔로잉</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">팔로워</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <div class="row">
                                        <div class="col-6">@@@@</div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane active" id="tabs-2" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <div class="row">
                                        <div class="col-6">######</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <div class="sc-fKGOjr fALQdp"><!--  asset('storage/images/goods/'.$goodsImgs->image) }} -->
                        @foreach($goods as $good)    
                        <div class="sc-jvEmr gVELYp"><a data-pid="191679399" class="sc-fnwBNb hhKfvJ" href="/products/191679399?ref=%EC%83%81%EC%A0%90%EC%A0%84%EC%B2%B4%EC%83%81%ED%92%88">
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
                                <div class="sc-dRFtgE dzaIET"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAiCAYAAABIiGl0AAAAAXNSR0IArs4c6QAAA6xJREFUWAm1l01IVFEUx51xNAtxIcEENuQIrqTxO8OEmj5IAncVUS2E2kS0axO4C5KiFi0lXIh9QBC1kKgwclNGjaNOSUEapVRiUSHoTOo4/c743vjem/vGp8xcuHPu+Z//Of9778y9740rz0EbGxsrjsViQait9JpEIuF1uVzbGCfo0/jT2GGwx6WlpQN+vz+Gn7G5MkXD4fAOil6C047dlImrxxCfg9tVUFBwtbq6ekbHrVYpzAoLo9FoJ+QL9AJrkkN/3u12d9bW1l5hMsvWnDTh4eHh8uXl5fvMutFK3qD/jLxTDQ0Nv4z5JuHR0VH/4uLiKwjy/WWtseJPLKTZKO7Wq4dCoa1LS0tP8bMqKvURrcT0TU1NbRZfWkqYWXVrhJVI9j+bZmZmbuplk1s9NDR0GNEnOpgrKz8ydBrZ8rBHRHCur0MsCvc1Pazl1GF301PbqOFpBh3Z4Rv0oIvVBgBG01hqYKCwsPBMIBD4bAxHIpGKhYWFbrB9RtxuzDEr9yB6zI5gwV/U19cfYLvktjI1mQh19rOI5wSCpqDC4bgelaXvUcRMEGJzAO0qUZ2oxdrx53XMzsI9KMJldgQDPsgPYtLgK4fCoeigMmgA2R2fCG83YMohxCFlQAHCDSlgE8Tkytx8yDZmbHCKMxIMQSdcJueWFU8Y8pRDiA3KgAJ0yJ1wJMwqGrlSWxQ6Jkg4wjWBamfCzQzfqmOrqGwNXo/c56uoeaTFejSuOWjxmNx7KXiHwYIlpnIr4I1xVo9TPF8nyFgwiYFV6LidhZfgJaFXv6vvUeCEHVmBy7UZ0fAAds3rUq+BcD8X0SFZcR5XWJcecGhFqEnrjkW12rfEJoV5PRlgJg+1QM4MGqG6uroHKWEZsNXnCfzNmWpe3iL1z9LjJmGuux+AF3MlTO1rrDb1FExutS5GQB5tj3Q/WxbRSElJyWVjPZOwBLxe70mI8sKXrTaZn59/pLKy8p+xYJqwz+eLFhUVtUH6aCRuZMwC/tBba2pqvlnz04SFUFVV9Zsj1krSd2vCOvwYNdo4sx9UOUphIfJ9f8XsRXxclbgGNiuiHNOXdjxbYUlgtuMINzN8Y1dAgU+BtTDxfkUsBWUUFhYFfmKCTKAvlWU/kDfPJo7mO3vKSiR5V69Fkrg8DPj32IHtwE2+FhvzmFivx+M5xz/ENV8sJM+xsC4yMjKyKx6P32YC8rdE2iz9HKu8m/QcfqxbWOry7N2CkRfznZzR0/yIvjBeV/sPFdozA8TD8zUAAAAASUVORK5CYII=" width="15" height="17" alt="위치 아이콘">{{ $good->area }}</div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="sc-dBaXSw FCGoA"></div>
                </div>
            </div>
            @endif
            <div class="tab-pane" id="tabs-2" role="tabpanel">
                <div class="sc-iYUSvU ikgsKY">
                    <div>상점문의<span class="sc-jRhVzh loJVai">{{ count($questions) }}</span></div>
                </div>
                <div class="sc-iHhHRJ iUpXMa">
                    <div class="sc-hizQCF dkQsQa">
                        <div class="sc-eNPDpu eydEOz"><textarea placeholder="상품문의 입력" class="sc-hARARD iilSfO"></textarea></div>
                        <div class="sc-ccLTTT ighuEl">
                            <div class="sc-hlILIN hgAycc">0 / 100</div><button class="sc-jQMNup cWmvOj"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAgCAYAAAAFQMh/AAAAAXNSR0IArs4c6QAABFdJREFUSA3Nl11MVEcUgPfnIj8B1kRi4AFI9cEiITFGfZXUYNWKxJ9CtBqC0WCMuoEGgfIPBsVsU7MpVdRV0qZpgkZLjU2qrYD6oCTw4A+YoGktTQhiIE1hC7td8Dsb7ua6ruxd2IdOMsy5Z84535wzM/cuRkOYW0tLS8zw8PCR6enpfKPRaCH865mZmRuKolysrKx8qeKMqhCO0WazJUxMTNwBlAF0gJjXkBGNHzN+wHi4pqbme2GFDexwOOIGBwf/JHgccW0pKSm1BQUFkwKRVl9fv4cqnDWZTNbq6urWsIA7OjqUrq6uH4DmwFDI7nRtbW2Zl6j509DQ8JHH42k3m83rzBr9vMS2tjZzT0+PlG9LVFTURrJahvxZZmZmdGdn56/aoCzwd/Qr0a0yaSdClQXa39//HRlm4fvH5ORkc0xMzKdk3kU/Ttan/GOS7RXsc+YNxtnU19fXSuBNERERWfHx8euBucfHx38LAv8PO8u8wAKtq6u7TIBsMthYUVHRW1xcPBoZGbmBhTjngrMVW7F5FfLhAmrkhDoYd3I3s7ib3QTytebm5tiRkZGbKBbHxsZucDqdUtr19NMs9CH6K4zHQgLjLNALOOdKpkAf+IgaQV4iQ0ND7aiW+sE9QG+npaVl6y61QCnvOcY8oJveBxV+YWGhMzU1NRvxLyk75e0Wf9rfsv+5ubkeXRnPQr8h0F7KuxnofQEEa5z6RZz6XvzTgV7nuuWXlpb+I3667jFvm69xzAf6CdB7wYDqfEZGRgnQ3QJNTEzMs1qt/6pzQUtNee04FwDfCvSu6hhsxK+EEp9UoZTfrfWZE8wL4CuMD7Cn2VVVVZ1ax7lkDmAxi5VT7M3UHyq+7wWzYhvzh+g5QO+IsZ6Gn5VMv5wLKnGUQMHItAn9EZxz+IzdDmQTSAf0KJmeCQYV33cyBir7YmVuO9BfAgEC6SjvYaB2PVDxf+s6seITOJfgvAOovH10NfwKMTxL/1FOb6A99Q/kKzWZ1jF5nIO0iz3VDSXTAyw2JKgswpsxH+hdHIg2AoyQ7QDjIAu4zAJu+a9U+wx0P7YX0enOVPX37jHQJBQu+nkCyX3bhq5SNQo0Ut58bC4wFzJU4nlLDWwNcj/lrhIlmXxB0OUiB2rM72X+EtVp17un/nHUPRZwrzpJ0BUEnZJSIqch/8xh65B5dHtYaOtCoBLHJN9Pxg8J9EQUs20ZwQ8CdaDfhywfCAPlzUP+FvGn+WY6G9+gjI2NreaBV7HpqU+pKJ8DSIiOju52u92LXS7XM6C7BcpCFgwVjkJWUmYDXx5fxnwMfL8q7Ha7a2pqygxQoDcWmqmwpAl4LeN4WVnZy/LyckNTU1McoJVkJz9D00dHR9PFkOfepKQkXS8HsQ/WjJzkAYwS6A/IKB1Asjghexie0x+he2GxWOxFRUVDMheOJqd6EV3usMhX2etHjI+Tk5Ofav8FQRfe1tjYuCS8Ef/n0d4Ah7Y0Xn+VgFMAAAAASUVORK5CYII=" width="15" height="16" alt="문의등록버튼 아이콘">등록</button>
                        </div>
                    </div>
                </div>
                <div class="sc-lnrBVv iHznkb">등록된 문의가 없습니다. 첫 상품문의를 등록해보세요!</div>
            </div>
            <div class="tab-pane" id="tabs-3" role="tabpanel">
                <div class="sc-iYUSvU ikgsKY">
                    <div>찜<span class="sc-aewfc gZJZxx">{{ count($hearts) }}</span></div>
                </div>
                <div class="sc-dvpmds iOuKDC">찜한 상품이 없습니다.</div>
            </div>
            <div class="tab-pane" id="tabs-4" role="tabpanel">
                <div class="sc-iYUSvU ikgsKY">
                    <div>상점후기<span class="sc-glUWqk dLMFot">0</span></div>
                </div>
                <div class="sc-fFTYTi lbZBQ">상점후기가 없습니다.</div>
            </div>
            <div class="tab-pane" id="tabs-5" role="tabpanel">
                <div class="sc-eweMDZ ejYOno">
                    <div class="sc-iYUSvU ikgsKY">
                        <div>팔로잉<span class="sc-cnTzU hhxeJe">{{ count($follows) }}</span></div>
                    </div>
                    <div class="sc-dAOnuy ddPTol">아직 팔로우한 사람이 없습니다.</div>
                </div>
            </div>
            <div class="tab-pane" id="tabs-6" role="tabpanel">
                <div class="sc-dBfaGr hECoBb">
                    <div class="sc-iYUSvU ikgsKY">
                        <div>팔로워<span class="sc-jgVwMx tFsce">{{ count($follwers) }}</span></div>
                    </div>
                    <div class="sc-ijnzTp kUDvRT">아직 이 상점을 팔로우한 사람이 없습니다.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="sc-jwKygS gSsteC">
        <div class="sc-kAdXeD cRwlCh">
            <div class="sc-hCaUpS cpcDvE">
                <div class="sc-bvTASY bnrEqO">신고하기</div><button class="sc-cFlXAS hJvCHs"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAAXNSR0IArs4c6QAAAiBJREFUaAXtmM1xwjAQRrFvcE+aSJoIPaSI5MCNHmC4caCK1ECaCE0kBTBccPxl0MyO0C6r1drkIF/Q6Gf3vbU9kplM6lUrUCtQK/BvK7Bard622+3DvQCRGwxS/pYbvCzcHY/H/T0kkBO5e76dJMEKzGazj6Zpvrquex5bIsAjNxjAwhW64QbQHweaTqfzxWLxI60pHcvNKQqMLZELD76bAmNJWODVAkNLWOGzBIaSKIHPFvCWKIU3CXhJeMCbBUolvOCLBKwSnvDFAgmJQ7/ZvXCb3QX+s99hn7DDemyMqn0AoNIVgSUlNHOkHNyYiwCCS4DSGAem7XcT4CTQ3x8Gw2OTvDta2NQ8VwEkiKuNvssz7w6P2O4CCEol/pI0zSDwiM1+D2DQep1Op6vCpPqs8em6q0R00NLebDaP5/N5Hx4bxAjttm3ny+Xy2xKXW+MqEMMDGImpkLeEm0AKPlRbGuMqq+13EdAAauZooem8YoEcsJy5FFJqFwlYgCxrBhEoASlZG8uY7oAHgEcMyGQLeCVGco9YWQIeCQFOr9KY6qNEaSIKTdvYK7C59R84B+zY2PRwlqJzpLZKAAGH3E1jCRy/tRI3HyF6skSVvI8CtLrxXZY+T8M6USCG1wQMga2/uTlZgdxAVuDUupzc7DvQP4ev4Rg8RuWpCP7VQM7wYoOFjqvb6/X6HdVQL3CeiHcCDM5ha7hagVqBWgHHCvwCWAH5e5bAf84AAAAASUVORK5CYII=" width="24" height="24" alt="닫기 버튼 아이콘"></button>
            </div>
            <div class="sc-koErNt hoSImv">
                <div class="sc-gJqsIT fFOOZG">
                    <div class="sc-kDhYZr jaHNwd"><span>광고 (상점 및 타사이트 홍보, 상품도배)</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                    <div class="sc-dHIava kMwaJm">
                        <div class="sc-jhaWeW dYHhYh"><button type="button">상점 및 타사이트 홍보</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">상품 도배</button></div>
                    </div>
                </div>
                <div class="sc-gJqsIT fFOOZG">
                    <div class="sc-kDhYZr jaHNwd"><span>상품 정보 부정확 (상품명, 이미지, 가격, 태그 등)</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                    <div class="sc-dHIava kMwaJm">
                        <div class="sc-guztPN jSLYYi"><textarea placeholder="신고 내용을 직접 작성해주세요.
자세하게 적어주시면 신고처리에 큰 도움이 됩니다."></textarea><button type="button">등록</button></div>
                    </div>
                </div>
                <div class="sc-gJqsIT fFOOZG">
                    <div class="sc-kDhYZr jaHNwd"><span>거래 금지 품목</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                    <div class="sc-dHIava kMwaJm">
                        <div class="sc-jhaWeW dYHhYh"><button type="button">가품(위조품/이미테이션)</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">개인정보 거래(SNS계정, 인증번호 등)</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">게임계정/아이템/대리육성</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">담배</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">반려동물(분양/입양 글)</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">비매품 판매(화장품 샘플 등)</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">음란물/성인용품(중고속옷 포함)</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">의약품/의료기기</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">조건부 무료나눔</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">주류</button></div>
                        <div class="sc-bSbAYC klJWzk"><input type="text" placeholder="기타 (사유)" value=""><button type="button">등록</button></div>
                    </div>
                </div>
                <div class="sc-gJqsIT fFOOZG">
                    <div class="sc-kDhYZr jaHNwd"><span>안전결제 허위매물(안전결제 표시 상품 안전결제 거부)</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                    <div class="sc-dHIava kMwaJm">
                        <div class="sc-jhaWeW dYHhYh"><button type="button">안전결제 거부</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">배송전 구매확정 요청</button></div>
                        <div class="sc-jhaWeW dYHhYh"><button type="button">추가 금액 요청</button></div>
                    </div>
                </div>
                <div class="sc-gJqsIT fFOOZG">
                    <div class="sc-kDhYZr jaHNwd"><span>사기의심(외부채널 유도)</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                    <div class="sc-dHIava kMwaJm">
                        <div class="sc-guztPN jSLYYi"><textarea placeholder="신고 내용을 직접 작성해주세요.
자세하게 적어주시면 신고처리에 큰 도움이 됩니다."></textarea><button type="button">등록</button></div>
                    </div>
                </div>
                <div class="sc-gJqsIT fFOOZG">
                    <div class="sc-kDhYZr jaHNwd"><span>기타(사유)</span><button type="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAQCAYAAAAI0W+oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAXNJREFUeNqslK1Pw1AUxV9fmoq5Ldl/MCSaBLkEAQkIPgxzTUABjoRMsAJmCQ4HJGAAw8yCwGFQaCyOKSpgZmIGzk1OyU1Zu7fRm/yWvtvec1777p0XRVFgjLkGZ+DFFBtzYBeEPn5uwAZYAPPgrSCTGngAVRBY/HTBNxOPoFKASYVaVWp3xegWRGoX97KDf5gE1KhxfSwelosTGkrUwRXwpjDxWFvnWjSP5CIxktcLwRPXDdCawqjFWkOtkNq/RhJDsKaa4VAVuUSDNYYa69Q0aSOJL7AI4hGfIS/0546p8akfsCOKZDfLYMCD7aiDzWrjDp8dsPbPiNiMYhncLX7fsmrVdCQjUeaz21lDb3N2egeaqeErqfsl5pK3barOnchIog3O1d/JBc9BuGTO8LqdJ+Q7HPQemOGBS2e9M7+p2nhnnIiLkbToKngGs+BA3XvlveE4Ees4I32wBD5ULmau7yLgTzCQPbAC9rk+Zc4pfgQYAOZsSsrHKCoBAAAAAElFTkSuQmCC" width="13" height="8" alt="화살표 아이콘"></button></div>
                    <div class="sc-dHIava kMwaJm">
                        <div class="sc-guztPN jSLYYi"><textarea placeholder="신고 내용을 직접 작성해주세요.
자세하게 적어주시면 신고처리에 큰 도움이 됩니다."></textarea><button type="button">등록</button></div>
                    </div>
                </div>
            </div>
            <div class="sc-jwKygS gSsteC">
                <div class="sc-btzYZH loGZtw">
                    <h2 class="sc-lhVmIH hWqodb">신고하기</h2>
                    <p class="sc-bYSBpT kYaBSe">신고 내용은 번개장터 이용약관 및 정책에 의해서 처리되며, 허위신고 시 번개장터 이용이 제한될 수 있습니다.</p>
                    <div class="sc-elJkPf cgZVKM"><button type="button" class="sc-jtRfpW caPtxQ">확인</button><button type="button" class="sc-kTUwUJ cFsfis">취소</button></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</secssion>


<link href="{{ asset('cws/site.css'); }}" rel="stylesheet"/>

@endsection