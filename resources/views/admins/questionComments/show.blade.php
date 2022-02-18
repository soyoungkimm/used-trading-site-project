@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><a href="/admin/question_comments">Question_comments</a></h1>
        <br>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> question_comments table 
                <form action="/admin/question_comments/{{ $question_comment->id }}" method="post" name="delete_form" style="display : none">
                    @csrf
                    @method('DELETE')
                </form>
                <input type="button" id="delete_button" class="btn btn-danger admin_button" value="삭제"/>
                <button type="button" class="btn btn-primary admin_button" onclick="location.href='/admin/question_comments/{{ $question_comment->id }}/edit'">수정</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="30%">id</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $question_comment->id }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">user_id(댓글 작성자)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="[{{ $question_comment->user_id }}] {{ $question_comment->user_name }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">question_id(문의 id)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="[{{ $question_comment->question_id }}] {{ $question_comment->question_content }}"></td>
                        </tr>
                        <tr>
                            <th width="30%">content(내용)</th>
                            <td width="70%">
                                <textarea class="form-control" name="content" rows="10" readonly>{{ $question_comment->content }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th width="30%">writeday(작성날짜)</th>
                            <td width="70%"><input class="form-control" type="text" readonly value="{{ $question_comment->writeday }}"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('ksy/js/admin.js'); }}"></script>
@endsection
