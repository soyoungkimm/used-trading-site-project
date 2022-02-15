<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Review;

class AdminReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // reviews 리스트 가져오기
        $reviews = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->join('goods', 'reviews.goods_id', '=', 'goods.id')
            ->select('reviews.*', 'goods.title as good_title', 'users.name as user_name')
            ->orderBy('reviews.id')
            ->get();

        
        // 페이지 이동
        return view('admins.reviews.index', ['reviews' => $reviews]); 
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
        return view('admins.reviews.create', [ 
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
        AdminReviewsController::review_validate();


        // 데이터 저장
        $review = Review::create([
            'user_id'=>request('user_id'),
            'goods_id'=>request('goods_id'),
            'star'=>request('star'),
            'content'=>request('content'),
            'writeday'=>request('writeday')
        ]);


        // 페이지 이동
        return redirect('/admin/reviews/'.$review->id);
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
        $review = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->join('goods', 'reviews.goods_id', '=', 'goods.id')
            ->select('reviews.*', 'goods.title as good_title', 'users.name as user_name')
            ->where('reviews.id', $id)
            ->first();

        
        // 페이지 이동
        return view('admins.reviews.show',[
            'review' => $review
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        // 데이터 가져오기
        $goods = DB::table('goods')->select('id', 'title')->get();
        $users = DB::table('users')->select('id', 'name')->get();

        // 페이지 이동
        return view('admins.reviews.edit', [
            'review' => $review,
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
    public function update(Request $request, Review $review)
    {
        // 유효성 검사
        AdminReviewsController::review_validate();

    
        // 내용 업데이트
        $review->update([
            'user_id'=>request('user_id'),
            'goods_id'=>request('goods_id'),
            'star'=>request('star'),
            'content'=>request('content'),
            'writeday'=>request('writeday')
        ]);


        //페이지 이동
        return redirect('/admin/reviews/'.$review->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        // goods 삭제
        $review->delete();

        // 페이지 이동
        return redirect('/admin/reviews');
    }


    // 유효성 검사 함수
    private function review_validate() {
        request()->validate([   
            'user_id'=>'integer|min:1',
            'goods_id'=>'integer|min:1',
            'star'=>'required',
            'content'=>'required',
            'writeday'=>'required'
        ]);
    }
}
