<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeartGood;
use Illuminate\Support\Facades\DB;

class HeartGoodsController extends Controller
{
    public function store() {

        // 현재 로그인한 사용자 가져오기  <-- 임시
        $user_id = 2;

        // goods id 세팅
        $goods_id = request('goods_id');

        // 찜한 상품 저장        
        HeartGood::create([
            'goods_id'=>$goods_id,
            'user_id'=>$user_id
        ]);

        // goods 찜 개수 + 1
        DB::table('goods')->where('id', $goods_id)->increment('heart');
    }

    public function destroy() {

        // 현재 로그인한 사용자 가져오기  <-- 임시
        $user_id = 2;

        // goods id 세팅
        $goods_id = request('goods_id');

        // 찜한 상품 삭제
        DB::table('heart_goods')
            ->where('goods_id', $goods_id)
            ->where('user_id', $user_id)
            ->delete();

        // goods 찜 개수 - 1
        DB::table('goods')->where('id', $goods_id)->decrement('heart');
    }
}
