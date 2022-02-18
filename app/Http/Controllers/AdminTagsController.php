<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use File;

class AdminTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){ //기본테이블 출력
        $tags = DB::table('tags')
        ->join('goods', 'tags.goods_id', '=', 'goods.id')
        ->select('tags.*', 'goods.title as goods_name')
        ->orderby('tags.id')
        ->get();
        return view('admins.tags.index',['tags' => $tags]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){//회원추가 페이지 반환

        $goods = DB::table('goods')->select('id', 'title')->get();

        return view('admins.tags.create',[ 
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
            'name'      => 'bail|required',
            'goods_id'  => 'required'
        ]);

        
        //DB추가
        Tag::create([ //레코드생성과 동시에 id저장
            'name'      => $request->name,
            'goods_id'  => $request->goods_id
        ]);
        
        return redirect('/admin/tags');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function show($id){ //회원 상세보기

        $tag = DB::table('tags')
        ->join('goods', 'tags.goods_id', '=', 'goods.id')
        ->select('tags.*', 'goods.title as good_title')
        ->where('tags.id',$id)
        ->first();        

        return view('admins.tags.show',['tag' => $tag]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){  //회원수정 페이지
        $tag = Tag::where('id',$id)->first();
        $goods = DB::table('goods')->select('id', 'title')->get();
        return view('admins.tags.edit',[
            'tag' => $tag,
            'goods'      => $goods
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
        $tag = Tag::find($request->id);
        
        //요청값 유효성 검사
        $validated = $request->validate([ 
            'name'      => 'bail|required',
            'goods_id'  => 'required'
        ]);


        //테이블 업데이트
        $tag->update([
            'name'      => $request->name,
            'goods_id'  => $request->goods_id
        ]);
        
        return redirect('/admin/tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $reqeust){  

        foreach($reqeust->arrTags as $tag){
            $tags = Tag::find($tag);
            $tags->delete();
        }
        return 0;
    }

}
