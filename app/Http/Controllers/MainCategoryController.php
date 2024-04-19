<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Http\Requests\MainCategoryRequest;

class MainCategoryController extends Controller
{
    public function store(MainCategoryRequest $request)
    {
        // フォームリクエストによるバリデーションが成功した場合の処理
        $mainCategory = new MainCategory;
        $mainCategory->main_category = $request->input('main_category_name'); // メインカテゴリー名を取得するように修正
        $mainCategory->save();

        // サブカテゴリーの登録処理
        foreach ($request->input('sub_categories') as $sub_category_name) {
            $subCategory = new SubCategory;
            $subCategory->main_category_id = $mainCategory->id; // メインカテゴリーの ID を取得
            $subCategory->sub_category = $sub_category_name;
            $subCategory->save();
        }

        return response()->json(['message' => 'メインカテゴリーとサブカテゴリーが正常に登録されました。'], 201);
    }
}
