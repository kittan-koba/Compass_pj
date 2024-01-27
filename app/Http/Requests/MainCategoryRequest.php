<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'main_category_name' => 'required|string|max:100|unique:main_categories,name',
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category_name' => 'required|string|max:100|unique:sub_categories,name',
        ];
    }

    public function messages()
    {
        return [
            'main_category_name.required' => 'メインカテゴリー名は必須項目です。',
            'main_category_name.string' => 'メインカテゴリー名は文字列型で入力してください。',
            'main_category_name.max' => 'メインカテゴリー名は100文字以内で入力してください。',
            'main_category_name.unique' => '同じ名前のメインカテゴリーは登録できません。',
            'main_category_id.required' => 'メインカテゴリーIDは必須項目です。',
            'main_category_id.exists' => '指定されたメインカテゴリーは存在しません。',
            'sub_category_name.required' => 'サブカテゴリー名は必須項目です。',
            'sub_category_name.string' => 'サブカテゴリー名は文字列型で入力してください。',
            'sub_category_name.max' => 'サブカテゴリー名は100文字以内で入力してください。',
            'sub_category_name.unique' => '同じ名前のサブカテゴリーは登録できません。',
        ];
    }
}
