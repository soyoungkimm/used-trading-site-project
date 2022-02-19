<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryDeDe;
use File;

class AdminCategoryDeDeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){ //기본테이블 출력
        $categorys =  DB::table('category_de_des')
        ->join('category_des', 'category_de_des.category_de_id', '=', 'category_des.id')
        ->join('categorys', 'category_des.category_id', '=', 'categorys.id')
        ->select('category_de_des.*', 'category_des.name as categoryDe_name', 'categorys.name as category_name')
        ->get();
        
        return view('admins.categoryDeDetails.index',['Categorys' => $categorys]);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){//회원추가 페이지 반환

        $categorys = DB::table('category_des')->get();

        return view('admins.categoryDeDetails.create',[
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
             'categoryDeId'     => 'bail|required',
             'categoryDeDeName'=> 'required'
            ]);

        //DB추가
        CategoryDeDe::create([
            'name'          => $request->categoryDeDeName,
            'category_de_id'=>$request->categoryDeId
        ]);
        
        return redirect('/admin/category-de-de');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function show($id){ //카테고리 상세보기

        $categorys =  DB::table('category_de_des')
        ->join('category_des', 'category_de_des.category_de_id', '=', 'category_des.id')
        ->join('categorys', 'category_des.category_id', '=', 'categorys.id')
        ->select('category_de_des.*', 'category_des.name as categoryDe_name', 'categorys.name as category_name')
        ->where('category_de_des.id', $id)
        ->first();

        return view('admins.categoryDeDetails.show',['categorys' => $categorys]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){  //회원수정 페이지
        $categoryDe =  DB::table('category_des')
        ->join('categorys', 'category_des.category_id', '=', 'categorys.id')
        ->select('category_des.*', 'categorys.name as category_name')
        ->orderby('category_name')
        ->get();
        $categoryDeDe = CategoryDeDe::where('id',$id)->first();

        return view('admins.categoryDeDetails.edit',[
            'categoryDes' => $categoryDe,
            'categoryDeDe' => $categoryDeDe
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
        $CategoryDeDe = CategoryDeDe::find($request->id);
        
        //요청값 유효성 검사
        $validated = $request->validate([ 
            'categoryDeId'    => 'bail|required',
            'categoryDeDeName' => 'required'
        ]);

        //테이블 업데이트
        $CategoryDeDe->update([
            'name'          => $request->categoryDeDeName,
            'category_de_id'   => $request->categoryDeId,
        ]);
        
        return redirect('/admin/category-de-de');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $reqeust){  

        foreach($reqeust->arrCategoryDeDe as $categoryDeDe){
            $categoryDeDe = CategoryDeDe::find($categoryDeDe);
            $categoryDeDe->delete();
        }
        return 0;
    }

}
