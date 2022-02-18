@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Question_comments</h1>
        <br>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                question_comments table
                <button type="button" class="btn btn-success admin_button" onclick="location.href='/admin/question_comments/create'">추가</button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>user_id(댓글 작성자)</th>
                            <th>question_id(문의 id)</th>
                            <th>writeday</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>id</th>
                            <th>user_id(댓글 작성자)</th>
                            <th>question_id(문의 id)</th>
                            <th>writeday</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($question_comments as $question_comment)
                            <tr>
                                <td><a href="/admin/question_comments/{{ $question_comment->id }}">{{ $question_comment->id }}</a></td>
                                <td>[{{ $question_comment->user_id }}] {{ $question_comment->user_name }}</td>
                                <td>[{{ $question_comment->question_id }}] {{ $question_comment->question_content }}</td>
                                <td>{{ $question_comment->writeday }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection