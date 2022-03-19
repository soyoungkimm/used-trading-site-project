<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Question;


class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // 현재 로그인한 사용자 id 가져오기   <-- 임시
        $user_id = 2;

        // 데이터 저장
        $question = Question::create([
            'user_id'=>$user_id,
            'goods_id'=>request('goods_id'),
            'content'=>request('content'),
            'writeday'=>date('Y-m-d H:i:s', time()+(3600 * 9)) // + 9시간
        ]);

        // 데이터 가져오기
        $user = DB::table('users')->select('name', 'image')->where('id', $user_id)->first();

        // 값 세팅
        $data['question_id'] = $question->id;
        $data['question_writeday'] = parent::get_date_diff($question->writeday);
        $data['user_name'] = $user->name;
        $data['user_image'] = $user->image;

        echo json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // question comment 삭제
        $question_comment_num = DB::table('question_comments')->where('question_id', request('question_id'))->count();
        DB::table('question_comments')->where('question_id', request('question_id'))->delete();

        // question 삭제
        DB::table('questions')->where('id', request('question_id'))->delete();

        echo $question_comment_num;
    }
}
