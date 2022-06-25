<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\GoodsImage;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use File;


class AdminGoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // goods 리스트 가져오기
        $goods = DB::table('goods')
            ->join('categorys', 'goods.category_id', '=', 'categorys.id')
            ->leftjoin('category_des', 'goods.category_de_id', '=', 'category_des.id')
            ->leftjoin('category_de_des', 'goods.category_de_de_id', '=', 'category_de_des.id')
            ->join('users', 'goods.user_id', '=', 'users.id')
            ->select('goods.*', 'categorys.name as category_name', 'category_des.name as category_de_name', 
            'category_de_des.name as category_de_de_name', 'users.name as user_name')
            ->orderBy('goods.id')
            ->get();

        
        // 페이지 이동
        return view('admins.goods.index', ['goods' => $goods]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 데이터 가져오기
        $categorys = DB::table('categorys')->get();
        $category_des = DB::table('category_des')->get();
        $category_de_des = DB::table('category_de_des')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        
        // 페이지 이동 
        return view('admins.goods.create', [ 
            'categorys' => $categorys,
            'category_des' => $category_des,
            'category_de_des' => $category_de_des,
            'users' => $users
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 유효성 검사
        AdminGoodsController::goods_validate();

        // 데이터 저장
        $good = Good::create([
            'title'=>request('title'),
            'category_id'=>request('category_id'),
            'category_de_id'=>request('category_de_id'),
            'category_de_de_id'=>request('category_de_de_id'),
            'area'=>request('area'),
            'state'=>request('state'),
            'exchange'=>request('exchange'),
            'price'=>request('price'),
            'delivery_fee'=>request('delivery_fee'),
            'content'=>request('content'),
            'number'=>request('number'),
            'heart'=>request('heart'),
            'view'=>request('view'),
            'writeday'=>request('writeday'),
            'user_id'=>request('user_id'),
            'sale_state'=>request('sale_state')
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
        DB::table('users')->where('id', request('user_id'))->increment('good_num');


        // 페이지 이동
        return redirect('/admin/goods/'.$good->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // goods 데이터 가져오기
        $good = DB::table('goods')
            ->join('categorys', 'goods.category_id', '=', 'categorys.id')
            ->leftjoin('category_des', 'goods.category_de_id', '=', 'category_des.id')
            ->leftjoin('category_de_des', 'goods.category_de_de_id', '=', 'category_de_des.id')
            ->join('users', 'goods.user_id', '=', 'users.id')
            ->select('goods.*', 'categorys.name as category_name', 'category_des.name as category_de_name', 
            'category_de_des.name as category_de_de_name', 'users.name as user_name')
            ->where('goods.id', $id)
            ->first();


        // 이미지 데이터 가져오기
        $images = DB::table('goods_images')->select('name')->where('goods_id', $id)->orderby('order')->get();

        // tag 데이터 가져오기
        $tags = DB::table('tags')->select('name')->where('goods_id', $id)->orderby('id')->get();

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
        return view('admins.goods.show',[
            'good' => $good,
            'images' => $images,
            'set_good' => $set_good,
            'tags'=>$tags
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
        // 데이터 가져오기
        $categorys =  DB::table('categorys')->get();
        $category_des = DB::table('category_des')->get();
        $category_de_des = DB::table('category_de_des')->get();
        $users = DB::table('users')->select('id', 'name')->get();


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


        // 페이지 이동
        return view('admins.goods.edit', [
            'good' => $good, 
            'categorys' => $categorys,
            'category_des' => $category_des,
            'category_de_des' => $category_de_des,
            'users' => $users,
            'images' => $images,
            'order'=>$order,
            'image_names'=>$image_names,
            'tag'=>$tag,
            'tags'=>$tags
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
        AdminGoodsController::goods_validate();


        // 내용 업데이트
        $good->update([
            'title'=>request('title'),
            'category_id'=>request('category_id'),
            'category_de_id'=>request('category_de_id'),
            'category_de_de_id'=>request('category_de_de_id'),
            'area'=>request('area'),
            'state'=>request('state'),
            'exchange'=>request('exchange'),
            'price'=>request('price'),
            'delivery_fee'=>request('delivery_fee'),
            'content'=>request('content'),
            'number'=>request('number'),
            'heart'=>request('heart'),
            'view'=>request('view'),
            'writeday'=>request('writeday'),
            'user_id'=>request('user_id'),
            'sale_state'=>request('sale_state')
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


        //페이지 이동
        return redirect('/admin/goods/'.$good->id);
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
            File::delete(public_path('storage/images/goods/'.$image_name->name));
        }
        DB::table('goods_images')->where('goods_id', $good->id)->delete();


        // 가지고 있는 태그 삭제
        DB::table('tags')->where('goods_id', $good->id)->delete();


        // 가지고 있는 question, question_comment 삭제
        $questions = DB::table('questions')->where('goods_id', $good->id)->get();
        foreach ($questions as $question) {
            DB::table('question_comments')->where('question_id', $question->id)->delete();
            DB::table('questions')->where('id', $question->id)->delete();
        }


        // 가지고 있는 review, review_comment 삭제
        $reviews = DB::table('reviews')->where('goods_id', $good->id)->get();
        foreach ($reviews as $review) {
            DB::table('review_comments')->where('review_id', $review->id)->delete();
            DB::table('reviews')->where('id', $review->id)->delete();
        }
        

        // 찜한 상품 삭제
        DB::table('heart_goods')->where('goods_id', $good->id)->delete();
        // --------------------------------------------------------------------------------

        // goods 삭제
        $good->delete();


        // 페이지 이동
        return redirect('/admin/goods');
    }


    // 유효성 검사 함수
    private function goods_validate() {
        
        request()->validate([   
            'title'=>'required',
            'category_id'=>'integer|min:1',
            'area'=>'required',   
            'state'=>'required|integer|max:1',  
            'exchange'=>'required|integer|max:1', 
            'price'=>'required|integer',
            'delivery_fee'=>'required|integer|max:1',
            'content'=>'required',
            'number'=>'required|integer',
            'heart'=>'required|integer',
            'view'=>'required|integer',
            'writeday'=>'required',
            'user_id'=>'integer|min:1',
            'sale_state'=>'required|integer|max:2'
        ]);
        
        if (request()->has('category_de_id')) {
            request()->validate(['category_de_id'=>'integer|min:1']);
        }
        if (request()->has('category_de_de_id')) {
            request()->validate(['category_de_de_id'=>'integer|min:1']);
        }
    }


    // 파일 업로드 함수
    private function file_upload($request) {
        $upload_path = 'public/images/goods';
        $image = '';
        if ($files = $request->file('image')) {
            
            foreach ($files as $key=>$file) {
                // 파일 이름 = '현재시간_파일명'
                $file_name = time().'_'.$file->getClientOriginalName();

                // image 컬럼에 들어갈 값 세팅 (이름 예시 : '파일명1|파일명2')
                if($key+1 == count($files)) $image .= $file_name;
                else $image .= $file_name.'|';
                
                // 파일 업로드
                $file->storeAs($upload_path, $file_name);
            }
        }

        return $image;
    }
}
