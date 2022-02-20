@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Goods</h1>
        <br>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                goods table
                <button type="button" class="btn btn-success admin_button" onclick="location.href='/admin/goods/create'">추가</button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>title</th>
                            <th>category</th>
                            <th>user</th>
                            <th>price</th>
                            <th>sale_state</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>id</th>
                            <th>title</th>
                            <th>category</th>
                            <th>user</th>
                            <th>price</th>
                            <th>sale_state</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($goods as $good)
                            <tr>
                                <td><a class="admin_id" href="/admin/goods/{{ $good->id }}">{{ $good->id }}</a></td>
                                <td>{{ $good->title }}</td>
                                <td>{{ $good->category_name }} {{ $good->category_de_name ? ' > '.$good->category_de_name : ''}} 
                                    {{ $good->category_de_de_name ? ' > '.$good->category_de_de_name : '' }}</td>
                                <td>[{{ $good->user_id }}] {{ $good->user_name }}</td>
                                <td>{{ number_format($good->price) }} &#8361</td>
                                <td>
                                    @if ($good->sale_state == 0) 판매중
                                    @elseif ($good->sale_state == 1) 판매완료
                                    @else 예약중
                                    @endif 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection