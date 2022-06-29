<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function main() {

        // 현재 로그인한 사용자 id가져오기
        $user_id = auth()->id();

        // 랜덤으로 goods 데이터 가져오기(오늘의 추천 상품)
        $today_goods = DB::table('goods')
            ->join('goods_images', 'goods_images.goods_id', '=', 'goods.id')
            ->select('goods.title', 'goods.price', 'goods.id', 'goods_images.name as goods_image', 'goods.writeday')
            ->where('goods_images.order', 0)
            ->inRandomOrder()
            ->limit(16)
            ->get();

        // 시간 세팅
        foreach ($today_goods as $today_good)
            $today_good->writeday = parent::get_date_diff($today_good->writeday);

        // 찜한 상품인지 확인
        $isHearts = array();
        foreach ($today_goods as $today_good) {
            if (DB::table('heart_goods')
            ->where('user_id', $user_id)
            ->where('goods_id', $today_good->id)
            ->exists()) {
                array_push($isHearts, 0); // true
            }
            else {
                array_push($isHearts, 1); // false
            }
        }

        // 최근에 올라온 상품 가져오기
        $lately_goods = DB::table('goods')
            ->join('goods_images', 'goods_images.goods_id', '=', 'goods.id')
            ->select('goods.title', 'goods.price', 'goods.id', 'goods_images.name as goods_image', 'goods.writeday')
            ->where('goods_images.order', 0)
            ->orderby('writeday', 'desc')
            ->orderby('id', 'asc')
            ->limit(6)
            ->get();

        // 시간 세팅
        foreach ($lately_goods as $lately_good)
            $lately_good->writeday = parent::get_date_diff($lately_good->writeday);

        // 찜 개수 높은 상품 가져오기
        $heart_high_goods = DB::table('goods')
            ->join('goods_images', 'goods_images.goods_id', '=', 'goods.id')
            ->select('goods.title', 'goods.price', 'goods.id', 'goods_images.name as goods_image', 'heart')
            ->where('goods_images.order', 0)
            ->orderby('heart', 'desc')
            ->orderby('id', 'asc')
            ->limit(6)
            ->get();


        $has_review_goods = DB::table('reviews')
            ->select('goods_id')
            ->distinct()
            ->get();

        $_arr = array();
        foreach($has_review_goods as $has_review_good) {
            array_push($_arr, $has_review_good->goods_id);
        }

        // 후기 좋은 상품 가져오기(review 있는 goods를 별점 순으로 정렬해서 가져옴)
        $star_high_goods = DB::table('goods')
            ->join('goods_images', 'goods_images.goods_id', '=', 'goods.id')
            ->join('reviews', 'reviews.goods_id', '=', 'goods.id')
            ->select('goods.title', 'goods.price', 'goods.id', 'goods_images.name as goods_image', 'reviews.star as star')
            ->where('goods_images.order', 0)
            ->whereIn('goods.id', $_arr)
            ->orderBy('reviews.star', 'desc')
            ->orderby('goods.id', 'asc')
            ->distinct()
            ->limit(6)
            ->get();

        $ads = Advertisement::on()->get();

        return view('sites.main', [
            'today_goods' => $today_goods,
            'isHearts' => $isHearts,
            'lately_goods' => $lately_goods,
            'heart_high_goods'=>$heart_high_goods,
            'star_high_goods'=>$star_high_goods,
            'ads' => $ads
        ]);
    }
}
