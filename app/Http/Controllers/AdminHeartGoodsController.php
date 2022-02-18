<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\HeartGood;
use File;

class AdminHeartGoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){ //기본테이블 출력
        $heart_goods = DB::table('heart_goods')
        ->join('users', 'heart_goods.user_id', '=', 'users.id')
        ->join('goods', 'heart_goods.goods_id', '=', 'goods.id')
        ->select('heart_goods.*', 'users.name as user_name', 'goods.title as good_title')
        ->orderby('heart_goods.id')
        ->get();
        return view('admins.heartGoods.index',['heart_goods' => $heart_goods]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){//회원추가 페이지 반환

        $goods = DB::table('goods')->select('id', 'title')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        return view('admins.heartGoods.create',[ 
            'users' => $users,
            'goods' => $goods
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){  //DB회원정보 추가
        $validated = $request->validate([ 
            'goods_id'   => 'bail|required',
            'user_id'   => 'required'
        ]);

        
        //DB추가
        HeartGood::create([ //레코드생성과 동시에 id저장
            'goods_id'   => $request->goods_id,
            'user_id'   => $request->user_id
        ]);
        
        return redirect('/admin/heart-goods');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function show($id){ //회원 상세보기

        $heart_good = DB::table('heart_goods')
        ->join('users', 'heart_goods.user_id', '=', 'users.id')
        ->join('goods', 'heart_goods.goods_id', '=', 'goods.id')
        ->select('heart_goods.*', 'users.name as user_name', 'goods.title as good_title')
        ->orderby('heart_goods.id')
        ->where('heart_goods.id',$id)
        ->first();        

        return view('admins.heartGoods.show',['heart_good' => $heart_good]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){  //회원수정 페이지
        $heart_good = HeartGood::where('id',$id)->first();
        $goods = DB::table('goods')->select('id', 'title')->get();
        $users = DB::table('users')->select('id', 'name')->get();
        return view('admins.heartGoods.edit',[
            'heart_good' => $heart_good,
            'goods'      => $goods,
            'users'      => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){ //DB회원정보 수정
        //id와 일치하는 레코드 저장
        $heart_good = HeartGood::find($request->id);
        
        //요청값 유효성 검사
        $validated = $request->validate([ 
            'goods_id'  => 'bail|required',
            'user_id'   => 'required'
        ]);


        //테이블 업데이트
        $heart_good->update([
            'goods_id'   => $request->goods_id,
            'user_id'    => $request->user_id
        ]);
        
        return redirect('/admin/heart-goods');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $reqeust){  

        foreach($reqeust->arrGoods as $good){
            $goods = HeartGood::find($good);
            $goods->delete();
        }
        return $reqeust->goods;
    }

}
