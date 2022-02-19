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
            var arrCategory = $('input[name=deleteAd]:checked').serializeArray().map(function(item) {return item.value});
            if(arrCategory.length != 0){
                $.ajax({
                url:"/admin/category/arrCategory",
                type:"DELETE",
                data:{
                    'arrCategory':arrCategory
                },
                success: function(result){
                    console.log(result);
                    location.reload();
                }
            });
            }else{
                alert('삭제할 카테고리를 선택해 주세요');
            }
           
        });
        
    });
</script>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Categorys</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Categorys List
            </div>
            <div class="card-body">
                <a class="btn btn-primary my-2" href="/admin/category/create"><i class="fas fa-list"></i> <i class="fas fa-plus"></i></a>
                <a class="btn btn-primary my-2" id="delteBtn"><i class="fas fa-list"></i> <i class="fas fa-minus"></i></a>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center;" >삭제</th>
                            <th>No</th>
                            <th>제목</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th width="5%" style="text-align:center;" >삭제</th>
                            <th>No</th>
                            <th>제목</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($Categorys as $Category)
                        <tr> 
                            <td style="text-align:center;" ><input type="checkbox" name="deleteAd" value="{{ $Category->id }}"/></td>
                            <td>{{ $Category->id }}</td>
                            <td><a href='/admin/category/{{ $Category->id }}'>{{ $Category->name }} </a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection