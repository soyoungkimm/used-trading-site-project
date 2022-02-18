<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Question;

class AdminQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // questions 리스트 가져오기
        $questions = DB::table('questions')
            ->join('users', 'questions.user_id', '=', 'users.id')
            ->join('goods', 'questions.goods_id', '=', 'goods.id')
            ->select('questions.*', 'goods.title as good_title', 'users.name as user_name')
            ->orderBy('questions.id')
            ->get();

        
        // 페이지 이동
        return view('admins.questions.index', ['questions' => $questions]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         // 데이터 가져오기
         $goods = DB::table('goods')->select('id', 'title')->get();
         $users = DB::table('users')->select('id', 'name')->get();
 
         
         // 페이지 이동 
         return view('admins.questions.create', [ 
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
    public function store(Request $request)
    {
        // 유효성 검사
        AdminQuestionsController::question_validate();


        // 데이터 저장
        $question = Question::create([
            'user_id'=>request('user_id'),
            'goods_id'=>request('goods_id'),
            'content'=>request('content'),
            'writeday'=>request('writeday')
        ]);


        // 페이지 이동
        return redirect('/admin/questions/'.$question->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // reviews 데이터 가져오기
        $question = DB::table('questions')
            ->join('users', 'questions.user_id', '=', 'users.id')
            ->join('goods', 'questions.goods_id', '=', 'goods.id')
            ->select('questions.*', 'goods.title as good_title', 'users.name as user_name')
            ->where('questions.id', $id)
            ->first();

        
        // 페이지 이동
        return view('admins.questions.show',[
            'question' => $question
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        // 데이터 가져오기
        $goods = DB::table('goods')->select('id', 'title')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        // 페이지 이동
        return view('admins.questions.edit', [
            'question' => $question,
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
    public function update(Request $request, Question $question)
    {
        // 유효성 검사
        AdminQuestionsController::question_validate();

    
        // 내용 업데이트
        $question->update([
            'user_id'=>request('user_id'),
            'content'=>request('content'),
            'goods_id'=>request('goods_id'),
            'writeday'=>request('writeday')
        ]);


        //페이지 이동
        return redirect('/admin/questions/'.$question->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        // question를 참조하는 question_comment 삭제
        //DB::table('question_comments')->where('question_id', $question->id)->delete();
        
        //question 삭제
        $question->delete();

        //페이지 이동
        return redirect('/admin/questions');
    }


    // 유효성 검사 함수
    private function question_validate() {
        request()->validate([   
            'user_id'=>'integer|min:1',
            'goods_id'=>'integer|min:1',
            'content'=>'required',
            'writeday'=>'required'
        ]);
    }
}
