<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UsersController extends Controller{

    public function index(){//
        $user = User::on()->orderBy("id")->simplePaginate(5);

        return view('sites.users.show', [
            'user' => $user,
        ]);
    }

    public function loginForm(){//로그인폼 반환
        return view('sites.users.login');
    }

    public function login(Request $request){//로그인

        $validation = $request -> validate([
            'uid' => 'required',
            'pwd' => 'required',
        ]);

        $user = [
            'uid' => $request->uid,
            'password' => $request->pwd,
        ];
        
        if(Auth::attempt($user)){//로그인 성공
            //Session::set('id',$reqeust->uid);
            $id = Auth::id();
            session(['id' => $id]);
            return redirect('/');
        }

        return redirect('/users/login');//로그인 실패
       
    }

    public function logout(){//로그아웃
        session()->forget('id');
        Auth::logout();
        return redirect('/');
    }

    public function register(){//가입폼 반환
        return view('sites.users.register');
    }

    public function checkUid(Request $reqeust){//중복된 경우 해당 객체 반환

        $checkResult = User::where('uid',$reqeust->uid)->count();
        if($checkResult==0){//중복된 id가 없는 경우
            return 0;
        }else{                  //중복된 id가 존재하는 경우
            return $checkResult;
        }
    }
    

    public function store(Request $request){//회원DB등록
        //dd($request);
        $validated = $request->validate([ 
            'uid'   => 'required',
            'pwd'   => 'required',
            'uname'  => 'required',
            'birth' => 'date|required',
            'tel'   => 'numeric|required',
            'intro' =>'required'
        ]);
        //중복id 체크
        $uidCount = User::where('uid',$request->uid)->count();

        if($uidCount == 0){
            $id=User::create([ //레코드생성과 동시에 id저장
                'rank'  => '0',
                'uid'   => $request->uid,
                'pwd'   => Hash::make($request->pwd),
                'name'  => $request->uname,
                'birth' => $request->birth,
                'tel'   => $request->tel,
                'store_name'   =>$request->store_name,
                'open_date'    =>date("Y-m-d",time()), //오늘
                'store_visit'  =>'0',
                'sale_num'     =>'0',
                'delivery_num' =>'0',
                'follower'     =>'0',
                'following'    =>'0',
                'good_num'     =>'0',
                'introduction' =>$request->intro
            ])->id;
    
            if($request ->hasFile('image')){
                $user = User::find($id);
                $fileName=time().'_'.$request -> file('image')-> getClientOriginalName();
                $path = $request -> file('image') -> storeAs('images/user', $fileName);
                $user->update([
                    'image' => $fileName
                ]);
            }
        }else {
            return redirect('/users/register');
        }
       

        return view('sites.users.register2'); //가입축하 폼
    }

    public function show($id){ //회원정보 조회
        $user = User::where('id',$id)->first();
        return view('sites.users.show',['user' => $user]);
    }

    public function edit($id){  //회원수정 페이지
        $user = User::where('id',$id)->first();
        return view('sites.users.edit',['user' => $user]);
    }

    public function update(Request $request){ //DB회원정보 수정
        //id와 일치하는 레코드 저장
        $user = User::find($request->id);
        //dump($user);
        //요청값 유효성 검사
        // $validated = $request->validate([ 
        //     'pwd'   => 'required',
        //     'name'  => 'required',
        //     'birth' => 'required',
        //     'tel'   => 'required',
        //     'store_name'   =>'required',
        //     'introduction' =>'required'
        // ]);
        if($request ->hasFile('image')){
            $fileName=time().'_'.$request -> file('image')-> getClientOriginalName();
            $path = $request -> file('image') -> storeAs('images/users', $fileName);
            $user->update([
                'image' => $fileName
            ]);
        }
        

        //테이블 업데이트
        $user->update([
            'pwd'   => Hash::make($request->pwd),
            'name'  => $request->name,
            'birth' => $request->birth,
            'tel'   => $request->tel,
            'store_name'   =>$request->store_name,
            'introduction' =>$request->introduction
        ]);

        $link = '/users/show/'.(string)$user->id;
        
        return redirect($link);
    }

    public function destroy(Request $reqeust){  
        Auth::logout();
        $user = User::find($reqeust->id);
        $uest->delete();

        return redirect('/');
    }

}
