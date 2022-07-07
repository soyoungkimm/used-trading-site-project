<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Review;
use App\Models\Follow;
use App\Models\HeartGood;
use App\Models\Question;
use App\Models\Good;
use App\Models\GoodsImage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DateTime;

class ShopController extends Controller{

    public function main(Request $request){//메인페이지 반환

        $user = User::where('id',auth()->id())->first();

        //상점오픈일 계산
        $today = new DateTime();
        $open_date = new DateTime($user->open_date);
        $open_day = date_diff($open_date,$today)->d; //day만 저장

        //판매상품 정보 가져오기, 이미지는 첫번째만, 카테고리명 추가
        $goods = Good::where('user_id',auth()->id())
            ->join('goods_images', 'goods.id', '=', 'goods_images.goods_id')
            ->join('categorys', 'goods.category_id', '=', 'categorys.id')
            ->select('goods.id as goods_id','goods.*', 'goods_images.*', 'categorys.id as categorys_id', 'categorys.name as categorys_name')
            ->where('goods_images.order',0)
            ->get(); 

        //게시 시간
        foreach($goods as $good){
            $good->writeday = parent::get_date_diff($good->writeday);  
        }

        //카테고리명 중복 제거 
        $cate_num = [];
        $cate_arr = [];
        $i = 0;
        foreach($goods as $good){
            array_push($cate_num, $good->categorys_name);
            $cate_num = array_unique($cate_num);
            if(count($cate_num)>$i){
                $temp = array("categorys_id" => $good->categorys_id, "categorys_name" => $good->categorys_name);
                array_push($cate_arr, $temp);
                $i++;
            }
        }


        //찜한 상품 가져오기
        $hearts = HeartGood::where('heart_goods.user_id',auth()->id())
            ->join('goods', 'heart_goods.goods_id', '=', 'goods.id')
            ->join('goods_images', 'goods.id', '=', 'goods_images.goods_id')
            ->select('goods.id as goods_id', 'goods.*', 'goods_images.*')
            ->where('goods_images.order',0)
            ->get(); 

        //찜한 상품의 게시시간 계산
        foreach($hearts as $heart){
            $heart->writeday = parent::get_date_diff($heart->writeday);  
        }

        //상점문의 가져오기
        $questions = Question::where('user_id',auth()->id())->get(); 
        

        //팔로잉 목록
        $follows = Follow::where('user_id',auth()->id())
            ->join('users','follows.store_id','=', 'users.id')
            ->get();

        //팔로워 목록
        $followers = Follow::where('store_id',auth()->id())
            ->join('users','follows.user_id', '=', 'users.id')
            ->get(); 

        //맞팔 확인
        $isfollow = [];
        foreach($followers as $follower){
            if(DB::table('follows')
                ->where('user_id',auth()->id())
                ->where('store_id',$follower->user_id)
                ->exists()){
                array_push($isfollow, 1);//true
            }else{
                array_push($isfollow, 0);//false
            }
        }

        //내상점 평점
        $stars = Review::where('user_id', auth()->id())->get()->avg('star');
        if(empty($stars)) $stars=0;

        //후기 별점
        $reviews = Review::where('goods.user_id',auth()->id())
            ->join('goods','goods.id', '=', 'reviews.goods_id')
            ->join('users','users.id', '=', 'reviews.user_id')
            ->select('goods.id as goods_id', 'goods.content as goods_content', 'goods.*', 'reviews.*', 'users.id as user_id' , 'users.*')
            ->get();

        //후기 게시시간 계산
        foreach($reviews as $review){
            $review->writeday = parent::get_date_diff($review->writeday);  
        }

        return view('sites.shop.main',[
            'open_day' => $open_day,
            'user'      => $user, 
            'goods'     => $goods,
            'questions' => $questions,
            'hearts'    => $hearts,
            'follows'   => $follows,
            'followers' => $followers,
            'cate_arrs' => $cate_arr,
            'stars'     => $stars,
            'reviews'   => $reviews,
            'isfollow'  => $isfollow
        ]);

    }

    public function ajax_edit_storename(Request $request){
        $user = User::find($request->id);
        $user->update([
            'store_name'=> $request->store_name
        ]);

        $user = User::find($request->id);

        return $user->store_name;
    }

    public function ajax_edit_intro(Request $request){
        $user = User::find($request->id);
        $user->update([
            'introduction'=> $request->intro
        ]);

        $user = User::find($request->id);

        return $user->introduction;
    }

    public function ajax_hearts(Request $request){

        //삭제요청일 경우
        if($request->id_arr != 0){
            foreach($request->id_arr as $id){
                HeartGood::where('goods_id',$id)->delete();
            }
        }
        
        //찜한 상품 가져오기
        $hearts = HeartGood::where('heart_goods.user_id',$request->id)
            ->join('goods', 'heart_goods.goods_id', '=', 'goods.id')
            ->join('goods_images', 'goods.id', '=', 'goods_images.goods_id')
            ->select('goods.id as goods_id', 'goods.*', 'goods_images.*')
            ->where('goods_images.order',0); 

        if($request->num == 0){ //최신순
            $hearts = $hearts->orderby('goods.writeday','desc')->get();

        }else if($request->num == 1){//저가순
            $hearts = $hearts->orderby('price','asc')->get();

        }else if($request->num == 2){//고가순
            $hearts = $hearts->orderby('price','desc')->get();

        }else{//미정렬
            $hearts = $hearts->get();
        }

        //찜한 상품의 게시 시간계산
        foreach($hearts as $heart){
            $heart->writeday = parent::get_date_diff($heart->writeday);  
        }
        


        return view('sites.shop.heartsResult', [
            'hearts' => $hearts,
        ]);
    }

