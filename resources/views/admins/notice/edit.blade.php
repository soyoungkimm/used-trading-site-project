@extends('layouts.adminLayout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    function submitForm(){
        if(form1.title.length != 0 && form1.image.length != 0){
            form1.submit();
        }
        else{
            alert("모든 값은 필수사항 입니다");
        }
    }
</script>

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
                Edit Notice
            </div>
            <form name="form1" action="/admin/notice/{{ $notice->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <input type="hidden" name="id" value="{{ $notice-> id }}"> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputTitle" name="title" type="text" placeholder="제목" value="{{ $notice->title }}" />
                                        <label for="inputTitle">제목</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputWriteday" name="writeday" type="date" placeholder="작성일" value="{{ $notice->writeday }}" />
                                        <label for="inputWriteday">작성일</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <label>내용</label>
                                <textarea class="form-control h-100" id="" name="content">{{ $notice->content }}</textarea>   
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label >상점 사진</label>
                            <div class="mb-3">
                                <div style="width: 100%;">
                                    <div class = "form-control" style="width:100%;height:200px;">
                                    @if( !empty($notice->image) )
                                    <img src="/storage/images/ad/{{ $notice->image }}" style="width:100%;height:100%;object-fit:scale-down;"/>
                                    @endif
                                    </div>
                                </div>
                                <input class="form-control" id="inputImg" type="file" name="image" />
                                <label for="inputImg" >{{ $notice->image }}</label>
                            </div>
                        </div>
                    </div>
                </div>  
                <a class="btn btn-primary" style="margin:12px" onClick="submitForm();">save </a>   
            </div>
            
        </form>
    </div>
</main>
@endsection