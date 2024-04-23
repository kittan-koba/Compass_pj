<?php

// app/Http/Requests/UserRegistrationRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:30',
            'under_name_kana' => 'required|string|regex:/^[ァ-ヶー]+$/u|max:30',
            'mail_address' => 'required|email|max:100|unique:users,email',
            'sex' => 'required|in:男性,女性,その他',
            'old_year' => 'required|date|after_or_equal:2000-01-01|before_or_equal:today',
            'old_month' => 'required|date_format:m|after_or_equal:2000-01-01|before_or_equal:today',
            'old_day' => 'required|date_format:d|after_or_equal:2000-01-01|before_or_equal:today',
            'role' => 'required|in:講師(国語),講師(数学),教師(英語),生徒',
            'password' => 'required|string|min:8|max:30|confirmed',
        ];
    }

    public function messages()
    {
        return [
            // 各フィールドごとのバリデーションメッセージを追加
            'over_name' => 'over_nameは10文字以内で入力してください。',
            'under_name' => 'under_nameは10文字以内で入力してください。',
            'over_name_kana' => 'over_name_kanaはカタカナのみで入力してください。',
            'under_name_kana' => 'under_name_kanaはカタカナのみで入力してください。',
            'mail_address' => 'このメールアドレスはすでに使用されています。',
            'old_year' => '生年月日が正しくありません。',
            'old_month' => '生年月日が正しくありません。',
            'old_day' => '生年月日が正しくありません。',
            'password' => 'パスワードと確認用パスワードが一致しません。',
        ];
    }
}
