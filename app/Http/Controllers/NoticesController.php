<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticesController extends Controller
{
    public function index()
    {
        $notices = Notice::on()->orderBy("id")->simplePaginate(5);

        return view('sites.notices.index', [
            'notices' => $notices,
        ]);
    }

    public function show($id)
    {
        $notice = Notice::on()->where('id', $id)->first();

        return view('sites.notices.show', [
            'notice' => $notice
        ]);
    }
}
