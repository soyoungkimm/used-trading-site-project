@extends('layouts.adminLayout')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () {
            $("#deleteBtn").click(function () {
                var arrNotices = $('input[name=deleteNotice]:checked').serializeArray().map(function (item) {
                    return item.value
                });
                if (arrNotices.length != 0) {
                    $.ajax({
                        url: "/admin/notice/arrNotices",
                        type: "DELETE",
                        data: {
                            'adIdArr': arrNotices
                        },
                        success: function (result) {
                            console.log(result);
                            location.reload();
                        }
                    });
                } else {
                    alert('삭제할 공지를 선택해 주세요');
                }

            });

        });
    </script>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Notices</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Tables</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Notice List
                </div>
                <div class="card-body">
                    <a class="btn btn-primary my-2" href="/admin/notice/create"><i class="fas fa-bullhorn"></i> <i
                            class="fas fa-plus"></i></a>
                    <a class="btn btn-primary my-2" id="deleteBtn"><i class="fas fa-bullhorn"></i> <i
                            class="fas fa-minus"></i></a>
                    <table id="datatablesSimple">
                        <thead>
                        <tr>
                            <th width="5%" style="text-align:center;">삭제</th>
                            <th>No</th>
                            <th>제목</th>
                            <th>내용</th>
                            <th>작성일</th>
                            <th>이미지</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th width="5%" style="text-align:center;">삭제</th>
                            <th>No</th>
                            <th>제목</th>
                            <th>내용</th>
                            <th>작성일</th>
                            <th>이미지</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($notices as $notice)
                            <tr>
                                <td style="text-align:center;"><input type="checkbox" name="deleteNotice"
                                                                      value="{{ $notice->id }}"/></td>
                                <td>{{ $notice->id }}</td>
                                <td><a href='/admin/notice/{{ $notice->id }}'>{{ $notice->title }} </a></td>
                                <td>{!! Str::limit($notice->content, 30, '...') !!}</td>
                                <td>{{ $notice->writeday }}</td>
                                <td>{{ $notice->image }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
