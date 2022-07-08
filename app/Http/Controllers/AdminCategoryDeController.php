<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryDe;
use File;

class AdminCategoryDeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){ //기본테이블 출력
        $categorys =  DB::table('category_des')
        ->join('categorys', 'category_des.category_id', '=', 'categorys.id')
        ->select('category_des.*', 'categorys.name as category_name')
        ->get();
        
        return view('admins.categoryDetails.index',['Categorys' => $categorys]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){//회원추가 페이지 반환

        $categorys = DB::table('categorys')->get();

        return view('admins.categoryDetails.create',[
            'categorys' => $categorys
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){  //DB회원정보 추가
        //유효성검사
        $validated = $request->validate([
             'categoryId'     => 'required',
             'categoryDeName'=> 'bail|required'
            ]);

        //DB추가
        CategoryDe::create([
            'name'       => $request->categoryDeName,
            'category_id'=>$request->categoryId
        ]);
        
        return redirect('/admin/category-de');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function show($id){ //카테고리 상세보기
        
        $categorys =  DB::table('category_des')
        ->join('categorys', 'category_des.category_id', '=', 'categorys.id')
        ->select('category_des.*', 'categorys.name as category_name')
        ->where('category_des.id', $id)
        ->first();

        return view('admins.categoryDetails.show',['categoryss' => $categorys]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){  //회원수정 페이지
        $categoryDe = CategoryDe::where('id',$id)->first();
        $categorys = DB::table('categorys')->get();

        return view('admins.categoryDetails.edit',[
            'categorys' => $categorys,
            'categoryDe' => $categoryDe
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
        $CategoryDe = CategoryDe::find($request->id);
        
        //요청값 유효성 검사
        $validated = $request->validate([ 
            'categoryId'    => 'bail|required',
            'categoryDeName'  => 'required'
        ]);

        //테이블 업데이트
        $CategoryDe->update([
            'name'          => $request->categoryDeName,
            'category_id'   => $request->categoryId,
        ]);
        
        return redirect('/admin/category-de');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $reqeust){  

        foreach($reqeust->arrCategoryDe as $categoryDe){
            $categoryDes = CategoryDe::find($categoryDe);
            $categoryDes->delete();
        }
        return 0;
    }

}
