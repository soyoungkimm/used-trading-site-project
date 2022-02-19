@extends('layouts.adminLayout')

@section('content')
<link href="{{ asset('ksy/css/admin.css'); }}" rel="stylesheet" />
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <br>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body"><i class="fas fa-exchange-alt"></i>&nbsp;&nbsp;&nbsp;{{ number_format($total_transaction_num) }}</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <span class="small text-white stretched-link">총 거래량</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body"><i class="fas fa-won-sign"></i>&nbsp;&nbsp;&nbsp;{{ number_format($total_transaction_price) }}&nbsp;원</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <span class="small text-white stretched-link">총 거래액</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body"><i class="fas fa-arrow-down"></i>&nbsp;&nbsp;&nbsp;{{ number_format($total_revenue) }}&nbsp;원</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <span class="small text-white stretched-link">거래 수수료 수익</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body"><i class="fas fa-user"></i>&nbsp;&nbsp;&nbsp;{{ number_format($user_num) }}</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <span class="small text-white stretched-link">총 회원수</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header" id="trans_num_chart">
                        <i class="fas fa-chart-line"></i>&nbsp;
                        월별 거래량
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="400px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie"></i>&nbsp;
                        카테고리 별 상품 비율
                    </div>
                    <div class="card-body">
                        <canvas id="category_chart" height="400px"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-clipboard-list"></i>&nbsp;
                        할 일 목록 
                    </div>
                    <div class="card-body">
                        <div id="myDIV" class="td_header">
                            <h2>To Do List</h2>
                            <br>
                            <input type="text" id="td_Input" placeholder="제목을 작성하세요" />
                            <span class="addBtn">저장</span>
                            <form action="/admin/todo_lists/1" method="post" name="delete_form" style="display : none">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="all_delete" value="del"/>
                            </form>
                            <button type="button" id="delete_button" class="btn btn-danger all_delete_button">모두 삭제</button>
                        </div>
                        <ul id="td_ul">
                            @foreach ($to_do_lists as $to_do_list)
                                {{-- 수행함 --}}
                                @if ($to_do_list->state == 0) 
                                    <li class="td_li">{{ $to_do_list->content }}</li>
                                    <input type="hidden" value="{{ $to_do_list->id }}" />
                                {{-- 수행안함함 --}}
                                @else
                                    <li class="checked td_li">{{ $to_do_list->content }}</li>
                                    <input type="hidden" value="{{ $to_do_list->id }}" />
                                @endif
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-cloud-sun"></i>&nbsp;
                        현재 날씨
                    </div>
                    <div class="card-body">
                        <div class="seoul_weather">
                            <div class="weather_icon"></div><br>
                            <div class="weather_detail">
                                <div class="temp_min"></div>
                                <div class="temp_max"></div>
                                <div class="humidity"></div>
                                <div class="wind"></div>
                                <div class="cloud"></div>
                            </div>
                            <div class="weather_temp">
                                <div class="current_temp"></div>
                                <div class="weather_description"></div>
                                <div class="city"></div>
                            </div>
                        </div>
                        <br>
                        <div class="gyeonggi_weather">
                            <div class="g_weather_icon"></div><br>
                            <div class="weather_detail">
                                <div class="g_temp_min"></div>
                                <div class="g_temp_max"></div>
                                <div class="g_humidity"></div>
                                <div class="g_wind"></div>
                                <div class="g_cloud"></div>
                            </div>
                            <div class="weather_temp">
                                <div class="g_current_temp"></div>
                                <div class="g_weather_description"></div>
                                <div class="g_city"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
{{-- chart.js cdn 시작 --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
{{-- chart.js cdn 끝 --}}
<script src="{{ asset('ksy/js/admin.js'); }}"></script>
<script>
    var labels = <?php echo json_encode($labels)?>;
    var chart_vals = <?php echo json_encode($chart_vals)?>;
    var categorys = <?php echo json_encode($categorys)?>;
    make_chart(labels, chart_vals, categorys);
</script>
@endsection