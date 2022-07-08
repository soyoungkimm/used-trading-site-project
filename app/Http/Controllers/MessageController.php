<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use App\Events\MyEvent;

class MessageController extends Controller
{
    public function index() {
        // 메세지 가져오기
        $messages = DB::table('messages')
            ->join('users', 'messages.from_user', '=', 'users.id')
            ->select('messages.*', 'users.name as user_name', 'users.image as user_image')
            ->orWhere(function($query) {
                $query->where('from_user', request('currentUser'))
                      ->where('to_user', request('chatWith'));
            })
            ->orWhere(function($query) {
                $query->where('from_user', request('chatWith'))
                      ->where('to_user', request('currentUser'));
            })
            ->orderby('time')
            ->orderby('id')
            ->get();

        // 시간 세팅
        foreach ($messages as $message) {
            MessageController::time_setting($message);
        }
            
        return response()->json([
            'messages' => $messages 
        ], 200);
    }

    public function store() {

        // 유효성 검사
        $validated = request()->validate([
            'content' => 'required',
            'to_user' => 'required',
            'from_user' => 'required'
        ]);
        
        // db에 저장
        $_message = Message::create([
            'content'=>request('content'),
            'to_user'=>request('to_user'),
            'from_user'=>request('from_user'),
            'time'=>date('Y-m-d H:i:s', time()+(3600 * 9)) // + 9시간
        ]);

        // 값 가져오기
        $message = DB::table('messages')
            ->join('users', 'messages.from_user', '=', 'users.id')
            ->select('messages.*', 'users.name as user_name', 'users.image as user_image')
            ->where('messages.id', $_message->id)
            ->orderby('messages.time')
            ->orderby('messages.id')
            ->first();

        // 시간 세팅
        MessageController::time_setting($message);

        // 이벤트 브로드캐스트
        MyEvent::dispatch($message);

        return response()->json([
            'message' => $message
        ], 201);
    }

    public function chatList() {

        $currentUserId = request('currentUserId');
        
        // 채팅한 user의 정보 가져옴
        $temps1 = DB::table('users')
            ->select('users.id', 'users.image', 'users.name', "users.image")
            ->join('messages', 'messages.from_user', '=', 'users.id')
            ->orWhere('messages.to_user', $currentUserId)
            ->distinct();
        $temps = DB::table('users')
            ->select('users.id', 'users.image', 'users.name', "users.image")
            ->join('messages', 'messages.to_user', '=', 'users.id')
            ->orWhere('messages.from_user', $currentUserId)
            ->distinct()
            ->union($temps1)
            ->get();
        $data['users'] = $temps;
        
        // 둘이 나눈 대화 중 가장 최근의 메시지 가져오기
        $data['messages'] = array();
        foreach($temps as $temp) {
            array_push($data['messages'], 
            DB::table('messages')
            ->where('time', DB::table('messages')
                ->orWhere(function($query) use ($temp, $currentUserId) {
                    $query->where('from_user', $temp->id)
                            ->where('to_user', $currentUserId);
                })
                ->orWhere(function($query) use ($temp, $currentUserId) {
                    $query->where('from_user', $currentUserId)
                            ->where('to_user', $temp->id);
                })
                ->max('time'))
            ->get());
        }

        // 시간 세팅
        foreach ($data['messages'] as $_message)
            $_message[0]->time = parent::get_date_diff($_message[0]->time);

        return response()->json([
            'data' => $data
        ], 200);
    }

    // 유저의 이름을 가져오는 함수
    public function getUserName() {

        $name = DB::table('users')
            ->select('name')
            ->where('id', request('chatWith'))
            ->get();

        return response()->json([
            'name' => $name
        ], 200);
    }

    // 시간을 오전 00:00, 오후 00:00로 변환하는 함수
    function getAmPm($date) {
        $rtn = "";
        $hour = date("H", strtotime($date));
        $min = date("i", strtotime($date));
    
        $rtn = "오전 ".$hour.":".$min;
        if( $hour > 12 ) {
            $hour = $hour - 12;
            $rtn = "오후 ".$hour.":".$min;
        }
    
        return $rtn;
    }

    function time_setting($message) {
        $arr = explode(' ', $message->time);
        $_arr = explode('-', $arr[0]);
        $date = $_arr[0]."년 ".$_arr[1]."월 ".$_arr[2]."일-"; 
        $message->time = $date.MessageController::getAmPm($message->time);
    }
}