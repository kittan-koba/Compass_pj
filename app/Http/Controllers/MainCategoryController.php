<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainCategory;
use App\Http\Requests\MainCategoryRequest;

class MainCategoryController extends Controller
{
    public function store(MainCategoryRequest $request)
    {
        // フォームリクエストによるバリデーションが成功した場合の処理
        $mainCategory = new MainCategory;
        $mainCategory->main_category_id = $request->input('main_category_id');
        $mainCategory->name = $request->input('sub_category_name');
        $mainCategory->save();

        return response()->json(['message' => 'サブカテゴリーが正常に登録されました。'], 201);
    }
}
