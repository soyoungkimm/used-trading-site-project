@extends('layouts.siteLayout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });


    function submitForm(){
        if(form1.idCheck.value == 0){
            $('#idMemo').empty();
            $('#idMemo').append("<p style='color:red'>ID 중복확인이 필요합니다</p>");
            alert("ID중복체크가 필요합니다");
            
        }
        // else if(form1.pwCheck.value == 0){
        //     $('#pwMemo').empty();
        //     $('#pwMemo').append("<p style='color:red'>4~12자리의 영문,숫자,(?!@$)조합만 가능합니다</p>");
        //     alert("비밀번호를 확인해주세요");
        
        // }
        else{
            form1.submit();
        }
    }

    $(function() {
        $("#inputUid").focusout(function(){
            var userId=$('#inputUid').val();
            var patttern_num=/(?=.*\d)(?=.*[a-zA-ZS]).{4,12}/;
            if(!patttern_num.test(userId)){
                $('#idMemo').empty();
                $('#idMemo').append("<p style='color:red'>공백없이 4~12자리의 영문과 숫자조합만 가능합니다</p>");
                return 0;
            }else{
                $.ajax({
                    method:"POST",
                    url:"/users/checkUid",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:{
                        "uid":userId
                    },
                    dataType:"text",
                    success: function(result){
                        //console.log(JSON.stringify(result));
                        //console.log(result);
                        if(result == 0){
                            form1.idCheck.value="1"
                            //alert("사용가능한 ID입니다");
                            $('#idMemo').empty();
                            $('#idMemo').append("<p style='color:blue'>사용가능한 ID입니다</p>");
                        }else{
                            form1.idCheck.value="0"
                            //alert("사용 불가능한 ID입니다");
                            $('#idMemo').empty();
                            $('#idMemo').append("<p style='color:red'>이미 사용중인 ID입니다</p>");
                        }
                    }
                });
            }
            
        });
        $("#inputPwd").focusout(function(){
            if($('#inputPwd').val() == $('#inputPwd2').val()){
                $('#pwMemo2').empty();
                $('#pwMemo2').append("<p style='color:blue'>동일한 비밀번호 입니다</p>");
                return 0;
            }else{
                form1.idCheck.value="0"
                $('#pwMemo2').empty();
                $('#pwMemo2').append("<p style='color:red'>비밀번호가 일치하지 않습니다</p>");
            }
        //     var userPw=$('#inputPwd').val();
        //     var patttern_num=/(?=.*\d)(?=.*[a-zA-ZS])(?=.*?[?!@$]).{4,12}/; 
        //     if(!patttern_num.test(userPw)){
        //         $('#pwMemo ').empty();
        //         $('#pwMemo ').append("<p style='color:red'>4~12자리의 영문,숫자,(?!@$)조합만 가능합니다</p>");
        //         return 0;
        //     }else{
        //         $('#pwMemo ').empty();
        //         $('#pwMemo ').append("<p style='color:blue'>사용가능한 형식입니다</p>");
        //     }
        });
        $("#inputPwd2").focusout(function(){

            if($('#inputPwd').val() == $('#inputPwd2').val()){
                $('#pwMemo2').empty();
                $('#pwMemo2').append("<p style='color:blue'>동일한 비밀번호 입니다</p>");
                return 0;
            }else{
                form1.idCheck.value="0"
                $('#pwMemo2').empty();
                $('#pwMemo2').append("<p style='color:red'>비밀번호가 일치하지 않습니다</p>");
            }
        });
    });

</script>
<secssion class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4 style="text-align:center;">Register</h4>
            <form name="form1" action="/users/store" method="POST" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="idCheck" value="0">
                <input type="hidden" name="pwCheck" value="0">
                <input type="hidden" name="pwCheck2" value="0">

                <div class="row" style="justify-content: center">
                    <div class="col-lg-8 col-md-6" >
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input mb-1" style="">
                                    <p>아이디<span>*</span></p>
                                        <input class="form-control" type="text" name="uid" id="inputUid" placeholder="아이디를 입력해 주세요">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3" id="idMemo"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input mb-1">
                                    <p>비밀번호<span>*</span></p>
                                    <input type="text" name="pwd" id="inputPwd" placeholder="비밀번호를 입력해 주세요">
                                </div>
                                <div class="mb-2" id="pwMemo" class="mb-3">2323</div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input mb-1">
                                    <p>비밀번호확인<span>*</span></p>
                                    <input type="text" name="pwd2" id="inputPwd2" placeholder="비밀번호롤 다시 입력해 주세요">
                                </div>
                                <div class="mb-2" id="pwMemo2" class="mb-3">2</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>이름<span>*</span></p>
                                    <input type="text" name="uname" placeholder="이름을 입력해 주세요">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>생년월일<span>*</span></p>
                                    <input type="date" name="birth" placeholder="YYYY-MM-DD">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>전화번호<span>*</span></p>
                                    <input type="text" name="tel" placeholder="000-0000-0000">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>상점명<span>*</span></p>
                                    <input type="text" name="store_name" placeholder="상점명을 입력해 주세요">
                                </div>
                            </div>
                            
                        </div>
                        <div class="checkout__input">
                            <p>소개글<span>*</span></p>
                            <input type="text" name="intro" placeholder="상점을 소개해 주세요">
                        </div>

                        <a class="site-btn text-white" onClick="submitForm();">가입완료</a>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</secssion>
@endsection