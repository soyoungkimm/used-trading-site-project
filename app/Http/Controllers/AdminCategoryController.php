<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use File;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){ //기본테이블 출력
        $Categorys = Category::orderBy('id')->get();
        return view('admins.categorys.index',['Categorys' => $Categorys]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){//회원추가 페이지 반환
        return view('admins.categorys.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){  //DB회원정보 추가
        //유효성검사
        $validated = $request->validate([ 'categoryName' => 'bail|required']);

        //DB추가
        Category::create(['name' => $request->categoryName]);
        
        return redirect('/admin/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function show($id){ //카테고리 상세보기
        $category = Category::where('id',$id)->first();
        return view('admins.categorys.show',['category' => $category]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){  //회원수정 페이지
        $category = Category::where('id',$id)->first();
        return view('admins.categorys.edit',['category' => $category]);
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
        $Category = Category::find($request->id);
        
        //요청값 유효성 검사
        $validated = $request->validate([ 
            'categoryName'   => 'bail|required',
        ]);

        //테이블 업데이트
        $Category->update([
            'name'   => $request->categoryName,
        ]);
        
        return redirect('/admin/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $reqeust){  

        foreach($reqeust->arrCategory as $category){
            $ads = Category::find($category);
            $ads->delete();
        }
        return 0;
    }

}
