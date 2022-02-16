@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><a href="/admin/review_comments">Review_comments</a></h1>
        <br>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> reviews table 
                <form action="/admin/review_comments/{{ $review_comment->id }}" method="post" name="delete_form" style="display : none">
                    @csrf
                    @method('DELETE')
                </form>
                <input type="button" id="delete_button" class="btn btn-danger admin_button" value="삭제"/>
                <button type="button" class="btn btn-primary admin_button" onclick="location.href='/admin/review_comments/{{ $review_comment->id }}/edit'">수정</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="30%">id</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $review_comment->id }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">user_id(작성자(= 상품 게시자))</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="[{{ $review_comment->user_id }}] {{ $review_comment->user_name }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">review_id(후기 id)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="[{{ $review_comment->review_id }}] {{ $review_comment->review_content }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">content(내용)</th>
                            <td width="70%">
                                <textarea class="form-control" name="content" rows="10" readonly>{{ $review_comment->content }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th width="30%">writeday(작성날짜)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $review_comment->writeday }}"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('ksy/js/admin.js'); }}"></script>
@endsection
