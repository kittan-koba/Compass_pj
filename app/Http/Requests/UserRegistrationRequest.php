<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/^[\p{Katakana}\s]+$/u',
            'under_name_kana' => 'required|string|max:30|regex:/^[\p{Katakana}\s]+$/u',
            'mail_address' => 'required|email|unique:users|max:100',
            'sex' => 'required|in:男性,女性,その他',
            'old_year' => 'required|date_format:Y-m-d|after_or_equal:2000-01-01|before_or_equal:' . now()->format('Y-m-d'),
            'old_month' => 'required|date_format:Y-m-d|after_or_equal:2000-01-01|before_or_equal:' . now()->format('Y-m-d'),
            'old_day' => 'required|date_format:Y-m-d|after_or_equal:2000-01-01|before_or_equal:' . now()->format('Y-m-d'),
            'role' => 'required|in:講師(国語),講師(数学),講師(英語),生徒',
            'password' => 'required|string|min:8|max:30|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'over_name_kana.regex' => 'カタカナのみを入力してください。',
            'old_year.date_format' => '正しい日付を入力してください。',
            'old_month.date_format' => '正しい日付を入力してください。',
            'old_day.date_format' => '正しい日付を入力してください.',
        ];
    }
}
