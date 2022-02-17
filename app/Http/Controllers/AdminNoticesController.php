<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Notice;
use File;

class AdminNoticesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){ //기본테이블 출력
        $notices = Notice::orderBy('id')->get();
        return view('admins.notice.index',['notices' => $notices]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){//회원추가 페이지 반환
        return view('admins.notice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){  //DB회원정보 추가
        $validated = $request->validate([ 
            'title'   => 'bail|required',
            'content'   => 'required',
            'writeday'   => 'required',
            'image'   => 'required'
        ]);

        
        //DB추가
        $id=Notice::create([ //레코드생성과 동시에 id저장
            'title'   => $request->title,
            'content'   => $request->content,
            'writeday'   => $request->writeday,
            'image'   => 'temp'
        ])->id;

        
        if($request ->hasFile('image')){
            $notice = Notice::find($id);
            $fileName=time().'_'.$request -> file('image')-> getClientOriginalName();
            $path = $request -> file('image') -> storeAs('images/notice', $fileName);
            $notice->update([
                'image' => $fileName
            ]);
        }
        
        return redirect('/admin/notice');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function show($id){ //회원 상세보기
        $notice = Notice::where('id',$id)->first();
        return view('admins.notice.show',['notice' => $notice]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){  //회원수정 페이지
        $notice = Notice::where('id',$id)->first();
        return view('admins.notice.edit',['notice' => $notice]);
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
        $notice = Notice::find($request->id);
        
        //요청값 유효성 검사
        $validated = $request->validate([ 
            'title'   => 'bail|required',
            'content'   => 'required',
            'writeday'   => 'required'
        ]);

        //테이블 업데이트
        $notice->update([
            'title'   => $request->title,
        ]);

        //이미지 업로드
        if (request('image') != null) {
            $fileName=time().'_'.$request -> file('image')-> getClientOriginalName();
            $notice->update([
                'image' => $fileName
            ]);
            $path = $request -> file('image') -> storeAs('images/notice', $fileName);
        }

        
        
        return redirect('/admin/notice');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $reqeust){  

        foreach($reqeust->adIdArr as $notice){
            $notices = Notice::find($notice);
            $notices->delete();
        }
        return $reqeust->adIdArr;
    }

}
