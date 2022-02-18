<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionComment;

class AdminQuestionCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // question_comments 리스트 가져오기
        $question_comments = DB::table('question_comments')
            ->join('users', 'question_comments.user_id', '=', 'users.id')
            ->join('questions', 'question_comments.question_id', '=', 'questions.id')
            ->select('question_comments.*', 'questions.content as question_content', 'users.name as user_name')
            ->orderBy('question_comments.id')
            ->get();

        
        // 페이지 이동
        return view('admins.questionComments.index', ['question_comments' => $question_comments]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         // 데이터 가져오기
         $questions = DB::table('questions')->select('id', 'content')->get();
         $users = DB::table('users')->select('id', 'name')->get();
 
         
         // 페이지 이동 
         return view('admins.questionComments.create', [ 
             'users' => $users,
             'questions' => $questions
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
        AdminQuestionCommentsController::question_comment_validate();


        // 데이터 저장
        $question_comment = QuestionComment::create([
            'user_id'=>request('user_id'),
            'question_id'=>request('question_id'),
            'content'=>request('content'),
            'writeday'=>request('writeday')
        ]);


        // 페이지 이동
        return redirect('/admin/question_comments/'.$question_comment->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // question_comment 데이터 가져오기
        $question_comment = DB::table('question_comments')
            ->join('users', 'question_comments.user_id', '=', 'users.id')
            ->join('questions', 'question_comments.question_id', '=', 'questions.id')
            ->select('question_comments.*', 'questions.content as question_content', 'users.name as user_name')
            ->where('question_comments.id', $id)
            ->first();

        
        // 페이지 이동
        return view('admins.questionComments.show',[
            'question_comment' => $question_comment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionComment $question_comment)
    {
        // 데이터 가져오기
        $questions = DB::table('questions')->select('id', 'content')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        // 페이지 이동
        return view('admins.questionComments.edit', [
            'question_comment' => $question_comment,
            'questions' => $questions, 
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
    public function update(Request $request, QuestionComment $question_comment)
    {
        // 유효성 검사
        AdminQuestionCommentsController::question_comment_validate();

    
        // 내용 업데이트
        $question_comment->update([
            'user_id'=>request('user_id'),
            'question_id'=>request('question_id'),
            'content'=>request('content'),
            'writeday'=>request('writeday')
        ]);


        //페이지 이동
        return redirect('/admin/question_comments/'.$question_comment->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionComment $question_comment)
    {
        // question_comment 삭제
        $question_comment->delete();

        // 페이지 이동
        return redirect('/admin/question_comments');
    }


    // 유효성 검사 함수
    private function question_comment_validate() {
        request()->validate([   
            'user_id'=>'integer|min:1',
            'question_id'=>'integer|min:1',
            'content'=>'required',
            'writeday'=>'required'
        ]);
    }
}
