@extends('layouts.adminLayout')

@section('content')
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
                Tag Details

            </div>
            <form name="form1" method="POST" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="id" value="{{ $tag-> id }}"> 
                <div class="card-body">
                <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">name(태그명) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <div class="form-control">{{ $tag->name }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">goods_id(상품) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <div class="form-control">{{ $tag->good_title }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>  
                <a class="btn btn-primary" style="margin:12px" href="/admin/tags/{{ $tag->id }}/edit">Edit </a>   
            </div>
                
        </form>
    </div>
</main>
@endsection