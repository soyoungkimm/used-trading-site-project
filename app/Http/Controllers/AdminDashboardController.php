<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function __invoke() {
        
        // 할일 목록 리스트 가져오기
        $to_do_lists = DB::table('to_do_lists')->orderBy('id')->get();

        // 총 거래량 가져오기
        $total_transaction_num = DB::table('goods')->count();

        // 총 거래액 가져오기
        $total_transaction_price = DB::table('goods')->sum('price');

        // 총 거래 수수료 수익 가져오기
        // 총 수익 : 성공한 거래 하나당 200원(수수료)
        $total_revenue = 
        (DB::table('goods')->where('sale_state', 1)->count()) * 200;

        // 총 회원 수 가져오기
        $user_num = DB::table('users')->count();


        // chart.js 월별 거래량 값 가져오기
        // label에 들어갈 값(현재 월 ~ 11달 전 총 12개)
        $labels = array();
        for ($i = -12; $i < 0; $i++) {
            array_push($labels, date("Y-m", strtotime($i." month", time())));
        }
        array_push($labels, date('Y-m'));
        // data에 들어갈 값(월별 거래량)
        $chart_vals = array();
        foreach ($labels as $label) {
            $arr = explode("-", $label);
            $year = $arr[0];
            $month = $arr[1];
            array_push($chart_vals, DB::table('goods')->whereYear('writeday', $year)->whereMonth('writeday', $month)->count());
        }

        // chart.js 카테고리별 상품 비율 값 가져오기
        $mm_categorys = DB::table('goods')
        ->join('categorys', 'goods.category_id', '=', 'categorys.id')
        ->select(DB::raw('count(*) as goods_count, categorys.name as category_name'))
        ->groupBy('category_name')
        ->orderBy('categorys.id')
        ->get();

        //페이지 이동 
        return view('admins.dashboard', [ 
            'mm_categorys' => $mm_categorys,
            'to_do_lists' => $to_do_lists,
            'user_num' => $user_num,
            'total_transaction_num' => $total_transaction_num,
            'total_transaction_price' => $total_transaction_price,
            'total_revenue' => $total_revenue,
            'labels'=>$labels,
            'chart_vals' => $chart_vals
        ]); 
    } 
}
