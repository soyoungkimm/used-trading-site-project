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
        if(form1.categoryDeDeName.length != 0 && form1.categoryDeId.value != 0){
            form1.submit();
        }
        else{
            alert("모든 값은 필수사항 입니다");
        }
    }
   
</script>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">CategoryDeDe</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Add CategoryDeDe
            </div>
            <form name="form1" action="/admin/category-de-de" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">category_de_id(카테고리2)<span style="color : red;">*</span></th>
                                <td width="70%">
                                <select class="form-select @error('categorys') is-invalid @enderror" name="categoryDeId" required>
                                    <option value="0" selected>상품을 고르세요</option>
                                    {{-- 유효성 검사 걸린 경우 --}}
                                    @if (old('categorys') != '') 
                                        @foreach ($categorys as $category)
                                            <option value="{{ $category->id }}">[{{ $category->id }}] {{ $category->name }}</option> 
                                        @endforeach
                                    {{-- 아닌 경우 --}}
                                    @else
                                        @foreach ($categorys as $category)
                                            <option value="{{ $category->id }}">[{{ $category->id }}] {{ $category->name }}</option> 
                                        @endforeach
                                    @endif
                                </select>
                                @error('categorys')
                                    <div style="margin-top : 5px!important; color : #dc3545;">카테고리를 고르세요</div>
                                @enderror
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">name(카테고리3)<span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control" id="inputTitle" name="categoryDeDeName" type="text" placeholder="제목" value="" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>  
                <a class="btn btn-primary" style="margin:12px" onClick="submitForm();">save </a>   
            </div>                            
        </form>
    </div>
</main>
@endsection