@extends('layouts.siteLayout')

@section('content')
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $(function() {
        $("#deleteUser").click(function(id){
            var link = "users/delete".id
            if(arrUsers.length != 0){
                $.ajax({
                url:link
                type:"DELETE",
                data:{
                    'reqeust':id
                },
                success: function(result){
                    console.log(result);
                    location.reload();
                }
            });
           
        });
        
    });
</script>
<secssion class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4 style="text-align:center;">User Detail</h4>

            <div class="row" style="justify-content: center">
                <div class="col-lg-8 col-md-6" >
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkout__input mb-2" >
                                <p>아이디</p>
                                    <div class="form-control">{{ $user -> uid }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkout__input mb-3">
                                <p>비밀번호</p>
                                <div class="form-control"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>이름</p>
                                <div class="form-control">{{ $user -> name }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>생년월일</p>
                                <div class="form-control">{{ $user -> birth }}</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>전화번호</p>
                                <div class="form-control">{{ $user -> tel }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>상점명</p>
                                <div class="form-control">{{ $user -> store_name }}</div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="checkout__input">
                        <p>소개글</p>
                        <div class="form-control">{{ $user -> introduction }}</div>
                    </div>
                    <button class="site-btn text-white" onClick="location.href='/users/edit'">정보수정</button>
                    <form action="/users/delete" method="post" style="display:flex">
                        @method('DELETE')
                        @csrf
                        <button class="site-btn text-white mt-5" type="delete">회원 탈퇴</a>
                    </form>

                </div>
                
            </div>
        </div>
    </div>
</secssion>
@endsection