<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get_date_diff($datetime){

        $time_lag = time() - strtotime($datetime);
	
        if($time_lag < 60) {
            $posting_time = "방금";
        } 
        else if ($time_lag >= 60 and $time_lag < 3600) {
            $posting_time = floor($time_lag/60)."분 전";
        } 
        else if ($time_lag >= 3600 and $time_lag < 86400) {
            $posting_time = floor($time_lag/3600)."시간 전";
        } 
        else if ($time_lag >= 86400 and $time_lag < 2419200) {
            $posting_time = floor($time_lag/86400)."일 전";
        } 
        else if ($time_lag >= 2592000 and $time_lag < 31104000) {
            $posting_time = floor($time_lag/2592000)."개월 전";
        } 
        else if ($time_lag >= 31104000 and $time_lag < 31536000) { 
            $posting_time = "1년 전";
        } 
        else {
            $posting_time = floor($time_lag/31536000)."년 전";
        }
        
        return $posting_time;
    }
}
