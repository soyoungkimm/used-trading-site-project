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
        <h1 class="mt-4">Ads</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Edit Ad
            </div>
            <form name="form1" action="/admin/advertise/{{ $ad->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <input type="hidden" name="id" value="{{ $ad-> id }}"> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputTel" type="text" name="title" placeholder="Title" value="{{ $ad -> title }}"/>
                                <label for="inputTel">전화번호</label>
                            </div>
                            <label >상점 사진</label>
                            <div class="mb-3">
                                <div style="width: 100%;">
                                    <div class = "form-control" style="width:100%;height:200px;">
                                    @if( !empty($ad->image) )
                                    <img src="/storage/images/ad/{{ $ad->image }}" style="width:100%;height:100%;object-fit:scale-down;"/>
                                    @endif
                                    </div>
                                </div>
                                <input class="form-control" id="inputImg" type="file" name="image" />
                                <label for="inputImg" >{{ $ad->image }}</label>
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