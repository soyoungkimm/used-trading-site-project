//탭바 변경
$(document).on('click','.tab-group .tab',function(){
    const num1 = $(".tab-group .tab").index($(this));
    const num2 = $(".tab-group .TabTrue").index();

    $(".tab-group .tab:eq("+num2+")").removeClass("TabTrue");
    $(".content .tab-content:eq("+num2+")").removeClass("Block");
    $(".tab-group .tab:eq("+num2+")").addClass("TabFalse");
    $(".content .tab-content:eq("+num2+")").addClass("None");


    $(".tab-group .tab:eq("+num1+")").removeClass("TabFalse");
    $(".content .tab-content:eq("+num1+")").removeClass("None");
    $(".tab-group .tab:eq("+num1+")").addClass("TabTrue");
    $(".content .tab-content:eq("+num1+")").addClass("Block");

    $(".content ")
});

//찜상품 선택
$(document).on('click','.heart-box .noCheck', function(){
    const num = $(".heart-box .checkBox ").index($(this));

    $(".heart-box .checkBox:eq("+num+")").removeClass("noCheck");
    $(".heart-box .checkBox:eq("+num+")").addClass("checked");

    return false;
});

//찜상품 선택해제
$(document).on('click','.heart-box .checked', function(){
    const num = $(".heart-box .checkBox ").index($(this));

    $(".heart-box .checkBox:eq("+num+")").removeClass("checked");
    $(".heart-box .checkBox:eq("+num+")").addClass("noCheck");

    return false;
});

//찜상품 전체 선택
$(document).on('click','.heart-box .notAllChekced ', function(){
    $(".heart-box .allCheckBox").removeClass("notAllChekced");
    $(".heart-box .allCheckBox").addClass("allChecked");
    $(".heart-box .checkBox").removeClass("noCheck");
    $(".heart-box .checkBox").addClass("checked");

    return false;
});

//찜상품 전체 선택해제
$(document).on('click','.heart-box .allChecked ', function(){
    $(".heart-box .allCheckBox").removeClass("allChecked");
    $(".heart-box .allCheckBox").addClass("notAllChekced");
    $(".heart-box .checkBox").removeClass("checked");
    $(".heart-box .checkBox").addClass("noCheck");

    return false;
});


function follows(num,str){

    //팔로우->언팔
    if($(str+":eq("+num+")").hasClass("following")===true){

        let store_id = $(str+":eq("+num+")").attr('data-storeid');

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/follows/delete',
            type: "DELETE",
            dataType: 'text',
            data: {
                store_id : store_id
            },
            success : function() {
                //팔로우 디자인으로 변경
                $(str+":eq("+num+")").removeClass('following');
                $(str+":eq("+num+")").addClass('follow');
                $(str+":eq("+num+") i").removeClass('fa-check');
                $(str+":eq("+num+") i").addClass('fa-user-plus');
                $(str+":eq("+num+") i").text("팔로우");
                
                //화면의 팔로잉 수 감소
                let old_follow_num = parseInt($("#follow-num").text());
                $(".follow-num").text(old_follow_num - 1);

            },
            error: function(request,status,error){ 
                alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
                console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
            }
        });

    //언팔->팔로우     
    }else{
        let store_id = $(str+":eq("+num+")").attr('data-storeid');


        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/follows',
            type: "POST",
            dataType: 'text',
            data: {
                store_id : store_id
            },
            success : function() {

                //팔로잉 디자인으로 변경
                $(str+":eq("+num+")").removeClass('follow');
                $(str+":eq("+num+")").addClass('following');
                $(str+":eq("+num+") i").removeClass('fa-user-plus');
                $(str+":eq("+num+") i").addClass('fa-check');
                $(str+":eq("+num+") i").text("팔로잉");

                //화면의 팔로잉 수 증가
                let old_follow_num = parseInt($("#follow-num").text());
                $(".follow-num").text(old_follow_num + 1);

            },
            error: function(request,status,error){ 
                alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
                console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
            }
        }); 
    }
}

//팔로잉 탭
$(document).on('click','.fo-box>.fo-check',function(){
    const num = $(".fo-box .fo-check ").index($(this));
    let str = ".fo-box .fo-check";
    follows(num,str);
});

//팔로워 탭
$(document).on('click','.fwr-box>.fwr-check',function(){

    const num = $(".fwr-box .fwr-check ").index($(this));
    let str = ".fwr-box .fwr-check";
    follows(num,str);
});


