<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Advertisement;
use File;

class AdminADsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){ //기본테이블 출력
        $Ads = Advertisement::orderBy('id')->get();
        return view('admins.advertisement.index',['Ads' => $Ads]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){//회원추가 페이지 반환
        return view('admins.advertisement.create');
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
            'image'   => 'required'
        ]);

        
        //DB추가
        $id=Advertisement::create([ //레코드생성과 동시에 id저장
            'title'   => $request->title,
            'image'   => 'temp'
        ])->id;

        
        if($request ->hasFile('image')){
            $ad = Advertisement::find($id);
            $fileName=time().'_'.$request -> file('image')-> getClientOriginalName();
            $path = $request -> file('image') -> storeAs('images/Ad', $fileName);
            $ad->update([
                'image' => $fileName
            ]);
        }
        
        return redirect('/admin/advertise');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){ //회원 상세보기
        $Ad = Advertisement::where('id',$id)->first();
        return view('admins.advertisement.show',['ad' => $Ad]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){  //회원수정 페이지
        $Ad = Advertisement::where('id',$id)->first();
        return view('admins.advertisement.edit',['ad' => $Ad]);
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
        $Ad = Advertisement::find($request->id);
        
        //요청값 유효성 검사
        $validated = $request->validate([ 
            'title'   => 'bail|required',
        ]);

        //이미지 업로드
        if (request('image') != null) {
            $fileName=time().'_'.$request -> file('image')-> getClientOriginalName();
            $Ad->update([
                'image' => $fileName
            ]);
            $path = $request -> file('image') -> storeAs('images/Ad', $fileName);
            
        }

        //테이블 업데이트
        $Ad->update([
            'title'   => $request->title,
        ]);
        
        return redirect('/admin/advertise');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $reqeust){  

        foreach($reqeust->adIdArr as $ad){
            $ads = Advertisement::find($ad);
            $ads->delete();
        }
        return $reqeust->adIdArr;
    }

}
