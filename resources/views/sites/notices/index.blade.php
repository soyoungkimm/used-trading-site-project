@extends('layouts.siteLayout')

@section('content')
    <link href="{{ asset('ksy/css/notices.css') }}" rel="stylesheet"/>
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <main class="m-auto">
                        <h3 class="font-weight-bold pb-4">공지 사항</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr class="text-center">
                                <th class="col-10">제목</th>
                                <th class="col-auto">작성일</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notices as $notice)
                                <tr style="cursor: pointer">
                                    <td class="p-0">
                                        <a href="/notices/{{ $notice->id }}" id="title">
                                            <span>{{ $notice->title }}</span>
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $notice->writeday }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <small class="mt-6 mr-6 text-right font-weight-bold">{{ $notices->links() }}</small>
                    </main>
                </div>
            </div>
        </div>
    </section>
@endsection
