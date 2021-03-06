@php
    // check 값 세팅 함수
    function check_setting_func($name, &$checked1, &$checked2, $good_colum) {

        $checked1 = '';
        $checked2 = '';

        // 유효성 검사 걸렸을 경우
        if (old($name) != '') {
            if(old($name) == 0) $checked1 = 'checked';
            else $checked2 = 'checked';
        }
        // 안걸렸을 경우
        else {
            if ($good_colum == 0) $checked1 = 'checked';
            else $checked2 = 'checked';
        }
    }

    
    // check 값 세팅
    check_setting_func('state', $state_checked1, $state_checked2, $good->state);
    check_setting_func('exchange', $exchange_checked1, $exchange_checked2, $good->exchange);
    check_setting_func('delivery_fee', $delivery_fee_checked1, $delivery_fee_checked2, $good->delivery_fee);


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
    else {
        if($good->sale_state == 0) $sale_state_checked1 = 'checked';
        else if ($good->sale_state == 1) $sale_state_checked2 = 'checked';
        else $sale_state_checked3 = 'checked';
    }
@endphp

@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><a href="/admin/goods">Goods</a></h1>
        <br>
        <div class="card mb-4">
            <form action="/admin/goods/{{ $good->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    goods table
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
                                <th width="30%">id</th>
                                <td width="70%"><input class="form-control" type="text" value="{{ $good->id }}" readonly></td>
                            </tr>
                            <tr>
                                <th width="30%">title(제목) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title') ? old('title') : $good->title }}" required>
                                    @error('title')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">image(상품 이미지) <span style="color : red;">*</span><br><span id="num_count">(<span id="image_num">{{ count($images) }}</span>/6)</span></th>
                                <td width="70%">
                                    <div class="@error('order') is-invalid @enderror" id="content_box">
                                        <div class="content">
                                            이미지를 드래그하거나 클릭하세요
                                        </div>
                                    </div>
                                    @error('order')
                                        <div style="margin-top : 5px!important; color : #dc3545;">이미지를 등록하세요</div>
                                    @enderror
                                    <div class="form-group">
                                        <input type="file" class="form-control" id="image" name="image" accept="image/jpg, image/jpeg, image/png" multiple/>
                                        <input type="hidden" name="order" id="order" value="{{ old('order') ? old('order') : $order }}" />
                                    </div>
                                    <small class="form-text text-muted">
                                        - 등록할 수 있는 이미지의 개수는 <span style="color : red;">최대 6개</span><br>
                                        - 이미지 이동해서 등록순서 변경 가능<br>
                                        - 등록된 첫번째 이미지는 상품의 대표 이미지
                                        </ul>
                                    </small>
                                    <ul id="preview" class="sortable">
                                        @foreach ($images as $index=>$image)
                                            <li class="li">
                                                <img class="li_image" src="{{ asset('storage/images/goods/'.$image->name) }}" alt="{{ $image_names[$index] }}"/>
                                                <span class="close_btn"><i class="far fa-times-circle fa-2x" aria-hidden="true"></i></span>
                                                <input type="hidden" class="file_name" value="{{ $image->name }}">
                                            </li>
                                        @endforeach
                                    </ul>
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
                                                @if ($good->category_id == $category->id) 
                                                    <option value="{{ $category->id }}" selected>[{{ $category->id }}] {{ $category->name }}</option>
                                                @else  
                                                    <option value="{{ $category->id }}">[{{ $category->id }}] {{ $category->name }}</option> 
                                                @endif
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
                                    @if (isset($good->category_de_id))
                                        <select class="form-select @error('category_de_id') is-invalid @enderror" aria-label="Default select example" name="category_de_id" id="category_de_select" required>
                                            <option value="0" selected>카테고리 상세를 고르세요</option>
                                            @foreach ($category_des as $category_de)
                                                @if ($category_de->category_id == $good->category_id)
                                                    @if ($good->category_de_id == $category_de->id) 
                                                        <option value="{{ $category_de->id }}" selected>[{{ $category_de->id }}] {{ $category_de->name }}</option>
                                                    @else  
                                                        <option value="{{ $category_de->id }}">[{{ $category_de->id }}] {{ $category_de->name }}</option> 
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">category_de_de_id</th>
                                <td width="70%" id="category_de_de_select_area">
                                    @if (isset($good->category_de_de_id))
                                        <select class="form-select @error('category_de_de_id') is-invalid @enderror" aria-label="Default select example" name="category_de_de_id" id="category_de_de_select" required>
                                            <option value="0" selected>카테고리 상세 상세를 고르세요</option>
                                            @foreach ($category_de_des as $category_de_de)
                                                @if ($category_de_de->category_de_id == $good->category_de_id) 
                                                    @if ($good->category_de_de_id == $category_de_de->id) 
                                                        <option value="{{ $category_de_de->id }}" selected>[{{ $category_de_de->id }}] {{ $category_de_de->name }}</option>
                                                    @else  
                                                        <option value="{{ $category_de_de->id }}">[{{ $category_de_de->id }}] {{ $category_de_de->name }}</option> 
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">area(거래지역) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('area') is-invalid @enderror" type="text" name="area" value="{{ old('area') ? old('area') : $good->area }}" required>
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
                                    <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" value="{{ old('price') ? old('price') : $good->price }}" placeholder="숫자만 입력하세요. ex) 10000" required>
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
                                    <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="10" placeholder="내용을 입력하세요."  required>{{ old('content') ? old('content') : $good->content }}</textarea>
                                    @error('content')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">number(상품 수량) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('number') is-invalid @enderror" type="text" name="number" value="{{ old('number') ? old('number') : $good->number }}" placeholder="숫자만 입력하세요. ex) 1"  required/>
                                    @error('number')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">heart(찜 개수) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('heart') is-invalid @enderror" type="text" name="heart" value="{{ old('heart') ? old('heart') : $good->heart }}" placeholder="숫자만 입력하세요. ex) 1" required />
                                    @error('heart')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">view(조회수) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('view') is-invalid @enderror" type="text" name="view" value="{{ old('view') ? old('view') : $good->view }}" placeholder="숫자만 입력하세요. ex) 1" required>
                                    @error('view')
                                        <div style="margin-top : 5px!important; color : #dc3545;">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">writeday(작성 날짜) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control @error('writeday') is-invalid @enderror" type="text" name="writeday" value="{{ old('writeday') ? old('writeday') : $good->writeday }}" id="datepicker" required>
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
                                                @if ($good->user_id == $user->id) 
                                                    <option value="{{ $user->id }}" selected>[{{ $user->id }}] {{ $user->name }}</option>
                                                @else  
                                                    <option value="{{ $user->id }}">[{{ $user->id }}] {{ $user->name }}</option> 
                                                @endif
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
                            <tr>
                                <th width="30%">tags(연관태그) <span style="color : red;">*</span></th>
                                <td>
                                    <div id="tag_area">
                                        <span id="tag_span">
                                            @foreach ($tags as $_tag)
                                                <span id="tag_content">{{ $_tag->name }}<i id="tag_icon" class="far fa-times-circle fa-lg"></i></span>
                                            @endforeach
                                        </span>
                                        <input type="text" id="tag_text" name="tag_text" placeholder="연관태그를 입력하세요" >
                                    </div>
                                    <input type="hidden" name="tag" id="tag" value="{{ old('tag') ? old('tag') : $tag }}"/>
                                    <small class="form-text text-muted">
                                        - 태그는 띄어쓰기로 구분됨. <span style="color : red;">최대 5개</span>까지 입력.
                                    </small>
                                </td>
                              </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('ksy/js/admin.js'); }}"></script>
