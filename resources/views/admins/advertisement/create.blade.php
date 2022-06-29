@extends('layouts.adminLayout')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function submitForm() {
            if (form1.title.length != 0 && form1.image.length != 0) {
                form1.submit();
            } else {
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
                    Add Ad
                </div>
                <form name="form1" action="/admin/advertise" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputTitle" name="title" type="text"
                                           placeholder="제목" value=""/>
                                    <label for="inputTitle">제목</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputLink" name="link" type="text"
                                           placeholder="링크" value=""/>
                                    <label for="inputLink">링크</label>
                                </div>
                                <label>광고 사진</label>
                                <div class="mb-3">
                                    <div style="width: 100%;">
                                        <div class="form-control"
                                             style="width:100%;height:200px;object-fit:scale-down;"></div>
                                    </div>
                                    <input class="form-control" id="inputImg" type="file" name="image" value=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary" style="margin:12px" onClick="submitForm();">save </a>
                </form>
            </div>
        </div>
    </main>
@endsection
