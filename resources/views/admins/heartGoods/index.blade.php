@extends('layouts.adminLayout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $(function() {
        $("#delteBtn").click(function(){
            var arrgoods = $('input[name=deleteGoods]:checked').serializeArray().map(function(item) {return item.value});
            if(arrgoods.length != 0){
                $.ajax({
                url:"/admin/heart-goods/arrgoods",
                type:"DELETE",
                data:{
                    'arrGoods':arrgoods
                },
                success: function(result){
                    console.log(result);
                    location.reload();
                }
            });
            }else{
                alert('삭제할 광고를 선택해 주세요');
            }
           
        });
        
    });
</script>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Heart Goods</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Heart Goods List
            </div>
            <div class="card-body">
                <a class="btn btn-primary my-2" href="/admin/heart-goods/create"><i class="fas fa-heart"></i> <i class="fas fa-plus"></i></a>
                <a class="btn btn-primary my-2" id="delteBtn"><i class="fas fa-heart"></i> <i class="fas fa-minus"></i></a>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center;" >삭제</th>
                            <th>No</th>
                            <th>상품</th>
                            <th>회원</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th width="5%" style="text-align:center;" >삭제</th>
                            <th>No</th>
                            <th>상품</th>
                            <th>회원</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($heart_goods as $heart_good)
                        <tr> 
                            <td style="text-align:center;" ><input type="checkbox" name="deleteGoods" value="{{ $heart_good->id }}"/></td>
                            <td>{{ $heart_good->id }}</td>
                            <td><a href='/admin/heart-goods/{{ $heart_good->id }}'>{{ $heart_good->good_title }} </a></td>
                            <td>{{ $heart_good->user_name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection