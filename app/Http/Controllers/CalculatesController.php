<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalculatesController extends Controller
{
    public function show($id) {
        $payment = DB::table('payments')
            ->join('goods', 'payments.goods_id', '=', 'goods.id')
            ->select('payments.*', 'goods.title as goods_title')
            ->where('payments.merchant_uid', $id)
            ->first();
        

        $buy_user = DB::table('users')
        ->join('payments', 'payments.buy_user_id', '=', 'users.id')
        ->select('users.name')
        ->where('users.id', $payment->buy_user_id)
        ->first();
        $buy_user = $buy_user->name;
    

        $sale_user = DB::table('users')
        ->join('payments', 'payments.sale_user_id', '=', 'users.id')
        ->select('users.name')
        ->where('users.id', $payment->sale_user_id)
        ->first();
        $sale_user = $sale_user->name;


        return view('sites.pays.calculates.show', [
            'payment' => $payment,
            'sale_user' => $sale_user,
            'buy_user' => $buy_user
        ]);
    }
}
