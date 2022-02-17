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