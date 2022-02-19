@extends('layouts.adminLayout')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Heart Goods</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Heart Goods Details

            </div>
            <form name="form1" method="POST" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="id" value="{{ $alarm-> id }}"> 
                <div class="card-body">
                <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%">content(알람 내용) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <div class="form-control">{{ $alarm->content }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">writeday(날짜) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <div class="form-control">{{ $alarm->writeday }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">goods_id(상품) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <div class="form-control">{{ $alarm->good_title }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">user_id(찜한 회원) <span style="color : red;">*</span></th>
                                <td width="70%">
                                    <div class="form-control">{{ $alarm->user_name }}</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>  
                <a class="btn btn-primary" style="margin:12px" href="/admin/alarm/{{ $alarm->id }}/edit">Edit </a>   
            </div>
                
        </form>
    </div>
</main>
@endsection