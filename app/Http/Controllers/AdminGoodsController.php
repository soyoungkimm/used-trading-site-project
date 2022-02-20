<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Good;
use Illuminate\Support\Facades\DB;
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


        // 파일 업로드
        $image = AdminGoodsController::file_upload($request);
        

        // 데이터 저장
        $good = Good::create([
            'title'=>request('title'),
            'image'=>$image,
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


        // 이미지 데이터 배열    
        $images = explode("|", $good->image);


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
            'set_good' => $set_good
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
        $images = explode("|", $good->image);


        // 페이지 이동
        return view('admins.goods.edit', [
            'good' => $good, 
            'categorys' => $categorys,
            'category_des' => $category_des,
            'category_de_des' => $category_de_des,
            'users' => $users,
            'images' => $images
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
        AdminGoodsController::goods_validate('update');


        // 이미지 변경여부
        $isImageUpdate = true;
        if (request('image') != null) {
            // 파일 업로드
            $image = AdminGoodsController::file_upload($request); 

            // 변경되기 전 이미지 삭제
            $del_images = explode("|", $good->image);
            foreach ($del_images as $del_image) {
                File::delete(public_path('storage/images/goods/'.$del_image));
            }
        }
        else $isImageUpdate = false;


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

        
        // 이미지가 변경되었으면 이미지도 update
        if ($isImageUpdate) {
            $good->update([
                'image'=>$image
            ]);
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
        // 가지고 있는 이미지 삭제
        $del_images = explode("|", $good->image);
        foreach ($del_images as $del_image) {
            File::delete(public_path('storage/images/goods/'.$del_image));
        }


        // goods 삭제
        $good->delete();


        // 페이지 이동
        return redirect('/admin/goods');
    }


    // 유효성 검사 함수
    private function goods_validate($type='store') {
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
        
        if ($type == 'store') {
            request()->validate(['image'=>'required']);
        }  
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
