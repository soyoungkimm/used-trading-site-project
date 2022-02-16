<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ReviewComment;

class AdminReviewCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // review_comments 리스트 가져오기
        $review_comments = DB::table('review_comments')
            ->join('users', 'review_comments.user_id', '=', 'users.id')
            ->join('reviews', 'review_comments.review_id', '=', 'reviews.id')
            ->select('review_comments.*', 'reviews.content as review_content', 'users.name as user_name')
            ->orderBy('review_comments.id')
            ->get();

        
        // 페이지 이동
        return view('admins.reviewComments.index', ['review_comments' => $review_comments]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 데이터 가져오기
        $reviews = DB::table('reviews')->select('id', 'content')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        
        // 페이지 이동 
        return view('admins.reviewComments.create', [ 
            'reviews' => $reviews,
            'users' => $users
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
        AdminReviewCommentsController::review_comment_validate();


        // 데이터 저장
        $review_comment = ReviewComment::create([
            'user_id'=>request('user_id'),
            'review_id'=>request('review_id'),
            'content'=>request('content'),
            'writeday'=>request('writeday')
        ]);


        // 페이지 이동
        return redirect('/admin/review_comments/'.$review_comment->id);
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
        $review_comment = DB::table('review_comments')
            ->join('users', 'review_comments.user_id', '=', 'users.id')
            ->join('reviews', 'review_comments.review_id', '=', 'reviews.id')
            ->select('review_comments.*', 'reviews.content as review_content', 'users.name as user_name')
            ->where('review_comments.id', $id)
            ->first();

        
        // 페이지 이동
        return view('admins.reviewComments.show',[
            'review_comment' => $review_comment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ReviewComment $review_comment)
    {
        // 데이터 가져오기
        $reviews = DB::table('reviews')->select('id', 'content')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        // 페이지 이동
        return view('admins.reviewComments.edit', [
            'review_comment' => $review_comment,
            'reviews' => $reviews,
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
    public function update(Request $request, ReviewComment $review_comment)
    {
        // 유효성 검사
        AdminReviewCommentsController::review_comment_validate();

    
        // 내용 업데이트
        $review_comment->update([
            'user_id'=>request('user_id'),
            'review_id'=>request('review_id'),
            'content'=>request('content'),
            'writeday'=>request('writeday')
        ]);


        //페이지 이동
        return redirect('/admin/review_comments/'.$review_comment->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReviewComment $review_comment)
    {
        // review_comments 삭제
        // $review_comment->delete();

        // // 페이지 이동
        // return redirect('/admin/review_comments');
    }


    // 유효성 검사 함수
    private function review_comment_validate() {
        request()->validate([   
            'user_id'=>'integer|min:1',
            'review_id'=>'integer|min:1',
            'content'=>'required',
            'writeday'=>'required|date'
        ]);
    }
}
