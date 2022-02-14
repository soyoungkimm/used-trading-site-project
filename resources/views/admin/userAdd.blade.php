@include('admin.header')
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    function submitForm(){
        if(form1.idCheck.value == 1){
            form1.submit();
        }else{
            alert("ID중복체크가 필요합니다");
        }
    }
    
    $(function() {
        $("#inputUid").keydown(function(){
            form1.idCheck.value = "0";
        });

        $("#id_check").click(function(){
            var userId=$('#inputUid').val();

            console.log("uid="+userId);
            $.ajax({
                method:"POST",
                url:"/admin/users/checkUid",
                data:{
                    //"_ token": $ ( 'meta [name = "csrftoken"]'). attr ( 'content'),
                    "uid":userId
                },
                dataType:"text",
                success: function(result){
                    console.log(JSON.stringify(result));
                    console.log(result);
                    if(result == 0){
                        form1.idCheck.value="1"
                        alert("사용가능한 ID입니다");
                    }else{
                        form1.idCheck.value="0"
                        alert("사용 불가능한 ID입니다");
                    }
                }
            });
        });
    });
</script>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Users2</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Add User
                            </div>
                            <form name="form1" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <input type="hidden" name="idCheck" value="0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 ">
                                                        <div class="input-group" style="text-align:center;">
                                                            <input class="form-control" id="inputUid" type="text" name="uid" placeholder="ID" value="" onKeyDown="idChanged();" style="height: calc(3.5rem + 2px);" />
                                                            <a class="btn btn-primary btn-block" id="id_check" style="padding-top:15px;" >중복체크</a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>  
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputPwd" type="text" name="pwd" placeholder="pwd" value="" />
                                                        <label for="inputPwd">PW</label>
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputName" type="text" name="name" placeholder="example@abc.com" value=""/>
                                                        <label for="inputName">이름</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputBirth" type="date" name="birth"placeholder="" value=""/>
                                                        <label for="inputBirth">생일</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputTel" type="tel" name="tel" placeholder="tel" value=""/>
                                                        <label for="inputTel">전화번호</label>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputOpen" type="date" name="open_date" placeholder="" value=""/>
                                                        <label for="inputOpen">오픈일</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputStore" type="store" name="store_name" placeholder="상점명" value=""/>
                                                        <label for="inputStore">상점명</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputVisit" type="text" name="store_visit" placeholder="상점방문" value=""/>
                                                        <label for="inputVisit">상점방문횟수</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputDelivery" type="text" name="sale_num" placeholder="상품판매" value=""/>
                                                        <label for="inputDelivery">상품판매횟수</label>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputFollower" name="follower" type="text" placeholder="팔로워" value="" />
                                                        <label for="inputFollower">팔로워</label>
                                                    </div>
                                                </div> 
                                                <div class="col-md-3">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputFollow" name="following" type="text" placeholder="팔로우" value=""/>
                                                        <label for="inputFollow">팔로우</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputProductNum" name="good_num" type="text" placeholder="상품수" value=""/>
                                                        <label for="inputProductNum">상품개수</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputDelivery" type="text" name="delivery_num" placeholder="택배" value=""/>
                                                        <label for="inputDelivery">택배발송</label>
                                                    </div>
                                                </div> 
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <label for="inputIntro">소개글</label>
                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control" id="inputIntro" name="introduction" placeholder="소개글" ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                <label >상점 사진</label>
                                                    <div class="mb-3">
                                                        <div style="width: 100%;">
                                                            <div style="width:100%;height:200px;object-fit:scale-down;"></div>
                                                        </div>
                                                        <input class="form-control" id="inputImg" type="file" name="image" placeholder="pwd" value=""/>
                                                        <label for="inputImg" ></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <a class="btn btn-primary" style="margin:12px" onClick="submitForm();">save </a>   
                            </div>                            
                        </form>
                    </div>
                </main>
                
@include('admin.footer')