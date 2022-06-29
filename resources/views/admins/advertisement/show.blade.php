@extends('layouts.adminLayout')

@section('content')
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
                    Ad Details

                </div>
                <form name="form1" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $ad-> id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-floating mb-3">
                                    <div class="form-control" id="inputTitle">{{ $ad -> title }}</div>
                                    <label for="inputTitle">제목</label>
                                </div>
                                <div class="col-md-6">
                                    <label>상점 사진</label>
                                    <div class="mb-3">
                                        <div style="width: 100%;">
                                            <div class="form-control" style="width:100%;height:200px;">
                                                @if( !empty($ad->image) )
                                                    <img src="{{ asset("storage/images/ad/".$ad->image) }}"
                                                         style="width:100%;height:100%;object-fit:scale-down;"/>
                                                @endif
                                            </div>
                                        </div>
                                        <label for="inputImg">{{ $ad->image }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary" style="margin:12px" href="/admin/advertise/{{ $ad->id }}/edit">Edit </a>
                </form>
            </div>
        </div>
    </main>
@endsection
