@extends('layouts.adminLayout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
//@@@@@@@@@폼확인 되는건지 다시 확인@
    function submitForm(){
        if(form1.name.length !=0){
            form1.submit();
        }
        else{
            alert("모든 값은 필수사항 입니다");
        }
    }
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
                Edit Category
            </div>
            <form name="form1" action="/admin/category/{{ $category->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <input type="hidden" name="id" value="{{ $category-> id }}"> 
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">name(카테고리명)<span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control" id="inputTitle" name="categoryName" type="text" placeholder="제목" value="{{ $category->name }}" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>  
                <a class="btn btn-success" style="margin:12px" onClick="submitForm();">save </a>   
            </div>
            
        </form>
    </div>
</main>
@endsection