<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Alarm;
use File;

class AdminAlarmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){ //기본테이블 출력
        $alarms = DB::table('alarm')
        ->join('users', 'alarm.user_id', '=', 'users.id')
        ->join('goods', 'alarm.goods_id', '=', 'goods.id')
        ->select('alarm.*', 'users.name as user_name', 'goods.title as good_title')
        ->orderby('alarm.id')
        ->get();
        return view('admins.alarms.index',['alarms' => $alarms]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){//회원추가 페이지 반환

        $goods = DB::table('goods')->select('id', 'title')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        return view('admins.alarms.create',[ 
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
            'content'   => 'bail|required',
            'writeday'   => 'required',
            'goods_id'   => 'required',
            'user_id'   => 'required'
        ]);

        
        //DB추가
        Alarm::create([ //레코드생성과 동시에 id저장
            'content'   => $request->content,
            'writeday'  => $request->writeday,
            'goods_id'  => $request->goods_id,
            'user_id'   => $request->user_id
        ]);
        
        return redirect('/admin/alarm');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function show($id){ //회원 상세보기

        $alarms = DB::table('alarm')
        ->join('users', 'alarm.user_id', '=', 'users.id')
        ->join('goods', 'alarm.goods_id', '=', 'goods.id')
        ->select('alarm.*', 'users.name as user_name', 'goods.title as good_title')
        ->where('alarm.id',$id)
        ->orderby('alarm.id')
        ->first();        

        return view('admins.alarms.show',['alarm' => $alarms]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){  //회원수정 페이지
        $alarm = Alarm::where('id',$id)->first();
        $goods = DB::table('goods')->select('id', 'title')->get();
        $users = DB::table('users')->select('id', 'name')->get();
        return view('admins.alarms.edit',[
            'alarm' => $alarm,
            'goods' => $goods,
            'users' => $users
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
        $heart_good = Alarm::find($request->id);
        
        //요청값 유효성 검사
        $validated = $request->validate([ 
            'content'   => 'bail|required',
            'writeday'  => 'required',
            'goods_id'  => 'required',
            'user_id'   => 'required'
        ]);


        //테이블 업데이트
        $heart_good->update([
            'content'   => $request->content,
            'writeday'  => $request->writeday,
            'goods_id'  => $request->goods_id,
            'user_id'   => $request->user_id
        ]);
        
        return redirect('/admin/alarm');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $reqeust){  

        foreach($reqeust->arrAlarms as $alarm){
            $alarms = Alarm::find($alarm);
            $alarms->delete();
        }
        return 0;
    }

}
