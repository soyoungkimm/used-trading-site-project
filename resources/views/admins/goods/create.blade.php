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
                    <input type="submit" class="btn btn-success store_button" value="저장" />
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            @error('category_de_id')
                                <div style="margin-top : 5px!important; color : #dc3545;">카테고리 상세를 고르세요</div>
                            @enderror
                            @error('category_de_de_id')
                                <div style="margin-top : 5px!important; color : #dc3545;">카테고리 상세 상세를 고르세요</div>
                            @enderror
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
                                    <select class="form-select @error('category_id') is-invalid @enderror" aria-label="Default select example" name="category_id" id="category_select" required>
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
                                    
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">category_de_de_id</th>
                                <td width="70%" id="category_de_de_select_area">
                                    
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
                                    <label for="state1"><input width="300px;" type="radio" name="state" id="state1" value="0" {{ $state_checked1 }}/>&nbsp;중고상품&nbsp;&nbsp;&nbsp;</label>
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
<script src="{{ asset('ksy/js/admin.js'); }}"></script>
<script>
   // 값 세팅
   var category_des = <?php echo json_encode($category_des)?>;
    var category_de_des = <?php echo json_encode($category_de_des)?>;
    var old_category_id = '{{ old("category_id") }}';
    var old_category_de_id = '{{ old("category_de_id") }}';
    var old_category_de_de_id = '{{ old("category_de_de_id") }}';

    $(function() {
        // 유효성 검사 걸리면 실행
        if (old_category_id != '' && old_category_id != 0) {
            selectCategory(category_des, old_category_de_id);
        }
        if (old_category_de_id != '' && old_category_de_id != 0) {
            selectCategoryDe(category_de_des, old_category_de_de_id);
        }
    });

    // 카테고리 부분 클릭시 실행
    $(document).on("change", "#category_select", function(){
        selectCategory(category_des, old_category_de_id);
    });
    $(document).on("change", "#category_de_select", function(){
        selectCategoryDe(category_de_des, old_category_de_de_id);
    });
</script>
@endsection