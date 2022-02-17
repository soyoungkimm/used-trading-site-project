@extends('layouts.adminLayout')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Notices</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Notice Details

            </div>
            <form name="form1" method="POST" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="id" value="{{ $notice-> id }}"> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputTitle" name="title" type="text">{{ $notice->title }}</div>
                                        <label for="inputTitle">제목</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <div class="form-control" id="inputWriteday" name="writeday" type="date">{{ $notice->writeday }}</div>
                                        <label for="inputFollower">작성일</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>내용</label>
                                    <div class="form-control h-100" id="" name="content">{{ $notice->content }}</div>   
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-3">
                        <label >상점 사진</label>
                            <div class="mb-3">
                                <div style="width: 100%;">
                                    <div class = "form-control" style="width:100%;height:200px;">
                                    @if( !empty($notice->image) )
                                    <img src="/storage/notice/{{ $notice->image }}" style="width:100%;height:100%;object-fit:scale-down;"/>
                                    @endif
                                    </div>
                                </div>
                                <label for="inputImg" >{{ $notice->image }}</label>
                            </div>  
                        </div>
                    </div>
                </div>  
                <a class="btn btn-primary" style="margin:12px" href="/admin/notice/{{ $notice->id }}/edit">Edit </a>   
            </div>
                
        </form>
    </div>
</main>
@endsection