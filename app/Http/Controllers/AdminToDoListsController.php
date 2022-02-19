<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDoList;
use Illuminate\Support\Facades\DB;

class AdminToDoListsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo_list = ToDoList::create([
            'content'=>$request->input('inputValue'),
            'state'=>0 // 수행 안함(기본값)
        ]);

        echo $todo_list->id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToDoList $todo_list)
    {
        // 내용 업데이트
        if ($todo_list->state == 0) {
            $todo_list->update([ 'state'=>1 ]);
        }
        else {
            $todo_list->update([ 'state'=>0 ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->has('all_delete')) {
            // 다 삭제
            DB::table('to_do_lists')->delete();
            return redirect('/admin');
        }   
        else {
            // 하나만 삭제
            ToDoList::destroy($id);
        }
    }


}
