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
        if(form1.name.length != 0 && form1.goods_id.value != 0){
            form1.submit();
        }
        else{
            alert("모든 값은 필수사항 입니다");
        }
    }
   
</script>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tags</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tag Add
            </div>
            <form name="form1" action="/admin/tags" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">태그명<span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control" id="inputName" name="name" type="text" placeholder="제목" value="" />
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">상품명<span style="color : red;">*</span></th>
                                <td width="70%">
                                    <select class="form-select @error('user_id') is-invalid @enderror" name="goods_id" required>
                                        <option value="0" selected>상품을 고르세요</option>
                                        {{-- 유효성 검사 걸린 경우 --}}
                                        @if (old('goods_id') != '') 
                                            @foreach ($goods as $good)
                                                <option value="{{ $good->id }}">[{{ $good->id }}] {{ $good->title }}</option> 
                                            @endforeach
                                        {{-- 아닌 경우 --}}
                                        @else
                                            @foreach ($goods as $good)
                                                <option value="{{ $good->id }}">[{{ $good->id }}] {{ $good->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('user_id')
                                        <div style="margin-top : 5px!important; color : #dc3545;">상품을 고르세요</div>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>  
                <a class="btn btn-success" style="margin:12px" onClick="submitForm();">저장 </a>    
            </div>                            
        </form>
    </div>
</main>
@endsection