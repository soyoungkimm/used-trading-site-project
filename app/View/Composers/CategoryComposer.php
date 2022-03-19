<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class CategoryComposer
{
    /**
     * Create a new profile composer.
     */

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // 헤더에 들어갈 카테고리 가져오기
        $view->with('categorys', DB::table('categorys')->orderBy("id", "asc")->get());
        $view->with('category_des', DB::table('category_des')->orderBy("id", "asc")->get());
        $view->with('category_de_des', DB::table('category_de_des')->orderBy("id", "asc")->get());
    }
}