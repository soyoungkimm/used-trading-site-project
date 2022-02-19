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
            var arralarms = $('input[name=deleteAlarms]:checked').serializeArray().map(function(item) {return item.value});
            if(arralarms.length != 0){
                $.ajax({
                url:"/admin/alarm/arralarms",
                type:"DELETE",
                data:{
                    'arrAlarms':arralarms
                },
                success: function(result){
                    console.log(result);
                    location.reload();
                }
            });
            }else{
                alert('삭제할 알람을 선택해 주세요');
            }
           
        });
        
    });
</script>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Alarms</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Alarms List
            </div>
            <div class="card-body">
                <a class="btn btn-primary my-2" href="/admin/alarm/create"><i class="fas fa-bell"></i> <i class="fas fa-plus"></i></a>
                <a class="btn btn-primary my-2" id="delteBtn"><i class="fas fa-bell"></i> <i class="fas fa-minus"></i></a>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center;" >삭제</th>
                            <th>No</th>
                            <th>내용</th>
                            <th>날짜</th>
                            <th>상품</th>
                            <th>회원</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th width="5%" style="text-align:center;" >삭제</th>
                            <th>No</th>
                            <th>내용</th>
                            <th>날짜</th>
                            <th>상품</th>
                            <th>회원</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($alarms as $alarm)
                        <tr> 
                            <td style="text-align:center;" ><input type="checkbox" name="deleteAlarms" value="{{ $alarm->id }}"/></td>
                            <td>{{ $alarm->id }}</td>
                            <td><a href='/admin/alarm/{{ $alarm->id }}'>{{ $alarm->content }} </a></td>
                            <td>{{ $alarm->writeday }}</td>
                            <td>{{ $alarm->good_title }}</td>
                            <td>{{ $alarm->user_name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection