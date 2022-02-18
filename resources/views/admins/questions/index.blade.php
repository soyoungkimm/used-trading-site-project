@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Questions</h1>
        <br>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                questions table
                <button type="button" class="btn btn-success admin_button" onclick="location.href='/admin/questions/create'">추가</button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>user_id(문의 작성자)</th>
                            <th>goods_id(상품 id)</th>
                            <th>writeday</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>id</th>
                            <th>user_id(문의 작성자)</th>
                            <th>goods_id(상품 id)</th>
                            <th>writeday</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($questions as $question)
                            <tr>
                                <td><a href="/admin/questions/{{ $question->id }}">{{ $question->id }}</a></td>
                                <td>[{{ $question->user_id }}] {{ $question->user_name }}</td>
                                <td>[{{ $question->goods_id }}] {{ $question->good_title }}</td>
                                <td>{{ $question->writeday }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection