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
    $delivery_fee_checked = ($delivery_fee_checked1 == 'checked') ? '' : 'checked';
@endphp

@extends('layouts.siteLayout')

@section('content')
<link href="{{ asset('ksy/css/site.css'); }}" rel="stylesheet" />
<section class="featured spad my_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form id="create_form" action="/goods" method="POST">
                    @csrf
                    <h3 id="form_title">상품 등록</h3>
                    <br><br>
                    <table class="table table-striped">
                        <tbody>
                          <tr>
                            <th scope="row" class="form_label colored top_line">제목 <span class="requ">*</span><br><span id="num_count">(<span id="title_num">0</span>/50)</span></th>
                            <td class="colored top_line">
                                <input type="text" id="title" name="goods_title" placeholder="제목을 입력하세요" class="@error('goods_title') is-invalid @enderror" value="{{ old('goods_title') ? old('goods_title') : '' }}" />
                                @error('goods_title')
                                    <div class="error_message">{{ $message }}</div>
                                @enderror
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="form_label">상품 이미지 <span class="requ">*</span><br><span id="num_count">(<span id="image_num">0</span>/6)</span></th>
                            <td>
                                <div class="@error('order') is-invalid @enderror" id="content_box">
                                    <div class="content">
                                        이미지를 드래그하거나 클릭하세요
                                    </div>
                                </div>
                                @error('order')
                                    <div class="error_message">이미지를 등록하세요</div>
                                @enderror
                                <div class="form-group">
                                    <input type="file" class="form-control" id="image" name="image" accept="image/jpg, image/jpeg, image/png" multiple/>
                                    <input type="hidden" name="order" id="order" value="{{ old('order') ? old('order') : '' }}" />
                                </div>
                                <small class="form-text text-muted">
                                    <ul>
                                        <li>- 등록할 수 있는 이미지의 개수는 <span class="requ">최대 6개</span>입니다.</li>
                                        <li>- 이미지를 클릭 후 이동하여 등록순서를 변경할 수 있습니다.</li>
                                        <li>- 이미지를 클릭 할 경우 원본이미지를 확인할 수 있습니다.</li>
                                        <li>- 등록된 첫번째 이미지는 상품의 대표 이미지가 됩니다.</li>
                                    </ul>
                                </small>
                                <ul id="preview" class="sortable">
                                </ul>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="form_label colored">카테고리 <span class="requ">*</span></th>
                            <td class="colored">
                                <div id="category_select_area" class="@error('category_id') is-invalid @enderror">
                                    <ul class="category_ul">
                                        {{-- 유효성 검사 걸린 경우 --}}
                                        @if (old('category_id') != '') 
                                            @foreach ($categorys as $category) 
                                                @if (old('category_id') == $category->id) 
                                                    <li><button type="button" value="{{ $category->id }}" class="category_select selected">{{ $category->name }}</button></li>
                                                @else  
                                                    <li><button type="button" value="{{ $category->id }}" class="category_select">{{ $category->name }}</button></li>
                                                @endif
                                            @endforeach
                                        {{-- 아닌 경우 --}}
                                        @else
                                            @foreach ($categorys as $category)
                                                <li><button type="button" value="{{ $category->id }}" class="category_select">{{ $category->name }}</button></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <input type="hidden" name="category_id" id="category_id" value="{{ old('category_id') ? old('category_id') : '0' }}"/>
                            
                                <div id="category_de_select_area" class="@error('category_de_id') is-invalid @enderror">
                                </div>
                                <input type="hidden" name="category_de_id" id="category_de_id" value="{{ old('category_de_id') ? old('category_de_id') : '' }}"/>
                                
                                <div id="category_de_de_select_area" class="@error('category_de_de_id') is-invalid @enderror">
                                </div>
                                <input type="hidden" name="category_de_de_id" id="category_de_de_id" value="{{ old('category_de_de_id') ? old('category_de_de_id') : '' }}"/>

                                
                                @error('category_id')
                                    <div class="error_message category_error_area">카테고리를 고르세요</div>
                                @enderror
                                @error('category_de_id')
                                    <div class="error_message category_error_area">카테고리 상세를 고르세요</div>
                                @enderror
                                @error('category_de_de_id')
                                    <div class="error_message category_error_area">카테고리 상세 상세를 고르세요</div>
                                @enderror
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="form_label">상태 <span class="requ">*</span></th>
                            <td>
                                <input type="radio" name="state" id="state1" value="0" {{ $state_checked1 }}/>
                                <label for="state1">&nbsp;중고상품</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="state" id="state2" value="1" {{ $state_checked2 }}/>
                                <label for="state2">&nbsp;새상품</label>
                                @error('state')
                                    <div class="error_message">{{ $message }}</div>
                                @enderror
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="form_label colored">교환 <span class="requ">*</span></th>
                            <td class="colored">
                                <input type="radio" name="exchange" id="exchange1" value="0" {{ $exchange_checked1 }}/>
                                <label for="exchange1">&nbsp;교환불가</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="exchange" id="exchange2" value="1" {{ $exchange_checked2 }}/>
                                <label for="exchange2">&nbsp;교환가능</label>
                                @error('exchange')
                                    <div class="error_message">{{ $message }}</div>
                                @enderror
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="form_label">가격 <span class="requ">*</span></th>
                            <td>
                                <input class="@error('price') is-invalid @enderror" type="text" id="price" name="price" placeholder="숫자만 입력하세요" value="{{ old('price') ? number_format(old('price')) : '100' }}"/><span class="input_left">원</span>
                                <br><br>
                                <input type="checkbox" name="delivery_fee" id="delivery_fee" value="1" />
                                <label for="delivery_fee" {{ $delivery_fee_checked }}>&nbsp;배송비 포함</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                @error('delivery_fee')
                                    <div class="error_message">{{ $message }}</div>
                                @enderror
                                @error('price')
                                    <div class="error_message">{{ $message }}</div>
                                @enderror
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="form_label colored">수량 <span class="requ">*</span></th>
                            <td class="colored">
                                <input class="@error('number') is-invalid @enderror" type="text" id="number" name="number" placeholder="숫자만 입력하세요" value="{{ old('number') ? old('number') : '1' }}"/><span class="input_left">개</span>
                                @error('number')
                                    <div class="error_message">{{ $message }}</div>
                                @enderror
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="form_label">설명 <span class="requ">*</span><br><span id="num_count">(<span id="content_num">0</span>/3000)</span></th>
                            <td>
                                <textarea class="@error('goods_content') is-invalid @enderror" placeholder="상품 설명을 입력하세요" id="content" name="goods_content">{{ old('goods_content') ? old('goods_content') : '' }}</textarea>
                                @error('goods_content')
                                    <div class="error_message">{{ $message }}</div>
                                @enderror
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="form_label colored">거래지역 <span class="requ">*</span></th>
                            <td class="colored">
                                <button type="button" id="all_btn">전국</button>
                                <button type="button" id="adress_btn">주소찾기</button>
                                <input class="@error('area') is-invalid @enderror" type="text" id="area" name="area" value="전국" value="{{ old('area') ? old('area') : '' }}" readonly/>
                                <small class="form-text text-muted">
                                    <ul>
                                        <li>* 버튼을 클릭하여 정보를 수정하세요</li>
                                    </ul>
                                </small>
                                @error('area')
                                    <div class="error_message">{{ $message }}</div>
                                @enderror
                            </td>
                          </tr>
                          <tr>
                            <th scope="row" class="form_label">연관태그</th>
                            <td>
                                <div id="tag_area">
                                    <span id="tag_span">
                                    </span>
                                    <input type="text" id="tag_text" name="tag_text" placeholder="연관태그를 입력하세요" >
                                </div>
                                <input type="hidden" name="tag" id="tag" value="{{ old('tag') ? old('tag') : '' }}"/>
                                <small class="form-text text-muted">
                                    <ul>
                                        <li>- 태그는 띄어쓰기로 구분되며 최대 5개까지 입력할 수 있습니다.</li>
                                        <li>- 태그는 검색의 부가정보로 사용 되지만, 검색 결과 노출을 보장하지는 않습니다.</li>
                                        <li>- 검색 광고는 태그정보를 기준으로 노출됩니다.</li>
                                        <li>- 상품과 직접 관련이 없는 다른 상품명, 브랜드, 스팸성 키워드 등을 입력하면 노출이 중단되거나 상품이 삭제될 수 있습니다.</li>
                                    </ul>
                                </small>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                    <br>
                    <div style="text-align: center;">
                        <input type="button" class="submit_btn" value="등록" />
                    </div>
                </form>
                <!-- The Modal -->
                <div id="myModal" class="modal">
                    <span class="close_modal">&times;</span>
                    <img class="modal-content" id="img01">
                    <div id="caption"></div>
                </div>
                <!-- Adress Modal -->
                <div id="adress_find_modal" class="modal">
                    <div id="adress_area">
                        <span id="adress_title">주소 검색 <i class="fa fa-search find_adress_icon" aria-hidden="true"></i></span>
                        <span class="close_adress_modal">&times;</span>
                        <input type="text" id="find_adress_text" placeholder="주소를 입력하세요" />
                        <div id="adress_result">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('ksy/js/site.js'); }}"></script>
<script>
    // 값 세팅
    var old_category_id = '{{ old("category_id") }}';
    var old_category_de_id = '{{ old("category_de_id") }}';
    var old_category_de_de_id = '{{ old("category_de_de_id") }}';
    var old_tag = '{{ old("tag") }}';
    var old_order = '{{ old("order") }}';
    var tag_goods_id = '';

    // 유효성 검사 걸리면 실행
    $(function() {
        if (old_category_id != '' && old_category_id != 0) {
            selectCategory(category_des, old_category_de_id, old_category_id);
        }
        if (old_category_de_id != '') {
            selectCategoryDe(category_de_des, old_category_de_de_id, old_category_de_id);
        }
        if (old_tag != '') {
            make_tag(old_tag);
        }
        if (old_order != '') {
            let image_src = '{{ asset('storage/images/goods/') }}/';
            make_preview_image(old_order, image_src);
        } 
    });
</script>
@endsection