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
    public function index()
    {
        //
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

        return view('sites.goods.create', [ 
            'categorys' => $categorys,
            'category_des' => $category_des,
            'category_de_des' => $category_de_des
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
        //유효성 검사
        GoodsController::goods_validate();

        // 현재 로그인한 회원 id 가져오기    <-- 임시
        $user_id = 1;

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
            'writeday'=>now(),
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


        // 페이지 이동
        //return redirect('/goods');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
            }
        }
    }



    // 파일 업로드 함수
    private function file_upload($request) {

        $file_names = array();
        $upload_path = 'public/images/goods';
        if ($files = $request->file('image')) {
            //var_dump($request->file('image'));
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
}