    public function ajax_goods(Request $request){
        
        //찜한 상품 가져오기
        //판매상품 정보 가져오기, 이미지는 첫번째만, 카테고리명 추가
        $goods = Good::where('user_id',$request->id)
            ->join('goods_images', 'goods.id', '=', 'goods_images.goods_id')
            ->join('categorys', 'goods.category_id', '=', 'categorys.id')
            ->select('goods.*', 'goods_images.*', 'categorys.id as categorys_id', 'categorys.name as categorys_name')
            ->where('goods_images.order',0); 

        if($request->num == 0){ //최신순
            $goods = $goods->orderby('writeday','desc')->get();

        }else if($request->num == 1){//저가순
            $goods = $goods->orderby('price','asc')->get();

        }else if($request->num == 2){//고가순
            $goods = $goods->orderby('price','desc')->get();

        }else{//미정렬
            $goods = $goods->get();
        }

        //게시 시간
        foreach($goods as $good){
            $good->writeday = parent::get_date_diff($good->writeday);  
        }

        //카테고리명 중복 제거 
        $cate_num = [];
        $cate_arr = [];
        $i = 0;
        foreach($goods as $good){
            array_push($cate_num, $good->categorys_name);
            $cate_num = array_unique($cate_num);
            if(count($cate_num)>$i){
                $temp = array("categorys_id" => $good->categorys_id, "categorys_name" => $good->categorys_name);
                array_push($cate_arr, $temp);
                $i++;
            }
        }
        
        return view('sites.shop.goodsResult', [
            'goods' => $goods,
            'cate_arrs' => $cate_arr
        ]);
    }

    public function manage(){

        $goods = DB::table("goods")
            ->select('goods.id as good_id', 'goods.*', DB::raw('count(questions.id) as questions_cnt'), "goods_images.name as image")
            ->leftjoin('questions', 'goods.id', '=',  'questions.goods_id')
            ->join('goods_images', 'goods.id', '=', 'goods_images.goods_id')
            ->where('goods_images.order','0')
            ->where('goods.user_id',auth()->id())
            ->groupBy('goods.id')
            ->orderby('goods.sale_state','asc')
            ->orderby('goods.writeday','desc')
            ->get();

        $payments = DB::table('payments')
            ->join('goods', 'payments.goods_id', '=', 'goods.id')
            ->join('goods_images', 'goods.id', '=', 'goods_images.goods_id')
            ->select('payments.*', 'goods.title as goods_title', "goods.id as good_id", "goods.*", "goods_images.name as pic")
            ->where('goods_images.order','0')
            ->where('payments.buy_user_id', auth()->id())
            ->get();

        return view('sites.shop.manage',[
            'goods' => $goods,
            'payments'   => $payments
        ]);
    }

    public function ajax_saleStatus(Request $request){
        
        $good = Good::where('goods.id',$request->id);

        $good->update([
            'sale_state'=> $request->sale_state
        ]);

        return 1;
    }


    public function ajax_managing(Request $request){

        $goods = DB::table("goods")
        ->select('goods.id as good_id', 'goods.*', DB::raw('count(questions.id) as questions_cnt'), "goods_images.name as image")
        ->leftjoin('questions', 'goods.id', '=',  'questions.goods_id')
        ->join('goods_images', 'goods.id', '=', 'goods_images.goods_id')
        ->where('goods_images.order','0')
        ->where('goods.user_id',$request->id)
        ->groupBy('goods.id')
        ->orderby('goods.sale_state','asc')
        ->orderby('goods.writeday','desc');

        $goods->where('goods.title', 'like', '%' . $request->search . '%');
        if($request->state == 'all'){
            $goods = $goods->get();
        }else{
            $goods = $goods->where('goods.sale_state', '=', $request->state)->get();
        }

        return view('sites.shop.manageResult',[
            'goods' => $goods
        ]);
    }

    public function ajax_payHistory(Request $req){

        $payments = DB::table('payments')
            ->join('goods', 'payments.goods_id', '=', 'goods.id')
            ->join('goods_images', 'goods.id', '=', 'goods_images.goods_id')
            ->select('payments.*', 'goods.title as goods_title', "goods.id as good_id", "goods.*", "goods_images.name as pic")
            ->where('goods_images.order','0');

        if($req->type == "buy"){
            $payments = $payments
                ->where('payments.buy_user_id', auth()->id())
                ->get();
        }
        else if($req->type == "sale"){
            $payments = $payments
                ->where('payments.sale_user_id', auth()->id())
                ->get();
        }

        return view('sites.shop.payHistorys',[
            'payments' => $payments
        ]);
    }
}