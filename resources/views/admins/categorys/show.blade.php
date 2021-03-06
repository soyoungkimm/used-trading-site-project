@extends('layouts.adminLayout')

@section('content')
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
                Category Details

            </div>
            <form>
            @csrf
                <input type="hidden" name="id" value="{{ $category-> id }}"> 
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">name(카테고리명)<span style="color : red;">*</span></th>
                                <td width="70%">
                                    <input class="form-control" id="inputTitle" name="categoryName" type="text" placeholder="제목" value="{{ $category->name }}" disabled/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>  
                <a class="btn btn-primary" style="margin:12px" href="/admin/category/{{ $category->id }}/edit">Edit </a>   
            </div>
        </form>
    </div>
</main>
@endsection