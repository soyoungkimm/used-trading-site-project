<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionComment;

class QuestionCommentsController extends Controller
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
        $question_comment = QuestionComment::create([
            'user_id'=>$user_id,
            'question_id'=>request('question_id'),
            'content'=>request('content'),
            'writeday'=>date('Y-m-d H:i:s', time()+(3600 * 9)) // + 9시간
        ]);

        // 데이터 가져오기
        $user = DB::table('users')->select('name', 'image')->where('id', $user_id)->first();

        // 값 세팅
        $data['question_comment_writeday'] = QuestionCommentsController::get_date_diff($question_comment->writeday);
        $data['question_comment_id'] = $question_comment->id;
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
        DB::table('question_comments')->where('id', request('question_comment_id'))->delete();
    }

    private function get_date_diff($datetime){

        $time_lag = time() - strtotime($datetime);
	
        if($time_lag < 60) {
            $posting_time = "방금";
        } elseif($time_lag >= 60 and $time_lag < 3600) {
            $posting_time = floor($time_lag/60)."분 전";
        } elseif($time_lag >= 3600 and $time_lag < 86400) {
            $posting_time = floor($time_lag/3600)."시간 전";
        } elseif($time_lag >= 86400 and $time_lag < 2419200) {
            $posting_time = floor($time_lag/86400)."일 전";
        } else {
            $posting_time = date("y-m-d", strtotime($datetime));
        } 
        
        return $posting_time;
    }
}
