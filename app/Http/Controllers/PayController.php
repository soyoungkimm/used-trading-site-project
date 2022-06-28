<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use App\Models\PayAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Handler;
use Exception;
use Illuminate\Support\Facades\Auth;

class PayController extends Controller
{
    public function getMerchantUidAndSetPrice() {
        // 주문번호 규칙 : 연월일(YYMMDD) + 숫자or영어 랜덤 5자리 = 11자리
        $today = date("ymd");
        $merchant_uid = $today.Str::random(5);


        $good = DB::table('goods')->select('price')->where('id', request('goods_id'))->first();
        $price = floor($good->price + ($good->price * (35 / 1000)));
        $ans = PayAuth::create(['merchant_uid'=>$merchant_uid, 'amount'=>$price]);


        $result['merchant_uid'] = $merchant_uid;
        $result['pay_auth_id'] = $ans->id;
        $result['price'] = $price;

        return response()->json($result);
    }


    public function complete(Request $request)
    {
        $result = ["code"=>200, "message"=>"success"];
        $imp_key = "7714768749174916";// REST API 키
        $imp_secret = "OB1WWo6mnBLajBRh7DUty0o50YIkkmO8YP4UebhBM3M6EEnMhhgQiEViDEDX1r5ZhaUvlb78eTeTxBFP"; // REST API Secret
        $imp_uid = request('imp_uid');// 결제 번호
        $merchant_uid = request("merchant_uid");// 주문 번호
        $pay_auth_id = request("pay_auth_id");// 주문 번호 id
        $goods_id = request("goods_id"); // 상품 id
        $sale_user_id = DB::table('goods')->select('user_id')->where('id', $goods_id)->first();
        $sale_user_id = $sale_user_id->user_id; // 상품 판매자

        
        try{
            // 엑세스 토큰 발급
            $getToken  = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post('https://api.iamport.kr/users/getToken', [
                'imp_key' => $imp_key,
                'imp_secret' => $imp_secret,
            ]);
            $getTokenJson = json_decode($getToken, true);
            $access_token = $getTokenJson['response']['access_token'];


            // imp_uid로 아임포트 서버에서 결제 정보 조회
            $getPaymentData = Http::withHeaders([
                'Authorization' => $access_token
            ])->get('https://api.iamport.kr/payments/?imp_uid[]='.$imp_uid);
            $getPaymentDataJson = json_decode($getPaymentData,true);

            
            // $getPaymentDataJson['response'] : 아임포트에 요청한 실제 결제 정보
            $iamport_status = $getPaymentDataJson['response'][0]['status']; //아임포트 결제 상태 값 (paid : 정상 결제 된 값)
            $iamport_amount = $getPaymentDataJson['response'][0]['amount']; //아임포트 실제 결제 금액           
            $iamport_merchant_uid = $getPaymentDataJson['response'][0]['merchant_uid']; //아임포트 실제 주문번호


            // 결제 검증(XSS 방지)
            $amount = DB::table('goods')->select('price')->where('id', $goods_id)->first();
            $amount = floor($amount->price + ($amount->price * 35/1000)); // 수수료 3.5%
            $real_merchant_uid_val = DB::table('pay_auths')->where('id', $pay_auth_id)->first();
            $real_merchant_uid = $real_merchant_uid_val->merchant_uid;
            $real_amout = $real_merchant_uid_val->amount;


             // 결제 된 금액 == 상품 금액(2번) and 정상결제확인 and 주문번호 동일한지(3번)
            if($iamport_amount == $amount && $real_amout == $amount && $iamport_status == 'paid' 
                && $real_merchant_uid == $iamport_merchant_uid && $real_merchant_uid == $merchant_uid) {
                    if (auth()->check()) {
                        $currentUser = auth()->id();
                    }
                    else {
                        $currentUser = null;
                        throw new Exception('로그인이 되어있지 않습니다.', 410);
                    }
                
                // db에 값 넣기
                Payment::create([
                    'merchant_uid'=>$merchant_uid,
                    'imp_uid'=>$imp_uid,
                    'amount'=>$iamport_amount,
                    'status'=>$iamport_status,
                    'buy_user_id'=>$currentUser,
                    'sale_user_id'=>$sale_user_id,
                    'goods_id'=>$goods_id
                ]);

                // pay_auth값 삭제
                DB::table('pay_auths')->where('id', $pay_auth_id)->delete();

                // goods 판매완료로 전환
                DB::table('goods')->where('id', $goods_id)->update(['sale_state' => 2]);
            }
            else {
                throw new Exception('위조된 결제를 시도했습니다.', 410);
                DB::table('pay_auths')->where('id', $pay_auth_id)->delete(); // pay_auth값 삭제
            }
        
        }catch(Exception $e){
            $result = [
                'code' => 410,
                'message' => $e->getMessage()
            ];
        }

        return response()->json([
            'result'=>$result
        ]);
    }


    function removePayAuth() {
        $removePayAuthId = request('removePayAuthId');
        DB::table('pay_auths')->where('id', $removePayAuthId)->delete(); // pay_auth값 삭제
    }

}

?>
