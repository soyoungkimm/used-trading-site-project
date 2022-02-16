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
        $("#deleteUser").click(function(){
            var arrAds = $('input[name=deleteAd]:checked').serializeArray().map(function(item) {return item.value});
            if(arrAds.length != 0){
                $.ajax({
                url:"/admin/advertise/arrAds",
                type:"DELETE",
                data:{
                    'adIdArr':arrAds
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
        <h1 class="mt-4">Ads</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Advertisement List
            </div>
            <div class="card-body">
                <a class="btn btn-primary my-2" href="/admin/advertise/create"><i class="fas fa-ad"></i> <i class="fas fa-plus"></i></a>
                <a class="btn btn-primary my-2" id="deleteUser"><i class="fas fa-ad"></i> <i class="fas fa-minus"></i></a>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center;" >삭제</th>
                            <th>No</th>
                            <th>제목</th>
                            <th>이미지</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th width="5%" style="text-align:center;" >삭제</th>
                            <th>No</th>
                            <th>제목</th>
                            <th>이미지</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($Ads as $Ad)
                        <tr> 
                            <td style="text-align:center;" ><input type="checkbox" name="deleteAd" value="{{ $Ad->id }}"/></td>
                            <td>{{ $Ad->id }}</td>
                            <td><a href='/admin/advertise/{{ $Ad->id }}'>{{ $Ad->title }} </a></td>
                            <td>{{ $Ad->image }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection