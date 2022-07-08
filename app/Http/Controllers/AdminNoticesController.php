<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Notice;

class AdminNoticesController extends Controller
{
    public function index()
    {
        $notices = Notice::on()->orderBy('id', 'desc')->get();

        return view('admins.notice.index', ['notices' => $notices]);
    }

    public function create()
    {
        return view('admins.notice.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'bail|required',
            'content' => 'required',
            'writeday' => 'required',
            'image' => 'required'
        ]);


        // DB 추가
        $id = Notice::on()->create([ // 레코드생성과 동시에 id 저장
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'writeday' => $request->get('writeday'),
            'image' => 'temp'
        ])->get('id');


        if ($request->hasFile('image')) {
            $notice = Notice::on()->find($id);
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('public/images/notices', $fileName);
            $notice->update([
                'image' => $fileName
            ]);
        }

        return redirect('/admin/notice');
    }

    public function show($id)
    {
        $notice = Notice::on()->where('id', $id)->first();
        return view('admins.notice.show', ['notice' => $notice]);
    }

    public function edit($id)
    {
        $notice = Notice::on()->where('id', $id)->first();
        return view('admins.notice.edit', ['notice' => $notice]);
    }

    public function update(Request $request)
    {
        // id와 일치하는 레코드 저장
        $notice = Notice::on()->find($request->get('id'));

        // 요청값 유효성 검사
        $validated = $request->validate([
            'title' => 'bail|required',
            'content' => 'required',
            'writeday' => 'required'
        ]);

        //테이블 업데이트
        $notice->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'writeday' => $request->get('writeday'),
        ]);

        //이미지 업로드
        if (request('image') != null) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $notice->update([
                'image' => $fileName
            ]);
            $path = $request->file('image')->storeAs('public/images/notices', $fileName);
        }


        return redirect('/admin/notice');
    }

    public function destroy(Request $reqeust)
    {

        foreach ($reqeust->adIdArr as $notice) {
            $notices = Notice::on()->find($notice);
            $notices->delete();
        }
        return $reqeust->adIdArr;
    }

}
