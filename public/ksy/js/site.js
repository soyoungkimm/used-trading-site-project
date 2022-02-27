function make_preview_image(old_order, image_src) {
    // |로 나눔
    let image_arr = old_order.split("|");


    // 이미지 미리보기 생성
    let str ='';
    for (image of image_arr) {

        // 이미지 파일 이름 세팅
        let temp = image.split("_");
        let image_name = '';
        for (let i = 0; i < temp.length; i++) {
            if (i == 0) continue;
            image_name += temp[i];
        }


        // 이미지 preview 화면에 만들기
        str += '<li class="li">\n' + 
                        '<img class="li_image" src="' + image_src + image + '" alt="' + image_name + '"/>\n' +
                        '<span class="close_btn"><i class="fa fa-times-circle-o fa-2x" aria-hidden="true"></i></span>\n' +  
                        '<input type="hidden" class="file_name" value="' + image + '">\n' + 
                    '</li>\n';
    }
    $("#preview").append(str);


    // 이미지 개수 세팅
    $("#image_num").html(image_arr.length);
}



function make_tag(tags) {

    let tag_arr = tags.split(" ");

    for (tag of tag_arr) {
        // tag 화면에 만들기
        let str = '<span id="tag_content">' + tag + '<i id="tag_icon" class="fa fa-times-circle-o fa-lg"></i></span>';
        $("#tag_span").append(str);
    }

    // tag 적는 text 비우기
    $("#tag_text").val('');
}



function selectCategory(category_des, old_category_de_id, category_id) {

    let isNothing = true;
    let select_value = category_id;

    let str = '<ul class="category_ul">\n';

    if (select_value != 0) {
        
        category_des.forEach((element, index, array) => {
            if (select_value == element.category_id) {
                isNothing = false;
                if(old_category_de_id != '' && old_category_de_id == element.id) {
                    str += '<li><button type="button" value="' + element.id + '" class="category_de_select selected">' + element.name + '</button></li>\n';
                }
                else {
                    str += '<li><button type="button" value="' + element.id + '" class="category_de_select">' + element.name + '</button></li>\n';
                }
            }
        });
    }
    str += '</ul>\n';

    $("#category_de_select_area").empty();
    $("#category_de_de_select_area").empty();
    if(!isNothing) $("#category_de_select_area").html(str);

}


function selectCategoryDe(category_de_des, old_category_de_de_id, category_de_id) {

    let isNothing = true;
    let select_value = category_de_id;

    let str = '<ul class="category_ul">\n';

    if (select_value != 0) {
        
        category_de_des.forEach((element, index, array) => {
            if (select_value == element.category_de_id) {
                isNothing = false;
                if(old_category_de_de_id != '' && old_category_de_de_id == element.id) {
                    str += '<li><button type="button" value="' + element.id + '" class="category_de_de_select selected">' + element.name + '</button></li>\n';
                }
                else {
                    str += '<li><button type="button" value="' + element.id + '" class="category_de_de_select">' + element.name + '</button></li>\n';
                }
            }
        });
    }
    str += '</ul>\n';


    $("#category_de_de_select_area").empty();
    if(!isNothing) $("#category_de_de_select_area").html(str);
}



 // 카테고리 부분 클릭시 실행
$(document).on("click", ".category_select", function(e){

    // 값 변경
    $("#category_id").val(e.target.value);


    // 고른 카테고리에 카테고리 상세가 있나 확인
    let isExist = false;
    category_des.forEach((element, index, array) => {
        if($("#category_id").val() == element.category_id) {
            isExist = true;
        }
    });


    if(isExist) { // 카테고리 상세 있음
        $('#category_de_id').val('0');
    }
    else { // 없음
        $('#category_de_id').val('');
    }
    $('#category_de_de_id').val('');
    

    // 배경 색 변경
    $('.category_select').removeClass("selected");
    $(e.target).addClass("selected");

    selectCategory(category_des, old_category_de_id, e.target.value);
});
$(document).on("click", ".category_de_select", function(e){

    // 값 변경
    $('#category_de_id').val(e.target.value);


    // 고른 카테고리 상세에 카테고리 상세 상세가 있나 확인
    let isExist = false;
    category_de_des.forEach((element, index, array) => {
        if($("#category_de_id").val() == element.category_de_id) {
            isExist = true;
        }
    });


    if(isExist) { // 카테고리 상세 상세 있음
        $('#category_de_de_id').val('0');
    }
    else { // 없음
        $('#category_de_de_id').val('');
    }


    // 배경 색 변경
    $('.category_de_select').removeClass("selected");
    $(e.target).addClass("selected");

    selectCategoryDe(category_de_des, old_category_de_de_id, e.target.value);
});
$(document).on("click", ".category_de_de_select", function(e){
    // 값 변경
    $('#category_de_de_id').val(e.target.value);

    // 배경 색 변경
    $('.category_de_de_select').removeClass("selected");
    $(e.target).addClass("selected");
});




$('#tag_text').focus (function () {
    $('#tag_area')
        .css('outline', '5px solid rgb(177, 177, 177, 0.3)')
        .css('border', '1px solid rgb(180, 180, 180)');
});
$('#tag_text').blur (function () {
    $('#tag_area')
        .css('outline', 'none')
        .css('border', '1px solid rgb(214, 214, 214)');
});


$('#tag_area').click (function () {
    $('#tag_text').focus();
});



$(document).on("click", ".juso", function(e){

    // area에 값 세팅
    let select_value = e.target.innerHTML;
    $('#area').val(select_value);

    // modal창 닫기
    let modal = document.getElementById("adress_find_modal");
    bye_modal(modal);

    // 다시 처음 상태로 세팅
    $('#adress_result').empty();
    $('#adress_result').html('');
});


$('.fa-search').click (function() {
    find_adress();
});
$('#find_adress_text').keyup (function(e) {
    // 엔터키 누르면 실행
    if (e.keyCode == 13 || e.which == 13) find_adress();
})


function find_adress() {

    let search = $("#find_adress_text").val();
    let search_temp = search.replace(/ /g,"");

    // 값이 없거나 공백을 입력했으면
    if (search == '' || search_temp == '') {
        alert('주소를 입력하세요');
        $("#find_adress_text").val('');
        return;
    }


    // 찾기
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "/goods/find_adress",
        type: "POST",
        dataType: 'text',
        data: {
            search : search
        },
        success : function(data) {

            data = JSON.parse(data);

            let str = '';
            if (data == '') {
                str += '<span>결과없음</span>';
            }
            else {
                str += '<ul>\n'
                    for (adress of data){
                        str += '<li class="juso">' + adress.juso + '</li>\n'
                    } 
                str += '</ul>\n';
            }

            // 결과 화면에 띄우기
            $('#adress_result').empty();
            $('#adress_result').html(str);
        },
        error: function(request,status,error){ 
            alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
            console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
        }
    });

    
}


// 주소 찾기 modal
$('#adress_btn').click( function(e){

    // modal 과련 노드들 가져오기
    let modal = document.getElementById("adress_find_modal");
    let adress_area = document.getElementById("adress_area");

    modal.style.display = "block";
    let span = document.getElementsByClassName("close_adress_modal")[0];

    span.onclick = function() { 
        bye_modal(modal);
    }
});





// tag 생성
$("#tag_text").keyup(function (e) {
    // 엔터키나 스페이스바 누르면 실행
    if ((e.keyCode == 13 || e.which == 13) || (e.keyCode == 32 || e.which == 32)) {

        // tag 공백제거
        let tag_text_value = $('#tag_text').val().replace(/ /g,"");
    
        // tag 안에 내용이 없으면 retrun 
        if (tag_text_value == '') {
            alert('태그를 입력하세요');
            $("#tag_text").val('');
            return;
        }

        //tag 개수가 5개 넘으면 return
        let tag_node = document.getElementById("tag");
        let tag_arr = $(tag_node).val().split(" ");
        if (tag_arr.length >= 5) {
            alert('태그는 5개 이상 작성할 수 없습니다.');
            $("#tag_text").val('');
            return;
        }

        // tag 안에 같은 내용있으면 return
        for (let tag of tag_arr) {
            if (tag == tag_text_value) {
                $("#tag_text").val('');
                return;
            }
        }

        // tag 화면에 만들기
        let str = '<span id="tag_content">' + tag_text_value + '<i id="tag_icon" class="fa fa-times-circle-o fa-lg"></i></span>';
        $("#tag_span").append(str);

        // tag값 세팅
        let old_tag_val = $("#tag").val();
        if (old_tag_val != '') {
            $("#tag").val(old_tag_val + ' ' + tag_text_value);
        }
        else {
            $("#tag").val(tag_text_value);
        }

        // tag 적는 text 비우기
        $("#tag_text").val('');
    }
});

// tag 삭제
$(document).on("click", "#tag_icon", function(e){

    // tag 값 다시 세팅
    let tag_arr = $('#tag').val().split(" ");
    let tag_val = $(e.target).parent().text();
    let tag_str = '';
    for (let i = 0; i < tag_arr.length; i++) {
        if (tag_arr[i] == tag_val) continue; 
        tag_str += tag_arr[i] + ' ';
    }
    tag_str = tag_str.trim();
    $("#tag").val(tag_str);

    // tag 화면에서 삭제
    $(e.target).parent().remove();
});





$("#title").keyup(function (e) {
    title_check_key_num(e);
});
$("#title").keydown(function (e) {
    title_check_key_num(e);
});
function title_check_key_num(e) {
    if (e.target.value.length > 50) {
        alert('제목은 50자를 넘길 수 없습니다.');
        let str = e.target.value.substr(0, 50);
        $(e.target).val(str);
        $("#title_num").html('50');
        return;
    }
    $("#title_num").html(e.target.value.length);
}


$("#content").keyup(function (e) {
    content_check_key_num(e);
});
$("#content").keydown(function (e) {
    content_check_key_num(e);
});
function content_check_key_num(e) {
    if (e.target.value.length > 3000) {
        alert('제목은 3000자를 넘길 수 없습니다.');
        let str = e.target.value.substr(0, 3000);
        $(e.target).val(str);
        $("#content_num").html('3000');
        return;
    }
    $("#content_num").html(e.target.value.length);
}


$("#number").keyup(function (e) {
    if(isNaN(e.target.value)) {
        alert('숫자만 입력하세요');
        $(e.target).val('1');
    }
});
$("#number").change(function (e) {
    let number = e.target.value.replace(/ /g,"");
    if (number == '' || number == 0) {
        alert('1 이상의 수를 입력하세요');
        $(e.target).val('1');
    }
});


function numberWithCommas(x) {
    let price = parseInt(x.replace(/,/g,""));
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}
$("#price").keyup(function (e) {
    if ($(e.target).val() == '') return;
    let price = e.target.value.replace(/ /g,""); // 공백제거
    
    // 스페이스바 누르거나 문자 입력했을 때
    let vals = price.split(',');
    for(let val of vals) {
        if(isNaN(val) || (e.keyCode == 32 || e.which == 32)) {
            alert('숫자만 입력하세요');
            $(e.target).val('100');
            return;
        }
    }

    e.target.value = numberWithCommas(e.target.value);
});
$("#price").change(function (e) {
    // 공백제거
    let price = e.target.value.replace(/ /g,"");

    // 아무것도 입력하지 않으면
    if (price == '') {
        alert('가격을 입력하세요');
        $(e.target).val('100');
        return;
    }

    // 100원 이상 입력하지 않으면
    price = parseInt(price.replace(/,/g,"")); // 콤마 제거
    if (price < 100) {
        alert('100원 이상 입력하세요');
        $(e.target).val('100');
        return;
    }
});


$("#all_btn").click (function() {
    $('#area').val('전국');
});


// 이미지 클릭시 - 원본 이미지 확인
$(document).on("click", ".li", function(e){
    
    var modal = document.getElementById("myModal");

    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    modal.style.display = "block";
    modalImg.src = $(this).children("img").attr("src");
    captionText.innerHTML = $(this).children("img").attr("alt");

    var span = document.getElementsByClassName("close_modal")[0];

    span.onclick = function() { 
        bye_modal(modal);
    }
});


function bye_modal(modal){
    modal.style.display = "none";
}


// 이미지 오른쪽 상단 x버튼(삭제 버튼) 클릭시
$(document).on("click", ".close_btn", function(e){

    e.stopPropagation();
    e.preventDefault();

    // 이미지 미리보기 삭제
    $(e.target).parent().parent().remove();

    // 이미지 삭제
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "/goods/delete_image",
        type: "POST",
        dataType: 'text',
        data: {
            file_name : $(e.target).parent().next().val()
        },
        success : function(data) {

        },
        error: function(request,status,error){ 
            alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
            console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
        }
    });


    // 이미지 개수 -1
    let image_num = parseInt(document.getElementById("image_num").innerHTML);
    $("#image_num").html(image_num - 1);
}); 


// 이미지 정렬 가능하게 함
$(".sortable").sortable();
$(".sortable").disableSelection();


// form submit
$(".submit_btn").click (function(e) {
    
    // 이미지 순서값 세팅
    let _order = '';
    $(".li").each(function( index, element ) {
        _order += $(this).children(".file_name").val() + '|';
    })
    _order = _order.slice(0, -1);
    $("#order").val(_order);


    // 가격에 있는 콤마 없애기
    let price_val = $('#price').val().replace(/,/g, "");
    $('#price').val(price_val);

    // form submit
    $("form").submit();
});


// 이미지 드래그 업로드
$('.content')
.on("dragover", dragOver)
.on("dragleave", dragLeave)
.on("drop", uploadFiles);

function dragOver(e) {
    e.stopPropagation();
    e.preventDefault();
    
    $(e.target).css({
        "background-color": "#fff",
        "outline-offset": "-30px",
        "outline": "2px dashed rgb(175, 212, 255)",
        "color" : "rgb(175, 212, 255)",
        "font-size" : "30pt"
    });
    
    let str = 'Drop';
    $(e.target).html(str);
}

function dragLeave(e) {
    e.stopPropagation();
    e.preventDefault();
    
    $(e.target).css({
        "background-color" : "rgb(175, 212, 255)",
        "outline-offset" : "-20px",
        "outline" : "2px dashed #fff",
        "color" : "#fff",
        "font-size" : "14pt"
    });

    let str = '이미지를 드래그하거나 클릭하세요';
    $(e.target).html(str);
}

function uploadFiles(e) {

    e.stopPropagation();
    e.preventDefault();
    dragLeave(e);

    e.dataTransfer = e.originalEvent.dataTransfer; //2
    let files = e.target.files || e.dataTransfer.files;

    // 파일이 이미지가 아니거나 이름에 | 들어있으면 return
    for (file of files) {
        let file_name = file.name; // 파일 이름 구하기
        let ext = file_name.substring(file_name.lastIndexOf(".")+1); // 확장자 구하기
        ext = ext.toLowerCase(); // 소문자로 변환하기
        if (ext != 'jpg' && ext != 'jpeg' && ext != 'png') {
            alert("이미지만 업로드 가능합니다");
            return;
        }
        if(file_name.indexOf('|') != -1) {
            alert("파일 이름에 \'|\' 기호가 들어있으면 안됩니다");
            return;
        }
    }

    readFiles(files);
    return;
}

$(".content").click(function (e) {
    $("#image").click();
});



$("#image").change(function (e) {
    
    var inputFile = $('#image');
    var files = inputFile[0].files;

    if(e.target.files.length > 6) {
        alert('파일의 최대 개수는 6개 입니다.');
        return;
    }

    uploadFiles(e);
});



function readFiles(e) {

    const formData = new FormData();

    if (e.length > 0) {
        for (var i = 0; i < e.length; i++) {
            formData.append('image[]', e[i]);
        }
    }

    // 이미지 서버에 업로드
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "/goods/upload",
        type: "POST",
        data: formData,
        dataType: 'text',
        cache:false,
        contentType: false,
        processData: false,
        // 성공
        success : function(result) {

            // json 파싱
            result = JSON.parse(result);

            // 이미지 미리보기 생성
            for(i = 0; i < e.length; i++){
                var str = "";
                var tmp = e[i];
                var src = URL.createObjectURL(tmp);
                str  += '<li class="li">\n' + 
                            '<img class="li_image" src="' + src + '" alt="' + tmp.name + '"/>\n' +
                            '<span class="close_btn"><i class="fa fa-times-circle-o fa-2x" aria-hidden="true"></i></span>\n' +  
                            '<input type="hidden" class="file_name" value="' + result[i] + '">\n' + 
                        '</li>\n';
                $("#preview").append(str);
            }
        },
        // 실패
        error: function(request,status,error){ 
            alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
            console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
        }
    });


    // 이미지 개수 + 1
    let image_num = parseInt(document.getElementById("image_num").innerHTML);
    $("#image_num").html(image_num + 1);
}
