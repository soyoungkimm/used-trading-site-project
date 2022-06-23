@extends('layouts.siteLayout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<secssion class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4 style="text-align:center;">Edit User</h4>
            <form name="form1" action="/users/{{ $user->id }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
                <input type="hidden" name="id" value="{{ $user-> id }}"> 
                <input type="hidden" name="pwCheck" value="0">
                <div class="row" style="justify-content: center">
                    <div class="col-lg-8 col-md-6" >
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input mb-2" style="">
                                    <p>아이디<span>*</span></p>
                                        <input class="form-control" type="text" name="uid" id="inputUid" placeholder="아이디를 입력해 주세요" value="{{ $user -> uid }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input mb-1">
                                    <p>비밀번호<span>*</span></p>
                                    <input type="text" name="pwd" id="inputPwd" placeholder="비밀번호를 입력해 주세요">
                                </div>
                                <div class="mb-2" id="pwMemo mb-3">사용가능한 형식입니다</div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>비밀번호확인<span>*</span></p>
                                    <input type="text" name="pwd2" placeholder="비밀번호롤 다시 입력해 주세요">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>이름<span>*</span></p>
                                    <input type="text" name="name" placeholder="이름을 입력해 주세요" value="{{ $user -> name }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>생년월일<span>*</span></p>
                                    <input type="date" name="birth" placeholder="YYYY-MM-DD" value="{{ $user -> birth }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>전화번호<span>*</span></p>
                                    <input type="text" name="tel" placeholder="000-0000-0000" value="{{ $user -> tel }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>상점명<span>*</span></p>
                                    <input type="text" name="store_name" placeholder="상점명을 입력해 주세요" value="{{ $user -> store_name }}">
                                </div>
                            </div>
                            
                        </div>
                        <div class="checkout__input">
                            <p>소개글<span>*</span></p>
                            <input type="text" name="introduction" placeholder="상점을 소개해 주세요" value="{{ $user -> introduction }}">
                        </div>

                        <button class="site-btn text-white" type="submit">수정완료</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</secssion>
@endsection