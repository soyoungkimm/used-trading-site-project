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
            var arrUsers = $('input[name=deleteId]:checked').serializeArray().map(function(item) {return item.value});
            if(arrUsers.length != 0){
                $.ajax({
                url:"/admin/users/arrUsers",
                type:"DELETE",
                data:{
                    'uidArray':arrUsers
                },
                success: function(result){
                    console.log(result);
                    location.reload();
                }
            });
            }else{
                alert('삭제할 회원을 선택해 주세요');
            }
           
        });
        
    });
</script>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Users</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                User List
            </div>
            <div class="card-body">
                <a class="btn btn-primary my-2" href="/admin/users/create"><i class="fas fa-user-plus"></i></a>
                <a class="btn btn-primary my-2" id="deleteUser"><i class="fas fa-user-minus"></i></a>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>삭제</th>
                            <th>이름</th>
                            <th>생일</th>
                            <th>전화번호</th>
                            <th>상점명</th>
                            <th>상점오픈일</th>
                            <th>상점방문</th>
                            <th>상품판매</th>
                            <th>택배발송</th>
                            <th>이미지</th>
                            <th>팔로워</th>
                            <th>팔로우</th>
                            <th>상품 개수</th>
                            <th>소개글</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>삭제</th>
                            <th>이름</th>
                            <th>생일</th>
                            <th>전화번호</th>
                            <th>상점명</th>
                            <th>상점오픈일</th>
                            <th>상점방문</th>
                            <th>상품판매</th>
                            <th>택배발송</th>
                            <th>이미지</th>
                            <th>팔로워</th>
                            <th>팔로잉</th>
                            <th>상품 개수</th>
                            <th>소개글</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($users as $user)
                        <tr> 
                            <td><input type="checkbox" name="deleteId" value="{{ $user->id }}"/></td>
                            <td><a href='/admin/users/{{ $user->id }}'>{{ $user->name }} </a></td>
                            <td>{{ $user->birth }}</td>
                            <td>{{ $user->tel }}</td>
                            <td>{{ $user->store_name }}</td>
                            <td>{{ $user->open_date }}</td>
                            <td>{{ $user->store_visit }} 회</td>
                            <td>{{ $user->sale_num }} 회</td>
                            <td>{{ $user->delivery_num }} 회</td>
                            <td>{{ $user->image }}</td>
                            <td>{{ $user->follower }}</td>
                            <td>{{ $user->following }}</td>
                            <td>{{ $user->good_num }}</td>
                            <td>{{ $user->introduction }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection