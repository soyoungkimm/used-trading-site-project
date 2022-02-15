@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><a href="/admin/goods">Goods</a></h1>
        <br>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> goods table 
                <form action="/admin/goods/{{ $good->id }}" method="post" name="delete_form" style="display : none">
                    @csrf
                    @method('DELETE')
                </form>
                <input type="button" id="delete_button" class="btn btn-danger admin_button" value="삭제"/>
                <button type="button" class="btn btn-primary admin_button" onclick="location.href='/admin/goods/{{ $good->id }}/edit'">수정</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="30%">id</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $good->id }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">title(제목)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $good->title }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">image(상품 이미지)</th>
                            <td width="70%">
                                @foreach ($images as $image)
                                    <br><img style="width: 200px;" id="preview_image" src="{{ asset('storage/images/goods/'.$image) }}" />
                                    <span class="file_name_span"><a href="{{ asset('storage/images/goods/'.$image) }}" download>{{ $image }}</a></span><br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th width="30%">category_id</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="[{{ $good->category_id }}] {{ $good->category_name }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">category_de_id</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $set_good['category_de_id'] }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">category_de_de_id</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $set_good['category_de_de_id'] }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">area(거래지역)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $good->area }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">state(상태)</th>
                            <td width="70%">
                                <input class="form-control" type="text" readonly value="{{ $set_good['state'] }}">
                            </td>
                        </tr>
                        <tr>
                            <th width="30%">exchange(교환여부)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $set_good['exchange'] }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">price(가격)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ number_format($good->price) }} &#8361"></td>
                        </tr>
                        <tr>
                            <th width="30%">delivery_fee(배송비 포함 여부)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $set_good['delivery_fee'] }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">content(설명)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $good->content }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">number(상품 수량)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $good->number }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">heart(찜 개수)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $good->heart }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">view(조회수)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $good->view }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">writeday(작성 날짜)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $good->writeday }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">user_id(회원 id)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="[{{ $good->user_id }}] {{ $good->user_name }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">sale_state(판매 상태)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $set_good['sale_state'] }}"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
<script>
    window.onload = function() {
        $("#delete_button").click(function () {
            let form = document.delete_form;
            let result = confirm('정말로 삭제하시겠습니까?');
            if (result) {
                form.submit();
            }
        });
    }
</script>