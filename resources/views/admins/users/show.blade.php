@extends('layouts.adminLayout')

@section('content')
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
                User Details

            </div>
            <form name="form1" method="POST" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="id" value="{{ $user-> id }}"> 
                <input type="hidden" name="idCheck" value="1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 ">
                                            <div class="form-control" id="inputUid"> {{ $user -> uid }}</div>
                                            <label for="inputUid">ID</label>
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                    <div class="form-control" id="inputUid"></div>
                                        <label for="inputPwd">PW</label>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user -> name }}</div>
                                        <label for="inputName">이름</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user -> birth }}</div>
                                        <label for="inputBirth">생일</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user -> tel }}</div>
                                        <label for="inputTel">전화번호</label>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user -> open_date }}</div>
                                        <label for="inputOpen">오픈일</label>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user -> store_name }}</div>
                                        <label for="inputStore">상점명</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user -> store_visit }}</div>
                                        <label for="inputVisit">상점방문횟수</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user -> sale_num }}</div>
                                        <label for="inputDelivery">상품판매횟수</label>
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user->rank == 0 ? '일반회원' : '관리자' }}</div>
                                        <label for="inputDelivery">관리자여부</label>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user -> follower }}</div>
                                        <label for="inputFollower">팔로워</label>
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user -> following }}</div>
                                        <label for="inputFollow">팔로우</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user -> good_num }}</div>
                                        <label for="inputProductNum">상품개수</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputUid">{{ $user -> delivery_num }}</div>
                                        <label for="inputDelivery">택배발송</label>
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="col-md-12">
                                <label for="inputIntro">소개글</label>
                                <div class="form-floating mb-3">
                                    <div class="form-control" id="inputUid">{{ $user -> introduction }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                <label >상점 사진</label>
                                    <div class="mb-3">
                                        <div style="width: 100%;">
                                            <div class = "form-control" style="width:100%;height:200px;">
                                            @if( !empty($user->image) )
                                            <img src="/storage/users/{{ $user->image }}" style="width:100%;height:100%;object-fit:scale-down;"/>
                                            @endif
                                            </div>
                                        </div>
                                        <label for="inputImg" >{{ $user->image }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <a class="btn btn-primary" style="margin:12px" href="/admin/users/{{ $user->id }}/edit">Edit </a>   
            </div>
                
        </form>
    </div>
</main>
@endsection