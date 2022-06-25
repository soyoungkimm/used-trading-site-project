// datepicker 
$(function() {
    $( "#datepicker" ).datepicker(); 
});

// 삭제 버튼 클릭시
$("#delete_button").click(function () {
    let form = document.delete_form;
    let result = confirm('정말로 삭제하시겠습니까?');
    if (result) {
        form.submit();
    }
});



/* admin dashboard 날씨 api 시작*/
// 날씨 api - fontawesome 아이콘
var weatherIcon = {
    '01' : 'fas fa-sun',
    '02' : 'fas fa-cloud-sun',
    '03' : 'fas fa-cloud',
    '04' : 'fas fa-cloud-meatball',
    '09' : 'fas fa-cloud-sun-rain',
    '10' : 'fas fa-cloud-showers-heavy',
    '11' : 'fas fa-poo-storm',
    '13' : 'far fa-snowflake',
    '50' : 'fas fa-smog'
};

// 날씨 api - 서울
var apiURI = "http://api.openweathermap.org/data/2.5/weather?q="+'seoul'+"&appid="+"23ad0a644b974fb4ce5d4faad2afadab";
$.ajax({
    url: apiURI,
    dataType: "json",
    type: "GET",
    async: "false",
    success: function(resp) {

        var $Icon = (resp.weather[0].icon).substr(0,2);
        var $weather_description = resp.weather[0].main;
        var $Temp = Math.floor(resp.main.temp- 273.15) + 'º';
        var $humidity = '습도&nbsp;&nbsp;&nbsp;&nbsp;' + resp.main.humidity+ ' %';
        var $wind = '바람&nbsp;&nbsp;&nbsp;&nbsp;' +resp.wind.speed + ' m/s';
        var $city = '서울';
        var $cloud = '구름&nbsp;&nbsp;&nbsp;&nbsp;' + resp.clouds.all +"%";
        var $temp_min = '최저 온도&nbsp;&nbsp;&nbsp;&nbsp;' + Math.floor(resp.main.temp_min- 273.15) + 'º';
        var $temp_max = '최고 온도&nbsp;&nbsp;&nbsp;&nbsp;' + Math.floor(resp.main.temp_max- 273.15) + 'º';
        

        $('.weather_icon').append('<i class="' + weatherIcon[$Icon] +' fa-5x real_weather_icon"></i>');
        $('.weather_description').prepend($weather_description);
        $('.current_temp').prepend($Temp);
        $('.humidity').prepend($humidity);
        $('.wind').prepend($wind);
        $('.city').append($city);
        $('.cloud').append($cloud);
        $('.temp_min').append($temp_min);
        $('.temp_max').append($temp_max);               
    }
})



// 날씨 api - 경기도
var apiURI = "http://api.openweathermap.org/data/2.5/weather?q="+'Gyeonggi-do'+"&appid="+"23ad0a644b974fb4ce5d4faad2afadab";
$.ajax({
    url: apiURI,
    dataType: "json",
    type: "GET",
    async: "false",
    success: function(resp) {

        var $g_Icon = (resp.weather[0].icon).substr(0,2);
        var $g_weather_description = resp.weather[0].main;
        var $g_Temp = Math.floor(resp.main.temp- 273.15) + 'º';
        var $g_humidity = '습도&nbsp;&nbsp;&nbsp;&nbsp;' + resp.main.humidity+ ' %';
        var $g_wind = '바람&nbsp;&nbsp;&nbsp;&nbsp;' +resp.wind.speed + ' m/s';
        var $g_city = '경기도';
        var $g_cloud = '구름&nbsp;&nbsp;&nbsp;&nbsp;' + resp.clouds.all +"%";
        var $g_temp_min = '최저 온도&nbsp;&nbsp;&nbsp;&nbsp;' + Math.floor(resp.main.temp_min- 273.15) + 'º';
        var $g_temp_max = '최고 온도&nbsp;&nbsp;&nbsp;&nbsp;' + Math.floor(resp.main.temp_max- 273.15) + 'º';
        

        $('.g_weather_icon').append('<i class="' + weatherIcon[$g_Icon] +' fa-5x real_weather_icon"></i>');
        $('.g_weather_description').prepend($g_weather_description);
        $('.g_current_temp').prepend($g_Temp);
        $('.g_humidity').prepend($g_humidity);
        $('.g_wind').prepend($g_wind);
        $('.g_city').append($g_city);
        $('.g_cloud').append($g_cloud);
        $('.g_temp_min').append($g_temp_min);
        $('.g_temp_max').append($g_temp_max);   
    }
})
/* admin dashboard 날씨 api 끝*/




/* admin reviews 별점 js 코드 시작 */
function change_star(star) {

    let arr = set_star(star); // me.value
    $('#star1').attr('class', arr['star1']);
    $('#star2').attr('class', arr['star2']);
    $('#star3').attr('class', arr['star3']);
    $('#star4').attr('class', arr['star4']);
    $('#star5').attr('class', arr['star5']);

    $('#star_num').empty();
    $('#star_num').html('(' + star + ')');
}

function list_set_star(star, tag_id) {
    
    console.log('함수 실행');
    let arr = set_star(star);
    let str =  '<i class="' + arr['star1'] + '" id="star1"></i>\n' + 
            '<i class="' + arr['star2'] + '" id="star2"></i>\n' +
            '<i class="' + arr['star3'] + '" id="star3"></i>\n' +
            '<i class="' + arr['star4'] + '" id="star4"></i>\n' +
            '<i class="' + arr['star5'] + '" id="star5"></i>\n' +
            '&nbsp;&nbsp;<span id="star_num">(' + star + ')</span>\n';

    $('#' + tag_id).html(str);
}

function set_star(val) {

    let arr = new Array();
    let empty_star = 'far fa-star fa-lg';
    let half_star = 'fas fa-star-half-alt fa-lg';
    let full_star = 'fas fa-star fa-lg';
    
    if (val == 0) {
        arr['star1'] = empty_star;
        arr['star2'] = empty_star;
        arr['star3'] = empty_star;
        arr['star4'] = empty_star;
        arr['star5'] = empty_star;
    } 
    else if (val == 1) {
        arr['star1'] = half_star;
        arr['star2'] = empty_star;
        arr['star3'] = empty_star;
        arr['star4'] = empty_star;
        arr['star5'] = empty_star;
    } 
    else if (val == 2) {
        arr['star1'] = full_star;
        arr['star2'] = empty_star;
        arr['star3'] = empty_star;
        arr['star4'] = empty_star;
        arr['star5'] = empty_star;
    } 
    else if (val == 3) {
        arr['star1'] = full_star;
        arr['star2'] = half_star;
        arr['star3'] = empty_star;
        arr['star4'] = empty_star;
        arr['star5'] = empty_star;
    } 
    else if (val == 4) {
        arr['star1'] = full_star;
        arr['star2'] = full_star;
        arr['star3'] = empty_star;
        arr['star4'] = empty_star;
        arr['star5'] = empty_star;
    } 
    else if (val == 5) {
        arr['star1'] = full_star;
        arr['star2'] = full_star;
        arr['star3'] = half_star;
        arr['star4'] = empty_star;
        arr['star5'] = empty_star;
    } 
    else if (val == 6) {
        arr['star1'] = full_star;
        arr['star2'] = full_star;
        arr['star3'] = full_star;
        arr['star4'] = empty_star;
        arr['star5'] = empty_star;
    } 
    else if (val == 7) {
        arr['star1'] = full_star;
        arr['star2'] = full_star;
        arr['star3'] = full_star;
        arr['star4'] = half_star;
        arr['star5'] = empty_star;
    } 
    else if (val == 8) {
        arr['star1'] = full_star;
        arr['star2'] = full_star;
        arr['star3'] = full_star;
        arr['star4'] = full_star;
        arr['star5'] = empty_star;
    } 
    else if (val == 9) {
        arr['star1'] = full_star;
        arr['star2'] = full_star;
        arr['star3'] = full_star;
        arr['star4'] = full_star;
        arr['star5'] = half_star;
    }
    else if (val == 10) {
        arr['star1'] = full_star;
        arr['star2'] = full_star;
        arr['star3'] = full_star;
        arr['star4'] = full_star;
        arr['star5'] = full_star;
    }

    return arr;
}
/* admin reviews 별점 js 코드 끝 */



/* admin dash board to-do-list js 코드 시작*/

// "닫기" 버튼을 만들고 각 목록 항목에 추가
var myNodelist = document.getElementsByClassName("td_li");
for (var i = 0; i < myNodelist.length; i++) {
    var span = document.createElement("span");
    var txt = document.createTextNode("\u00D7");
    span.className = "close";
    span.appendChild(txt);
    myNodelist[i].appendChild(span);
}



// 닫기 버튼을 클릭하여 현재 목록 항목을 숨김
$(document).on("click", '.close', function(e) {
    // 상위 이벤트 동작하지 않게 하기
    e.stopImmediatePropagation();

    var div = this.parentElement;
    div.style.display = "none";
    let url = "/admin/todo_lists/"+$(e.target).parent().next().val();

    // to_do_list 테이블 state 컬럼 값 변경 
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        type: "DELETE",
        data: {
            id : $(e.target).parent().next().val()
        },
        // 성공
        success : function() {
            
        },
        // 실패
        error: function(request,status,error){ 
            alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
            console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
        }
    });
});
    



// 목록 항목을 클릭할 때 "checked" 기호를 추가
$(document).on("click", ".td_li", function(e){
    
    e.target.classList.toggle('checked');

    // to_do_list 테이블 state 컬럼 값 변경 
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "/admin/todo_lists/"+$(e.target).next().val(),
        type: "PATCH",
        data: {
            _method : 'PATCH'
        },
        // 성공
        success : function(data) {
            
        },
        // 실패
        error: function(request,status,error){ 
          alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
          console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
        }
    });
});


$('.addBtn').click(function() {
    newElement();
});



// "추가" 버튼 클릭 시 새 목록 항목 생성
function newElement() {

    var li = document.createElement("li");
    li.className = "td_li";
    var inputValue = document.getElementById("td_Input").value;
    var text_value = document.createTextNode(inputValue);
    li.appendChild(text_value);
    if (inputValue === '') {
        alert("내용을 작성하세요");
        return;
    } else {
        document.getElementById("td_ul").appendChild(li);
    }
    document.getElementById("td_Input").value = "";

    var span = document.createElement("span");
    var txt = document.createTextNode("\u00D7");
    span.className = "close";
    span.appendChild(txt);
    li.appendChild(span);

    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
        var div = this.parentElement;
        div.style.display = "none";
        }
    }

    // to_do_list 테이블에 목록 추가 
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "/admin/todo_lists",
        type: "POST",
        data: {
            inputValue : inputValue
        },
        // 성공
        success : function(data) {
            // id값 value로 가진 input hidden 만들기
            var input = document.createElement("input");
            input.type = "hidden";
            input.value = data;
            li.after(input);
        },
        // 실패
        error: function(request,status,error){ 
          alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
          console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
        }
    });

}
/* admin dash board to-do-list js 코드 끝*/


/*admin dashboard chart 코드 시작*/
function make_chart(labels, chart_vals, categorys) {

    // 배열 세팅
    var category_names = [];
    for(let i = 0; i < categorys.length; i++) {
        category_names.push(categorys[i].category_name);
    }
    var goods_counts = [];
    for(let i = 0; i < categorys.length; i++) {
        goods_counts.push(categorys[i].goods_count);
    }

    // dashboard 월별 거래량 차트 시작
    var ctx = document.getElementById('myChart');
    
    var config = {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '거래 횟수',
                backgroundColor:  'rgba(255, 99, 132, 0.2)',
                borderColor:  'rgba(255, 99, 132, 1)',
                fill: true,
                data: chart_vals,
            }]
        },
        options: {
            maintainAspectRatio: false,
            title: {
                text: 'Chart.js Time Scale'
            },
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        beginAtZero: true
                    }
                }]
            },
        }
    };
    //차트 그리기
    var myChart = new Chart(ctx, config);
    $('#trans_num_chart').append(' (현재 달 ~ 12달 전)');
    // dashboard 월별 거래량 차트 끝




    // dashboard 카테고리 비율 차트 시작
    var c_ctx = document.getElementById('category_chart');
    
    var c_config = {
        type: 'doughnut',
        data: {
            labels: category_names,
            datasets: [{
                
                backgroundColor: [
                    //색상
                    '#93DAFF',
                    '#ACF3FF',
                    '#AFDDFA',
                    '#E1F6FA',
                    '#1EDDFF',
                    '#00C3FF',
                    '#00F5FF',
                    '#B4C3FF',
                    '#82B3ED',
                    '#1E96FF',
                    '#646EFF',
                    '#1E82CD',
                    '#C8C8FF',
                    '#9282CD',
                    '#6464CD',
                    '#9696FF',
                    '#C8FAC8',
                    '#9EF048',
                    '#93FB93',
                    '#82EB5A',
                    '#22D6B2',
                    '#3BE0CB',
                    '#7DBCBE',
                    '#1E821E',
                    '#46AA46',
                ],
                borderWidth: 1,//경계선 굵기
                fill: false,
                data: goods_counts,
            }]
        },
        options: {
            maintainAspectRatio: false,
            title: {
                text: 'Chart.js Time Scale'
            },
            xAxes: [{
                gridLines: {
                    display:false
                }
            }],
            yAxes: [{
                gridLines: {
                    display:false
                }   
            }]
        }
    };
    var category_chart = new Chart(c_ctx, c_config);
    // dashboard 카테고리 비율 차트 끝
}
/*admin dashboard chart 코드 끝*/



/* admin goods 카테고리 부분 시작 */
function selectCategory(category_des, old_category_de_id) {

    let isNothing = true;
    let category_select = document.getElementById("category_select"); 
    let select_value = category_select.options[category_select.selectedIndex].value;
    
    let str = '<select class="form-select @error("category_de_id") is-invalid @enderror" aria-label="Default select example" name="category_de_id" id="category_de_select">\n' + 
                '<option value="0" selected>카테고리_상세를 고르세요</option>\n';
    
    
    if (select_value != 0) {
        category_des.forEach((element, index, array) => {
            if (select_value == element.category_id) {
                isNothing = false;
                if(old_category_de_id != '' && old_category_de_id == element.id) {
                    str += '<option value="' + element.id + '" selected>[' + element.id + '] ' + element.name + '</option>\n';
                }
                else {
                    str += '<option value="' + element.id + '">[' + element.id + '] ' + element.name + '</option>\n';
                }
            }
        });
    }
    str += '</select>\n';

    $("#category_de_select_area").empty();
    $("#category_de_de_select_area").empty();
    if(!isNothing) $("#category_de_select_area").html(str);
    
}


function selectCategoryDe(category_de_des, old_category_de_de_id) {

    let isNothing = true;
    let category_de_select = document.getElementById("category_de_select"); 
    let select_value = category_de_select.options[category_de_select.selectedIndex].value;
    
    let str = '<select class="form-select @error("category_de_de_id") is-invalid @enderror" aria-label="Default select example" name="category_de_de_id" id="category_de_de_select">\n' + 
                '<option value="0" selected>카테고리_상세_상세를 고르세요</option>\n';
    
    
    if (select_value != 0) {
        category_de_des.forEach((element, index, array) => {
            if (select_value == element.category_de_id) {
                isNothing = false;
                if(old_category_de_de_id != '' && old_category_de_de_id == element.id) {
                    str += '<option value="' + element.id + '" selected>[' + element.id + '] ' + element.name + '</option>\n';
                }
                else {
                    str += '<option value="' + element.id + '">[' + element.id + '] ' + element.name + '</option>\n';
                }
            }
        });
    }
    str += '</select>\n';

    $("#category_de_de_select_area").empty();
    if(!isNothing) $("#category_de_de_select_area").html(str);
    
}


function readFiles(e) {
    
    // file 미리보기 지우기
    $('#file_name_alert_area').empty();

    // file 미리보기 새로 만들기
    for(i = 0; i < e.target.files.length; i++){
        var str = "";
        var file_name = e.target.files[i].name;

        // file 명이 20자 이상이면 '... .확장자'로 대체
        if(file_name.length > 20){
            var _dot_index = e.target.files[i].name.lastIndexOf('.');
            var _extension = file_name.substring(_dot_index, e.target.files[i].name.length).toLowerCase();
            file_name = file_name.substring(0, 17)+"... " + _extension;
        }

        str += '<br><img style="width: 200px;" id="preview_image' + i + '" src="" />\n' + 
                '<span class="file_name_span">' + file_name + '</span><br>';
        $("#file_name_alert_area").append(str);

        var tmp = e.target.files[i];
        var src = URL.createObjectURL(tmp);
        $("#preview_image" + i).attr("src", src);
    }
}

    
$('#picture').change(function(e){

    if(e.target.files.length > 6) {
        console.log(e.target.files.length);
        alert('파일의 최대 개수는 6개 입니다.');
        $('#picture').val('');
        return;
    }

    readFiles(e);
});
/* admin goods 카테고리 부분 끝 */





// admin goods 시작
function make_tag(tags) {

    let tag_arr = tags.split(" ");

    $("#tag_span").empty();
    for (tag of tag_arr) {
        // tag 화면에 만들기
        let str = '<span id="tag_content">' + tag + '<i id="tag_icon" class="far fa-times-circle fa-lg"></i></span>';
        $("#tag_span").append(str);
    }

    // tag 적는 text 비우기
    $("#tag_text").val('');
}

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
                        '<span class="close_btn"><i class="far fa-times-circle fa-2x" aria-hidden="true"></i></span>\n' +  
                        '<input type="hidden" class="file_name" value="' + image + '">\n' + 
                    '</li>\n';
    }
    $("#preview").html(str);


    // 이미지 개수 세팅
    $("#image_num").html(image_arr.length);
}


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



// tag 생성
$("#tag_text").keyup(function (e) {
    console.log("태그생성")
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
        let str = '<span id="tag_content">' + tag_text_value + '<i id="tag_icon" class="far fa-times-circle fa-lg"></i></span>';
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

    // tag 데이터 db에 있으면 삭제    <-- edit.php
    if (tag_goods_id != '') {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/goods/delete_tag",
            type: "POST",
            dataType: 'text',
            data: {
                tag_name : tag_val,
                goods_id : tag_goods_id
            },
            success : function(data) {

            },
            error: function(request,status,error){ 
                alert("code = "+ request.status + " message = " + request.responseText + " error = " + error); 
                console.log("code = "+ request.status + " message = " + request.responseText + " error = " + error);
            }
        });
    }
    
});


// 이미지 오른쪽 상단 x버튼(삭제 버튼) 클릭시
$(document).on("click", ".close_btn", function(e){

    e.preventDefault();
    e.stopPropagation();
    
    // 이미지 미리보기 삭제
    $(e.target).parent().parent().remove();

    console.log(e.target);
    console.log($(e.target).parent().parent());

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


// form submit
$(".store_button").click (function(e) {
    
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
                            '<span class="close_btn"><i class="far fa-times-circle fa-2x" aria-hidden="true"></i></span>\n' +  
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

$('input[type="text"]').keydown(function() {
    if (event.keyCode === 13) {
        event.preventDefault();
    };
});
// admin goods 끝