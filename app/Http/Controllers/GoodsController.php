<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Good;
use App\Models\GoodsImage;
use App\Models\Tag;
use Illuminate\Support\Str;
use File;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 현재 로그인한 사용자 id가져오기
        $user_id = auth()->id();

        // 한 페이지당 보일 상품 개수
        $goods_num_per_page = 9;

        // ajax로 접근했을 때(페이지네이션)
        if ($request->ajax()) {

            $goods = GoodsController::ajax_make_goods_list();
            $goods = $goods->orderBy('goods.id', 'asc')->paginate($goods_num_per_page);

            // 시간 세팅
            foreach ($goods as $good)
                $good->writeday = parent::get_date_diff($good->writeday);

            // 찜한 상품인지 확인    
            $isHearts = array();
            foreach ($goods as $good) {
                if (DB::table('heart_goods')
                ->where('user_id', $user_id)
                ->where('goods_id', $good->id)
                ->exists()) {
                    array_push($isHearts, 0); // true
                }
                else {
                    array_push($isHearts, 1); // false
                }
            }
            
            return view('sites.goods.goodsResult', [
                'goods' => $goods,
                'isHearts' => $isHearts
            ]);
        }

        // goods 데이터 가져오기
        $goods = DB::table('goods')
            ->join('goods_images', 'goods_images.goods_id', '=', 'goods.id')
            ->select('goods.title', 'goods.price', 'goods.id', 'goods_images.name as goods_image', 'goods.writeday')
            ->where('goods_images.order', 0);
        if (request('search') != null) {
            if (request('selected_num') == 0){ // 상품명
                $goods->where('goods.title', 'like', '%' . request('search') . '%');
            }   
            else {  // 상점명
                $goods->join('users', 'users.id', '=', 'goods.user_id')
                        ->where('users.store_name', 'like', '%' . request('search') . '%');
            }
        }
        if (request('category') != null) {
            $goods->where('goods.category_id', request('category'));
            $sel_category_id_name = DB::table('categorys')->select('name')->where('id', request('category'))->first();
        }
        if (request('category_de') != null) {
            $goods->where('goods.category_de_id', request('category_de'));
            $sel_category_de_id_name = DB::table('category_des')->select('name')->where('id', request('category_de'))->first();
        }
        if (request('category_de_de') != null) {
            $goods->where('goods.category_de_de_id', request('category_de_de'));
            $sel_category_de_de_id_name = DB::table('category_de_des')->select('name')->where('id', request('category_de_de'))->first();
        }
        $goods = $goods->orderby('writeday', 'desc')
                        ->orderby('id', 'asc')
                        ->paginate($goods_num_per_page);
        
        // 시간 세팅
        foreach ($goods as $good)
            $good->writeday = parent::get_date_diff($good->writeday);
        
        // 찜한 상품인지 확인    
        $isHearts = array();
        foreach ($goods as $good) {
            if (DB::table('heart_goods')
            ->where('user_id', $user_id)
            ->where('goods_id', $good->id)
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

        return view('sites.goods.index', [
            'goods' => $goods,
            'isHearts' => $isHearts,
            'lately_goods' => $lately_goods,
            'search' => request('search'),
            'selected_num' => request('selected_num'),
            'sel_category_id' => request('category'),
            'sel_category_id_name' => isset($sel_category_id_name) ? $sel_category_id_name->name : null,
            'sel_category_de_id' => request('category_de'),
            'sel_category_de_id_name' => isset($sel_category_de_id_name) ? $sel_category_de_id_name->name : null,
            'sel_category_de_de_id' => request('category_de_de'),
            'sel_category_de_de_id_name' => isset($sel_category_de_de_id_name) ? $sel_category_de_de_id_name->name : null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sites.goods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //유효성 검사
        GoodsController::goods_validate();

        // 현재 로그인한 회원 id 가져오기  
        $user_id = auth()->id();

        // 값 세팅
        request('delivery_fee') == null ? $delivery_fee = 0 : $delivery_fee = request('delivery_fee');

        // 데이터 저장
        $good = Good::create([
            'title'=>request('goods_title'),
            'category_id'=>request('category_id'),
            'category_de_id'=>request('category_de_id'),
            'category_de_de_id'=>request('category_de_de_id'),
            'area'=>request('area'),
            'state'=>request('state'),
            'exchange'=>request('exchange'),
            'price'=>request('price'),
            'delivery_fee'=>$delivery_fee,
            'content'=>request('goods_content'),
            'number'=>request('number'),
            'heart'=>0,
            'view'=>0,
            'writeday'=>date('Y-m-d H:i:s', time()+(3600 * 9)),
            'user_id'=>$user_id,
            'sale_state'=>0
        ]);


        // 방금 생성한 상품 id 가져오기
        $goods_id = $good->id;


        // 이미지 순서 가져오기
        $order = request('order');
        $image_order = explode("|", $order);


        // goods_image 세션값 가져오기
        $items = session()->get('goods_image');


        // 세션에 저장된 파일명과 비교하여 이미지 정렬 + DB에 저장
        foreach ($items as $key=>$item) {
            for($i = 0; $i < count($image_order); $i++) {
                if ($image_order[$i] == $item) {
                    GoodsImage::create([
                        'goods_id'=>$goods_id,
                        'name'=>$item,
                        'order'=>$i
                    ]);
                    $image_order[$i] = '';
                    break;
                }
            }
        }

        
        // 세션 삭제
        $request->session()->forget('goods_image');


        // tag 저장
        $request_tag = request('tag');
        if($request_tag != '') {
            $tags = explode(" ", $request_tag);
            foreach ($tags as $tag) {
                Tag::create([
                    'goods_id'=>$goods_id,
                    'name'=>$tag
                ]);
            }
        }


        // 회원의 상품 개수 + 1
        DB::table('users')->where('id', $user_id)->increment('good_num');

        // 페이지 이동
        return redirect('/goods/'.$good->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 현재 로그인한 사용자 id가져오기
        $user_id = auth()->id();

        //goods 데이터 가져오기
        $good = DB::table('goods')
            ->join('categorys', 'goods.category_id', '=', 'categorys.id')
            ->leftjoin('category_des', 'goods.category_de_id', '=', 'category_des.id')
            ->leftjoin('category_de_des', 'goods.category_de_de_id', '=', 'category_de_des.id')
            ->join('users', 'goods.user_id', '=', 'users.id')
            ->select('goods.*', 'categorys.name as category_name', 'category_des.name as category_de_name', 
            'category_de_des.name as category_de_de_name', 'users.store_name as store_name', 'users.good_num as goods_num', 
            'users.follower as follower', 'users.introduction as introduction', 'users.image as user_image')
            ->where('goods.id', $id)
            ->first();

        // 시간 세팅
        $good->writeday = parent::get_date_diff($good->writeday);

        // goods 조회수 + 1
        if($good->user_id != $user_id){
            DB::table('goods')->where('id', $id)->increment('view');
        }

        // 이미지 데이터 가져오기
        $images = DB::table('goods_images')->select('name')->where('goods_id', $id)->orderby('order')->get();

        // tag 데이터 가져오기
        $tags = DB::table('tags')->select('name')->where('goods_id', $id)->orderby('id')->get();

        // question 데이터 가져오기
        $questions = DB::table('questions')
            ->join('users', 'questions.user_id', '=', 'users.id')
            ->select('questions.*', 'users.name as user_name', 'users.image as user_image')
            ->where('questions.goods_id', $id)
            ->get();

        // 시간 세팅
        foreach($questions as $question) {
            $question->writeday = parent::get_date_diff($question->writeday);
        }

        // question_comment 데이터 가져오기
        $question_comments = array();
        foreach ($questions as $question) {
            if ( DB::table('question_comments')
                    ->join('users', 'question_comments.user_id', '=', 'users.id')
                    ->select('question_comments.*', 'users.name as user_name', 'users.image as user_image')
                    ->where('question_comments.question_id', $question->id)
                    ->exists() 
                ) {
                    array_push($question_comments, DB::table('question_comments')
                        ->join('users', 'question_comments.user_id', '=', 'users.id')
                        ->select('question_comments.*', 'users.name as user_name', 'users.image as user_image')
                        ->where('question_comments.question_id', $question->id)
                        ->get());
            }
        }

        // 시간 세팅
        foreach ($question_comments as $question_commentv) {
            foreach ($question_commentv as $question_comment) {
                $question_comment->writeday = parent::get_date_diff($question_comment->writeday);
            }
        }

        // 총 상품문의 개수 구하기
        $total_question_num = count($questions) + count($question_comments);
        
        //사용자 goods 2개 가져오기 
        if(DB::table('goods')
        ->select('title', 'price', 'id')
        ->where('user_id', $good->user_id)
        ->where('id', '!=', $good->id)
        ->exists()){
            $user_goods = DB::table('goods')
            ->join('goods_images', 'goods_images.goods_id', '=', 'goods.id')
            ->select('goods.title', 'goods.price', 'goods.id', 'goods_images.name as goods_image')
            ->where('goods.user_id', $good->user_id)
            ->where('goods.id', '!=', $good->id)
            ->where('goods_images.order', 0)
            ->orderBy('goods.writeday', 'desc')
            ->limit(2)
            ->get();
        }
        else {
            $user_goods = null;
        }

        // 사용자 상점 후기 2개 가져오기
        // select * from reviews where goods_id = (select id from goods where user_id = $good->user_id) orderby writeday desc limit 2
        if (DB::table('goods')
        ->where('user_id', $good->user_id)
        ->exists()) {
            $temps = DB::table('goods')
            ->select('id')
            ->where('user_id', $good->user_id)
            ->get();

            $aaa = array();
            foreach($temps as $temp) {
                array_push($aaa, $temp->id);
            }

            $user_reviews = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->select('reviews.*', 'users.store_name', 'users.image')
            ->whereIn('goods_id', $aaa)
            ->orderBy('writeday', 'desc')
            ->limit(2)
            ->get();
        }
        else {
            $user_reviews = null;
        }

        // 시간 세팅
        foreach($user_reviews as $user_review) {
            $user_review->writeday = parent::get_date_diff($user_review->writeday);
        }

        // 찜한 상품인지 확인
        if (DB::table('heart_goods')
                ->where('user_id', $user_id)
                ->where('goods_id', $good->id)
                ->exists()) {
            
            $isHeart = 0; // true
        }
        else {
            $isHeart = 1; // false
        }

        // 팔로우한 상점인지 확인
        if (DB::table('follows')
                ->where('user_id', $user_id)
                ->where('store_id', $good->user_id)
                ->exists()) {
            
            $isFollow = 0; // true
        }
        else {
            $isFollow = 1; // false
        }


        // 연관 상품 가져오기
        if ($good->category_de_id != null) {
            if($good->category_de_de_id != null){
                $related_goods = DB::table('goods')
                    ->join('goods_images', 'goods_images.goods_id', '=', 'goods.id')
                    ->select('goods.title', 'goods.price', 'goods.id', 'goods_images.name as goods_image')
                    ->where('goods.category_id', $good->category_id)
                    ->where('goods.category_de_id', $good->category_de_id)
                    ->where('goods.category_de_de_id', $good->category_de_de_id)
                    ->where('goods_images.order', 0)
                    ->where('goods.id', '!=', $good->id)
                    ->orderBy('goods.writeday', 'desc')
                    ->limit(4)
                    ->get();
            }
            else {
                $related_goods = DB::table('goods')
                    ->join('goods_images', 'goods_images.goods_id', '=', 'goods.id')
                    ->select('goods.title', 'goods.price', 'goods.id', 'goods_images.name as goods_image')
                    ->where('goods.category_id', $good->category_id)
                    ->where('goods.category_de_id', $good->category_de_id)
                    ->where('goods_images.order', 0)
                    ->where('goods.id', '!=', $good->id)
                    ->orderBy('goods.writeday', 'desc')
                    ->limit(4)
                    ->get();
            }
        }
        else {
            $related_goods = DB::table('goods')
                ->join('goods_images', 'goods_images.goods_id', '=', 'goods.id')
                ->select('goods.title', 'goods.price', 'goods.id', 'goods_images.name as goods_image')
                ->where('goods.category_id', $good->category_id)
                ->where('goods_images.order', 0)
                ->where('goods.id', '!=', $good->id)
                ->orderBy('goods.writeday', 'desc')
                ->limit(4)
                ->get();
        }


        // 찜한 상품인지 아닌지 확인
        $rel_isHearts = array();
        foreach ($related_goods as $related_good) {
            if (DB::table('heart_goods')
            ->where('user_id', $user_id)
            ->where('goods_id', $related_good->id)
            ->exists()) {
                array_push($rel_isHearts, 0); // true
            }
            else {
                array_push($rel_isHearts, 1); // false
            }
        }


        // goods 값 세팅 
        $set_good = array();
        ($good->state == 0) ? $set_good['state'] = '중고상품' : $set_good['state'] = '새상품';
        ($good->exchange == 0) ? $set_good['exchange'] = '교환불가' : $set_good['exchange'] = '교환가능';
        ($good->delivery_fee == 0) ? $set_good['delivery_fee'] = '포함안함' : $set_good['delivery_fee'] = '포함';
        empty($good->category_de_id) ? $set_good['category_de_id'] = "없음" : $set_good['category_de_id'] = '['.$good->category_de_id.'] '.$good->category_de_name; 
        empty($good->category_de_de_id) ? $set_good['category_de_de_id'] = "없음" : $set_good['category_de_de_id'] = '['.$good->category_de_de_id.'] '.$good->category_de_de_name; 
        if ($good->sale_state == 0) $set_good['sale_state'] = '판매중';
        if ($good->sale_state == 1) $set_good['sale_state'] = '판매완료';
        else $set_good['sale_state'] = '예약중';

        
        // 페이지 이동
        return view('sites.goods.show',[
            'good' => $good,
            'images' => $images,
            'set_good' => $set_good,
            'tags' => $tags,
            'questions'=>$questions,
            'question_comments'=>$question_comments,
            'total_question_num'=>$total_question_num,
            'user_goods'=>$user_goods,
            'user_reviews'=>$user_reviews,
            'isHeart'=>$isHeart,
            'isFollow'=>$isFollow,
            'related_goods'=>$related_goods,
            'rel_isHearts'=>$rel_isHearts
        ]);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Good $good)
    {
        // 이미지 정보 가져오기
        $images = DB::table('goods_images')->select('name')->where('goods_id', $good->id)->orderby('order')->get();
        $image_names = array();
        $order = '';
        foreach ($images as $image) {
            $order .=  $image->name . '|';
            array_push($image_names, Str::after($image->name, '_'));

            // session에 파일 이름 저장(나중에 이미지 변경사항 파악, 정렬 하기 위함)
            request()->session()->push('goods_image', $image->name);
        }
        $order = trim($order, '|'); // 마지막 '|' 제거


        // tag 정보 가져오기
        $tags = DB::table('tags')->select('name')->where('goods_id', $good->id)->orderby('id')->get();
        $tag = '';
        foreach ($tags as $_tag) {
            $tag .=  $_tag->name . ' ';
        }
        $tag = trim($tag, ' '); // 마지막 ' ' 제거


        //페이지 이동
        return view('sites.goods.edit', [
            'good' => $good, 
            'order' => $order,
            'tag'=>$tag,
            'tags'=>$tags,
            'images'=>$images,
            'image_names'=>$image_names
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Good $good)
    {
        // 유효성 검사
        GoodsController::goods_validate();

        // 값 세팅
        request('delivery_fee') == null ? $delivery_fee = 0 : $delivery_fee = request('delivery_fee');

        // 내용 업데이트
        $good->update([
            'title'=>request('goods_title'),
            'category_id'=>request('category_id'),
            'category_de_id'=>request('category_de_id'),
            'category_de_de_id'=>request('category_de_de_id'),
            'area'=>request('area'),
            'state'=>request('state'),
            'exchange'=>request('exchange'),
            'price'=>request('price'),
            'delivery_fee'=>$delivery_fee,
            'content'=>request('goods_content'),
            'number'=>request('number')
        ]);


        // 이미지 순서 가져오기
        $order = request('order');
        $image_order = explode("|", $order);


        // goods_image 세션값 가져오기
        $items = session()->get('goods_image');


        // 세션에 저장된 파일명과 비교하여 이미지 정렬 + DB에 저장
        foreach ($items as $key=>$item) {
            for($i = 0; $i < count($image_order); $i++) {
                if ($image_order[$i] == $item) {

                    //db에 해당 이미지 있는지 확인 - 없으면
                    if (DB::table('goods_images')->where('name', $item)->where('goods_id', $good->id)->doesntExist()) {
                        GoodsImage::create([
                            'goods_id'=>$good->id,
                            'name'=>$item,
                            'order'=>$i
                        ]);
                    }
                    // 있으면
                    else {
                        GoodsImage::where('goods_id', $good->id)
                            ->where('name', $item)
                            ->update([
                                'order' => $i
                            ]);
                    }

                    $image_order[$i] = '';
                    break;
                }
            }
        }

        
        // 세션 삭제
        $request->session()->forget('goods_image');


        // tag 저장
        $request_tag = request('tag');
        if($request_tag != '') {
            $tags = explode(" ", $request_tag);
            foreach ($tags as $tag) {
                //db에 해당 태그 있는지 확인
                if (DB::table('tags')->where('name', $tag)->where('goods_id', $good->id)->doesntExist()) {
                    Tag::create([
                        'goods_id'=>$good->id,
                        'name'=>$tag
                    ]);
                }
            }
        }


        // 페이지 이동
        return redirect('/goods/'.$good->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Good $good)
    {
        // --------------------------- 연관된거 다 삭제 ------------------------------------
        // 가지고 있는 이미지 삭제
        $image_names = GoodsImage::select('name')->where('goods_id', $good->id)->get();
        foreach ($image_names as $image_name) {
            File::delete(public_path('storage/images/goods/'.$image_name));
        }
        DB::table('goods_images')->where('goods_id', $good->id)->delete();

        // 가지고 있는 태그 삭제
        DB::table('tags')->where('goods_id', $good->id)->delete();

        // 가지고 있는 question_comment 삭제
        DB::table('question_comments')->where('goods_id', $good->id)->delete();

        // 가지고 있는 question 삭제
        DB::table('questions')->where('goods_id', $good->id)->delete();

        // 가지고 있는 review_comment 삭제
        DB::table('review_comments')->where('goods_id', $good->id)->delete();

        // 가지고 있는 review 삭제
        DB::table('reviews')->where('goods_id', $good->id)->delete();

        // 찜한 상품 삭제
        DB::table('heart_goods')->where('goods_id', $good->id)->delete();
        // --------------------------------------------------------------------------------


        // goods 삭제
        $good->delete();

        // 페이지 이동
        return redirect('/goods');
    }

    public function ajax_delete_tag() {
        $goods_id = request('goods_id');
        $tag_name = request('tag_name');
        if(DB::table('tags')->where('name', $tag_name)->where('goods_id', $goods_id)->exists()) {
            DB::table('tags')->where('name', $tag_name)->where('goods_id', $goods_id)->delete();
        }
    }

    public function ajax_find_adress() {
        $adresses = DB::table('adress')->select('juso')->where('juso', 'like', '%' . request('search') . '%')->orderBy('id')->get();
        echo $adresses;
    }

    public function ajax_upload_image(Request $request) {
        //파일 업로드
        $file_names = GoodsController::file_upload($request);
        echo json_encode($file_names);
    }


    public function ajax_delete_image(Request $request) { 

        $file_name = request('file_name');
        
        // goods_image 세션값 가져오기
        $items = session()->get('goods_image');

        // 세션에 저장된 파일명과 비교하여 이미지 삭제
        foreach ($items as $key=>$item) {
            if ($file_name == $item) {
                // 업로드한 이미지 삭제
                File::delete(public_path('storage/images/goods/'.$item));

                // 세션 삭제
                $request->session()->pull('goods_image.'.$key);

                // 테이블에 있는 이미지도 삭제
                if(DB::table('goods_images')->where('name', $file_name)->exists()) {
                    DB::table('goods_images')->where('name', $file_name)->delete();
                }
            }
        }
        echo $file_name;
    }

    // 파일 업로드 함수
    private function file_upload($request) {

        $file_names = array();
        $upload_path = 'public/images/goods';
        if ($files = $request->file('image')) {

            foreach ($files as $file) {
                
                // 파일 이름 = '현재시간_파일명'
                $file_name = time().'_'.$file->getClientOriginalName();
                
                // 파일 업로드
                $file->storeAs($upload_path, $file_name);

                // session에 파일 이름 저장(나중에 이미지 정렬하기 위함)
                $request->session()->push('goods_image', $file_name);
                
                // return할 파일명들 배열에 넣음
                array_push($file_names, $file_name);
            }
        }

        return $file_names;
    }


    private function goods_validate(){

        if (request('category_de_id') != '') {
            request()->validate(['category_de_id'=>'required|integer|min:1']);
        }
        if (request('category_de_de_id') != '') {
            request()->validate(['category_de_de_id'=>'required|integer|min:1']);
        }

        request()->validate([   
            'goods_title'=>'required|max:50',
            'category_id'=>'integer|min:1',
            'area'=>'required',   
            'state'=>'required|integer|max:1',  
            'exchange'=>'required|integer|max:1', 
            'price'=>'required|integer|min:100',
            'delivery_fee'=>'integer|max:1',
            'goods_content'=>'required',
            'number'=>'required|integer',
            'order'=>'required'
        ]);
    }


    function ajax_make_goods_list() {
        $goods = DB::table('goods')
                ->join('goods_images', 'goods_images.goods_id', '=', 'goods.id')
                ->join('users', 'users.id', '=', 'goods.user_id')
                ->select('goods.title', 'goods.price', 'goods.id', 'goods_images.name as goods_image', 'goods.writeday')
                ->whereBetween('goods.price', array(request('min_price'), request('max_price')))
                ->where('goods_images.order', 0);
        if (request('search') != '') {
            if (request('selected_num') == 0){ // 상품명
                $goods->where('goods.title', 'like', '%' . request('search') . '%');
            }   
            else {  // 상점명
                $goods->where('users.store_name', 'like', '%' . request('search') . '%');
            }
        }
        if (request('category_id') != 0) 
            $goods->where('goods.category_id', request('category_id'));
        
        if (request('category_de_id') != 0) 
            $goods->where('goods.category_de_id', request('category_de_id'));
        
        if (request('category_de_de_id') != 0) 
            $goods->where('goods.category_de_de_id', request('category_de_de_id'));
        
        if (request('search_area') != '') 
            $goods->where('goods.area', 'like', '%' . request('search_area') . '%');
        
        if (request('state') != 3) 
            $goods->where('goods.state', request('state'));
        
        if (request('sale_state') != 3) 
            $goods->where('goods.sale_state', request('sale_state'));
        
        if (request('order') == 0)  // 최신순
            $goods->orderBy('goods.writeday', 'desc');
        else if (request('order') == 1)  // 저가순
            $goods->orderBy('goods.price', 'asc');
        else if (request('order') == 2) // 고가순
            $goods->orderBy('goods.price', 'desc');

        return $goods;
    }

    function ajax_get_goods_count() {
        $goods = GoodsController::ajax_make_goods_list();
        echo $goods->count();
    }
}
