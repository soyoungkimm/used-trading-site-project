@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><a href="/admin/reviews">Reviews</a></h1>
        <br>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> reviews table 
                <form action="/admin/reviews/{{ $review->id }}" method="post" name="delete_form" style="display : none">
                    @csrf
                    @method('DELETE')
                </form>
                <input type="button" id="delete_button" class="btn btn-danger admin_button" value="삭제"/>
                <button type="button" class="btn btn-primary admin_button" onclick="location.href='/admin/reviews/{{ $review->id }}/edit'">수정</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="30%">id</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $review->id }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">user_id(작성자)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="[{{ $review->user_id }}] {{ $review->user_name }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">goods_id(상품 id)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="[{{ $review->goods_id }}] {{ $review->good_title }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">star(별점)</th>
                            <td width="70%">
                                    <i class="far fa-star fa-lg" id="star1"></i>
                                    <i class="far fa-star fa-lg" id="star2"></i>
                                    <i class="far fa-star fa-lg" id="star3"></i>
                                    <i class="far fa-star fa-lg" id="star4"></i>
                                    <i class="far fa-star fa-lg" id="star5"></i>
                                    &nbsp;&nbsp;<span id="star_num">0</span>
                            </td>
                        </tr>
                        <tr>
                            <th width="30%">content(내용)</th>
                            <td width="70%">
                                <textarea class="form-control" name="content" rows="10" readonly>{{ $review->content }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th width="30%">writeday(작성날짜)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $review->writeday }}"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('ksy/js/admin.js'); }}"></script>
<script>
    change_star({{ $review->star }});
</script>
@endsection
