@extends('layouts.siteLayout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    a:hover{color:black;}
    a{ color:black;}
</style>
<script>
    $(function() {
        

        $("#inputUid").focusout(function(){
            var userId=$('#inputUid').val();
            var patttern_num=/[0-9a-zA-Z]{4,12}$/;
            if(!patttern_num.test(userId)){
                $('#idMemo').empty();
                $('#idMemo').append("<p style='color:red'>공백없이 4~12자리의 영문과 숫자조합만 가능합니다</p>");
                return 0;
            }else{
                $.ajax({
                    method:"POST",
                    url:"/users/checkUid",
                    data:{
                        "_ token": $ ( 'meta [name = "csrftoken"]'). attr ( 'content'),
                        "uid":userId
                    },
                    dataType:"text",
                    success: function(result){
                        console.log(JSON.stringify(result));
                        console.log(result);
                        if(result == 0){
                            form1.idCheck.value="1"
                            alert("사용가능한 ID입니다");
                            $('#idMemo').empty();
                            $('#idMemo').append("<p style='color:blue'>사용가능한 ID입니다</p>");
                        }else{
                            form1.idCheck.value="0"
                            alert("사용 불가능한 ID입니다");
                            $('#idMemo').empty();
                            $('#idMemo').append("<p style='color:red'>이미 사용중인 ID입니다</p>");
                        }
                    }
                });
            }
            
        });
    });

</script>
<secssion class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4 style="text-align:center;">LOGIN</h4>
            <form name="form1" action="/users/login" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-6 " >
                        <div class="row justify-content-center" >
                            <div class="col-lg-6">
                                <div class="checkout__input my-4" style="">
                                        <input class="form-control" type="text" name="uid" id="inputUid" placeholder="아이디">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="checkout__input mb-4">
                                    <input type="password" name="pwd" id="inputPwd" placeholder="비밀번호">
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center ">
                            <div class="col-lg-6">
                                <button class="site-btn text-white justify-content-center mb-2" style="width:100% ">Login</button>
                                <a href="#" class="mr-3" style="">아이디/비밀번호 찾기</a>
                                <a href="/users/register" class="" >회원가입</a>
                            </div>
                        </div>
                    </div>    
                </div>
            </form>
        </div>
    </div>
</secssion>
@endsection