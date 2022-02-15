@php
    // check 값 세팅 함수
    function check_setting_func($name, &$checked1, &$checked2) {

        $checked1 = '';
        $checked2 = '';

        // 유효성 검사 걸렸을 경우
        if (old($name) != '') {
            if(old($name) == 0) $checked1 = 'checked';
            else $checked2 = 'checked';   
        }
        // 안걸렸을 경우
        else $checked1 = 'checked';
    }

    
    // check 값 세팅
    check_setting_func('state', $state_checked1, $state_checked2);
    check_setting_func('exchange', $exchange_checked1, $exchange_checked2);
    check_setting_func('delivery_fee', $delivery_fee_checked1, $delivery_fee_checked2);


    // sale_state check 값 세팅
    $sale_state_checked1 = '';
    $sale_state_checked2 = '';
    $sale_state_checked3 = '';
    // 유효성 검사 걸렸을 경우
    if (old('sale_state') != '') {
        if(old('sale_state') == 0) $sale_state_checked1 = 'checked';
        else if (old('sale_state') == 1) $sale_state_checked2 = 'checked';
        else $sale_state_checked3 = 'checked';
    }
    // 안걸렸을 경우
    else $sale_state_checked1 = 'checked';
@endphp

@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><a href="/admin/goods">Goods</a></h1>
        <br>
        <div class="card mb-4">
            <form action="/admin/goods" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> goods table 
                    <div style="text-align:right" >
                        <input type="submit" class="btn btn-success" value="저장" />
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">title(제목) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title') ? old('title') : '' }}" required>
                                    @error('title')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">image(상품 이미지 - 최대 6개) <span style="color : red;">*</span></th>
                                <td width="70%" id="image_area">
                                    <div class="input-group mb-2">
                                        <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror" name="image[]" id="picture" multiple required/>
                                    </div>
                                    <div id="file_name_alert_area">
                                    </div>
                                    @error('image')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                                
                            </tr>    
                            <tr>
                                <th width="30%">category_id <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <select class="form-select @error('category_id') is-invalid @enderror" aria-label="Default select example" name="category_id" onchange="selectCategory();" id="category_select" required>
                                        <option value="0" selected>카테고리를 고르세요</option>
                                        {{-- 유효성 검사 걸린 경우 --}}
                                        @if (old('category_id') != '') 
                                            @foreach ($categorys as $category) 
                                                @if (old('category_id') == $category->id) 
                                                    <option value="{{ $category->id }}" selected>[{{ $category->id }}] {{ $category->name }}</option>
                                                @else  
                                                    <option value="{{ $category->id }}">[{{ $category->id }}] {{ $category->name }}</option> 
                                                @endif
                                            @endforeach
                                        {{-- 아닌 경우 --}}
                                        @else
                                            @foreach ($categorys as $category)
                                                <option value="{{ $category->id }}">[{{ $category->id }}] {{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('category_id')
                                        <div style="margin-top : 5px!important; color : #dc3545;">카테고리를 고르세요</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">category_de_id</th>
                                <td width="70%" id="category_de_select_area">
                                    <input type="hidden" name="category_de_id" value="0" />
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">category_de_de_id</th>
                                <td width="70%" id="category_de_de_select_area">
                                    <input type="hidden" name="category_de_de_id" value="0" />
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">area(거래지역) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('area') is-invalid @enderror" type="text" name="area" value="{{ old('area') ? old('area') : '' }}" required>
                                    @error('area')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                                
                            </tr>
                            <tr>
                                <th width="30%">state(상태) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <label for="state1"><input type="radio" name="state" id="state1" value="0" {{ $state_checked1 }}/>&nbsp;중고상품&nbsp;&nbsp;&nbsp;</label>
                                    <label for="state2"><input type="radio" name="state" id="state2" value="1" {{ $state_checked2 }}/>&nbsp;새상품</label>  
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">exchange(교환여부) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <label for="exchange1"><input type="radio" name="exchange" id="exchange1" value="0" {{ $exchange_checked1 }}/>&nbsp;교환불가&nbsp;&nbsp;&nbsp;</label>
                                    <label for="exchange2"><input type="radio" name="exchange" id="exchange2" value="1" {{ $exchange_checked2 }}/>&nbsp;교환가능</label>
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">price(가격) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" value="{{ old('price') ? old('price') : '' }}" placeholder="숫자만 입력하세요. ex) 10000" required>
                                    @error('price')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                                
                            </tr>
                            <tr>
                                <th width="30%">delivery_fee(배송비 포함 여부) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <label for="delivery_fee1"><input type="radio" name="delivery_fee" value="0" id="delivery_fee1" {{ $delivery_fee_checked1 }}/>&nbsp;포함&nbsp;&nbsp;&nbsp;</label>
                                    <label for="delivery_fee2"><input type="radio" name="delivery_fee" value="1" id="delivery_fee2" {{ $delivery_fee_checked2 }}/>&nbsp;포함안함</label>
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">content(설명) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="10" placeholder="내용을 입력하세요."  required>{{ old('content') ? old('content') : '' }}</textarea>
                                    @error('content')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">number(상품 수량) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('number') is-invalid @enderror" type="text" name="number" value="{{ old('number') ? old('number') : '' }}" placeholder="숫자만 입력하세요. ex) 1"  required/>
                                    @error('number')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">heart(찜 개수) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('heart') is-invalid @enderror" type="text" name="heart" value="{{ old('heart') ? old('heart') : '' }}" placeholder="숫자만 입력하세요. ex) 1" required />
                                    @error('heart')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">view(조회수) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('view') is-invalid @enderror" type="text" name="view" value="{{ old('view') ? old('view') : '' }}" placeholder="숫자만 입력하세요. ex) 1" required>
                                    @error('view')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">writeday(작성 날짜) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('writeday') is-invalid @enderror" type="text" name="writeday" value="{{ old('writeday') ? old('writeday') : '' }}" id="datepicker" required>
                                    @error('writeday')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">user_id(회원 id) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <select class="form-select @error('user_id') is-invalid @enderror" aria-label="Default select example" name="user_id" required>
                                        <option value="0" selected>회원을 고르세요</option>
                                        {{-- 유효성 검사 걸린 경우 --}}
                                        @if (old('user_id') != '') 
                                            @foreach ($users as $user)
                                                @if (old('user_id') == $user->id) 
                                                    <option value="{{ $user->id }}" selected>[{{ $user->id }}] {{ $user->name }}</option>
                                                @else  
                                                    <option value="{{ $user->id }}">[{{ $user->id }}] {{ $user->name }}</option> 
                                                @endif
                                            @endforeach
                                        {{-- 아닌 경우 --}}
                                        @else
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">[{{ $user->id }}] {{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('user_id')
                                        <div style="margin-top : 5px!important; color : #dc3545;">회원을 고르세요</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">sale_state(판매 상태) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <label for="sale_state1"><input type="radio" name="sale_state" id="sale_state1" value="0" {{ $sale_state_checked1 }}/>&nbsp;판매중&nbsp;&nbsp;&nbsp;</label>
                                    <label for="sale_state2"><input type="radio" name="sale_state" id="sale_state2" value="1" {{ $sale_state_checked2 }}/>&nbsp;판매완료&nbsp;&nbsp;&nbsp;</label>
                                    <label for="sale_state3"><input type="radio" name="sale_state" id="sale_state3" value="2" {{ $sale_state_checked3 }}/>&nbsp;예약중</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</main>
<script>
   
    $(function() {
        
        $( "#datepicker" ).datepicker();


        $category_id_validation_value = '{{ old("category_id") }}';
        if ($category_id_validation_value != '' && $category_id_validation_value != 0) {
            selectCategory();
        }


        $category_de_id_validation_value = '{{ old("category_de_id") }}';
        if ($category_de_id_validation_value != '' && $category_de_id_validation_value != 0) {
            selectCategoryDe();
        }


        $('#category_select').change(function(){
            selectCategory();
        });
    });


    function selectCategory() {

        let isNothing = true;
        let category_select = document.getElementById("category_select"); 
        let select_value = category_select.options[category_select.selectedIndex].value;
        
        let str = '<select class="form-select @error("category_de_id") is-invalid @enderror" aria-label="Default select example" name="category_de_id" onchange="selectCategoryDe();" id="category_de_select">\n' + 
                    '<option value="0" selected>카테고리_상세를 고르세요</option>\n';
        
        let category_des = <?php echo json_encode($category_des)?>;
        if (select_value != 0) {
            category_des.forEach((element, index, array) => {
                if (select_value == element.category_id) {
                    isNothing = false;
                    if('{{ old("category_de_id") }}' != '' && '{{ old("category_de_id") }}' == element.id) {
                        str += '<option value="' + element.id + '" selected>[' + element.id + ']' + element.name + '</option>\n';
                    }
                    else {
                        str += '<option value="' + element.id + '">[' + element.id + ']' + element.name + '</option>\n';
                    }
                }
            });
        }
        str += '</select>\n' +
                '@error("category_de_id")\n' + 
                    '<div style="margin-top : 5px!important; color : #dc3545;">카테고리 상세를 고르세요</div>\n' +
                '@enderror\n';;

        $("#category_de_select_area").empty();
        $("#category_de_de_select_area").empty();
        if(!isNothing) $("#category_de_select_area").html(str);
        
    }

    
    function selectCategoryDe() {
        
        let isNothing = true;
        let category_de_select = document.getElementById("category_de_select"); 
        let select_value = category_de_select.options[category_de_select.selectedIndex].value;
        
        let str = '<select class="form-select @error("category_de_de_id") is-invalid @enderror" aria-label="Default select example" name="category_de_de_id" id="category_de_de_select">\n' + 
                    '<option value="0" selected>카테고리_상세_상세를 고르세요</option>\n';
        
        let category_de_des = <?php echo json_encode($category_de_des)?>;
        if (select_value != 0) {
            category_de_des.forEach((element, index, array) => {
                if (select_value == element.category_de_id) {
                    isNothing = false;
                    if('{{ old("category_de_de_id") }}' != '' && '{{ old("category_de_de_id") }}' == element.id) {
                        str += '<option value="' + element.id + '" selected>[' + element.id + ']' + element.name + '</option>\n';
                    }
                    else {
                        str += '<option value="' + element.id + '">[' + element.id + ']' + element.name + '</option>\n';
                    }
                    
                }
            });
        }
        str += '</select>\n' +
                '@error("category_de_de_id")\n' + 
                    '<div style="margin-top : 5px!important; color : #dc3545;">카테고리 상세 상세를 고르세요</div>\n' +
                '@enderror\n';

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
</script>
@endsection