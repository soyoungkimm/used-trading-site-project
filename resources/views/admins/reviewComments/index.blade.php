@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Review_comments</h1>
        <br>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                review_comments table
                <button type="button" class="btn btn-success admin_button" onclick="location.href='/admin/review_comments/create'">추가</button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>user_id(댓글 작성자(= 상품 게시자))</th>
                            <th>review_id(상품 id)</th>
                            <th>writeday</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>id</th>
                            <th>user_id(댓글 작성자(= 상품 게시자))</th>
                            <th>review_id(상품 id)</th>
                            <th>writeday</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($review_comments as $review_comment)
                            <tr>
                                <td><a class="admin_id" href="/admin/review_comments/{{ $review_comment->id }}">{{ $review_comment->id }}</a></td>
                                <td>[{{ $review_comment->user_id }}] {{ $review_comment->user_name }}</td>
                                <td>[{{ $review_comment->review_id }}] {{ $review_comment->review_content }}</td>
                                <td>{{ $review_comment->writeday }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection