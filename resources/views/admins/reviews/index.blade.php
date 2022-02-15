@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Reviews</h1>
        <br>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                reviews table
                <button type="button" class="btn btn-success admin_button" onclick="location.href='/admin/reviews/create'">추가</button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>user_id(후기 작성자)</th>
                            <th>goods_id(상품 id)</th>
                            <th>star</th>
                            <th>writeday</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>id</th>
                            <th>user_id(후기 작성자)</th>
                            <th>goods_id(상품 id)</th>  
                            <th>star</th>
                            <th>writeday</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td><a href="/admin/reviews/{{ $review->id }}">{{ $review->id }}</a></td>
                                <td>[{{ $review->user_id }}] {{ $review->user_name }}</td>
                                <td>[{{ $review->goods_id }}] {{ $review->good_title }}</td>
                                <td>
                                    <div id="review_star_{{ $review->id }}">
                                        <script src="{{ asset('ksy/js/admin.js'); }}"></script>
                                        <script>
                                            list_set_star({{ $review->star }}, 'review_star_{{ $review->id }}');
                                        </script>
                                    </div>
                                </td>
                                <td>{{ $review->writeday }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection