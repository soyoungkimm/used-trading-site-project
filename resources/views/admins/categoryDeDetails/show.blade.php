@extends('layouts.adminLayout')

@section('content')
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
                Category Details
            </div>
            <form>
            @csrf
                <input type="hidden" name="id" value="{{ $categorys->id }}"> 
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">category_de_id(카테고리2)<span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control" id="inputTitle" name="categoryId" type="text" placeholder="제목" value="{{ $categorys->categoryDe_name }}" disabled/>
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">name(카테고리3)<span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control" id="inputTitle" name="categoryDeName" type="text" placeholder="제목" value="{{ $categorys->name }}" disabled/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>  
                <a class="btn btn-primary" style="margin:12px" href="/admin/category-de-de/{{ $categorys->id }}/edit">Edit </a>   
            </div>
        </form>
    </div>
</main>
@endsection