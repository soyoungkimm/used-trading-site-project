@extends('layouts.siteLayout')

@section('content')
    <link href="{{ asset('ksy/css/notices.css') }}" rel="stylesheet"/>
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <main class="m-auto">
                        <div class="flex-column">
                            <div class="pb-3">
                                <h3 class="font-weight-bold">{{ $notice->title }}</h3>
                            </div>
                            <div class="pb-5">
                                <h6 class="text-black-50">Created at - {{ $notice->writeday }}</h6>
                            </div>
                            <div>
                                {!! nl2br($notice->content) !!}
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </section>
@endsection
