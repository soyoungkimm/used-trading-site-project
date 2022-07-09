<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use File;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){ //기본테이블 출력
        $users = User::orderBy('id')->get();
        return view('admins.users.index',['users' => $users]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){//회원추가 페이지 반환
        return view('admins.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){  //DB회원정보 추가
        $validated = $request->validate([ 
            'rank'  => 'required',
            'uid'   => 'required',
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
            'rank'  => $request->rank,
            'uid'   => $request->uid,
            'pwd'   => Hash::make($request->pwd),
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
            $path = $request -> file('image') -> storeAs('images/user', $fileName);
            $user->update([
                'image' => $fileName
            ]);
        }
        
        return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){ //회원 상세보기
        $user = User::where('id',$id)->first();
        return view('admins.users.show',['user' => $user]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){  //회원수정 페이지
        $user = User::where('id',$id)->first();
        return view('admins.users.edit',['user' => $user]);
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
        $user = User::find($request->id);
        
        //요청값 유효성 검사
        $validated = $request->validate([ 
            'rank'  => 'required',
            'uid'   => 'required',
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
            $path = $request -> file('image') -> storeAs('images/users', $fileName);
            $user->update([
                'image' => $fileName
            ]);
        }
        

        //테이블 업데이트
        $user->update([
            'rank'  => $request->rank,
            'uid'   => $request->uid,
            'pwd'   => Hash::make($request->pwd),
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
        
        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $reqeust){  

        foreach($reqeust->uidArray as $user){
            $users = User::find($user);
            $users->delete();
        }
        return $reqeust->uidArray;
    }

    public function checkUid(Request $reqeust){

        $checkResult = User::where('uid',$reqeust->uid)->count();
        if($checkResult==0){//중복된 id가 없는 경우
            return $checkResult;
        }else{                  //중복된 id가 존재하는 경우
            return $checkResult;
        }
    }

    public function loginForm(){ //로그인페이지
        return view('admins.login');
    } 

    public function login(Request $request){
        $validation = $request -> validate([
            'uid' => 'required',
            'pwd' => 'required',
        ]);

        $user = [
            'uid' => $request->uid,
            'password' => $request->pwd,
        ];
        //dd($user);
        //dd(Auth::user());
        if(Auth::attempt($user)){
             return redirect('/admin');
        }
        //dd(Auth::user());
        return redirect('/admin/login');
       
    }

    public function logout(){
        Auth::logout();
        return redirect('/admin/login');
    }

}
