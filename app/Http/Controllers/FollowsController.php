<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\DB;

class FollowsController extends Controller
{
    public function store() {

        // 현재 로그인한 사용자 가져오기  <-- 임시
        $user_id = 2;

        // store id 세팅
        $store_id = request('store_id');

        // 찜한 상품 저장        
        Follow::create([
            'user_id'=>$user_id,
            'store_id'=>$store_id
        ]);

        // 상점 팔로워 개수 + 1
        DB::table('users')->where('id', $store_id)->increment('follower');

        // 회원 팔로잉 개수 + 1
        DB::table('users')->where('id', $user_id)->increment('following');
    }

    public function destroy() {

        // 현재 로그인한 사용자 가져오기  <-- 임시
        $user_id = 2;

        // store id 세팅
        $store_id = request('store_id');

        // 찜한 상품 삭제
        DB::table('follows')
            ->where('user_id', $user_id)
            ->where('store_id', $store_id)
            ->delete();

        // users 팔로워 개수 - 1
        DB::table('users')->where('id', $store_id)->decrement('follower');

        // 회원 팔로잉 개수 - 1
        DB::table('users')->where('id', $user_id)->decrement('following');
    }
}