<script>
    // 값 세팅
    var category_des = <?php echo json_encode($category_des)?>;
    var category_de_des = <?php echo json_encode($category_de_des)?>;
    var old_category_id = '{{ old("category_id") }}';
    var old_category_de_id = '{{ old("category_de_id") }}';
    var old_category_de_de_id = '{{ old("category_de_de_id") }}';
    var old_tag = '{{ old("tag") }}';
    var old_order = '{{ old("order") }}';
    var tag_goods_id = '{{ $good->id }}';

    $(function() {
        // 유효성 검사 걸리면 실행
        if (old_category_id != '' && old_category_id != 0) {
            selectCategory(category_des, old_category_de_id);
        }
        if (old_category_de_id != '' && old_category_de_id != 0) {
            selectCategoryDe(category_de_des, old_category_de_de_id);
        }

        if (old_tag != '') {
            make_tag(old_tag);
        }
        if (old_order != '') {
            let image_src = '{{ asset('storage/images/goods/') }}/';
            make_preview_image(old_order, image_src);
        } 
    });

    // 카테고리 부분 클릭시 실행
    $(document).on("change", "#category_select", function(){
        selectCategory(category_des, old_category_de_id);
    });
    $(document).on("change", "#category_de_select", function(){
        selectCategoryDe(category_de_des, old_category_de_de_id);
    });

    // 이미지 정렬 가능하게 함
    $(".sortable").sortable();
    $(".sortable").disableSelection();
</script>
@endsection