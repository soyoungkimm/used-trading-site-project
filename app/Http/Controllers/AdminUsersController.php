<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Cookie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Arr;

class AdminUsersController extends Controller
{
    public function index(){ //기본테이블 출력
        $users = User::orderBy('id')->get();
        return view('users',['users' => $users]);
    } 

    public function view($id){ //회원 상세보기
        $user = User::where('id',$id)->get();
        return view('userDetails',['userDetails' => $user]);
    }

    public function create(){//회원추가 페이지 반환
        return view('userAdd');
    }

    public function store(Request $request){  //DB회원정보 추가
        $validated = $request->validate([ 
            'uid'   => 'bail|required',
            'pwd'   => 'required',
            'name'  => 'required',
            'birth' => 'required',
            'tel'   => 'required',
            'store_name'   =>'required',
            'open_date'    =>'required',
            'store_visit'  =>'required',
            'sale_num'     =>'required',
            'delivery_num' =>'required',
            'follower'     =>'required',
            'following'    =>'required',
            'good_num'     =>'required',
            'introduction' =>'required'
        ]);

        
        //DB추가
        $id=User::create([ //레코드생성과 동시에 id저장
            'uid'   => $request->uid,
            'pwd'   => $request->pwd,
            'name'  => $request->name,
            'birth' => $request->birth,
            'tel'   => $request->tel,
            'store_name'   =>$request->store_name,
            'open_date'    =>$request->open_date,
            'store_visit'  =>$request->store_visit,
            'sale_num'     =>$request->sale_num,
            'delivery_num' =>$request->delivery_num,
            'follower'     =>$request->follower,
            'following'    =>$request->following,
            'good_num'     =>$request->good_num,
            'introduction' =>$request->introduction
        ])->id;

        
        if($request ->hasFile('image')){
            $user = User::find($id);
            $fileName=time().'_'.$request -> file('image')-> getClientOriginalName();
            $path = $request -> file('image') -> storeAs('public/images', $fileName);
            $user->update([
                'image' => $fileName
            ]);
        }
        
        return redirect('/users');
    }
 
    public function edit($id){  //회원수정 페이지
        $user = User::where('id',$id)->get();
        return view('userEdit',['userDetails' => $user]);
    }

    public function update(Request $request){ //DB회원정보 수정
        //id와 일치하는 레코드 저장
        $user = User::find($request->id);
        
        //요청값 유효성 검사
        $validated = $request->validate([ 
            'uid'   => 'bail|required',
            'pwd'   => 'required',
            'name'  => 'required',
            'birth' => 'required',
            'tel'   => 'required',
            'store_name'   =>'required',
            'open_date'    =>'required',
            'store_visit'  =>'required',
            'sale_num'     =>'required',
            'delivery_num' =>'required',
            'follower'     =>'required',
            'following'    =>'required',
            'good_num'     =>'required',
            'introduction' =>'required'
        ]);
        if($request ->hasFile('image')){
            $fileName=time().'_'.$request -> file('image')-> getClientOriginalName();
            $path = $request -> file('image') -> storeAs('public/images', $fileName);
            $user->update([
                'image' => $fileName
            ]);
        }
        
        //DB업데이트
        $user->update([
            'uid'   => $request->uid,
            'pwd'   => $request->pwd,
            'name'  => $request->name,
            'birth' => $request->birth,
            'tel'   => $request->tel,
            'store_name'   =>$request->store_name,
            'open_date'    =>$request->open_date,
            'store_visit'  =>$request->store_visit,
            'sale_num'     =>$request->sale_num,
            'delivery_num' =>$request->delivery_num,
            'follower'     =>$request->follower,
            'following'    =>$request->following,
            'good_num'     =>$request->good_num,
            'introduction' =>$request->introduction
        ]);
        
        return redirect('/users');
    }
    public function delete(Request $reqeust){  

        foreach($reqeust->uidArray as $user){
            $users = User::find($user);
            $users->delete();
        }
        return $reqeust->uidArray;
    }

    public function checkUid(Request $reqeust){
        $checkResult = User::where('uid',$reqeust->uid)->count();
        //dd($checkResult);
        if($checkResult==0){//중복된 id가 없는 경우
            return $checkResult;
        }else{                  //중복된 id가 존재하는 경우
            return $checkResult;
        }
    }
}