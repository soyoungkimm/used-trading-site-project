@extends('layouts.siteLayout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<secssion class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4 style="text-align:center;">Register</h4>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-6" >
                    <div class="row justify-content-center">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="row justify-content-center">
                        <sapan style="font-size:40pt; font-weigth:bold;">Welcome!</span>
                    </div>
                    <br>
                    <div class="row justify-content-center text-center">
                        <sapan style="font-weigth:bold;">회원가입이 완료되었습니다</span>
                        <br>
                        <sapan style="font-weigth:bold;">로그인 후 모든 서비스를 이용할 수 있습니다</span>
                    </div>
                    <br>
                    <div class="row justify-content-center">
                        <button class="site-btn text-white m-2" onclick="location.href='/'">메인페이지</button>
                        
                        <button class="site-btn text-white m-2" onclick="location.href='/users/login'">로그인</button>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</secssion>
@endsection