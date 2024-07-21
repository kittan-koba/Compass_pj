<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{
    public function authorize()
    {
        // ここでリクエストの認可を設定します。基本的にtrueにしておきます。
        return true;
    }

    public function birth()
    {
        $old_year = $this->input('old_year');
        $old_month = $this->input('old_month');
        $old_day = $this->input('old_day');
        $data = $old_year . '-' . $old_month . '-' . $old_day;

        $this->merge([
            'birth' => $data,
        ]);
        return parent::birth();
    }

    public function rules()
    {
        // バリデーションルールを定義します。
        return [
            'over_name' => 'required|string|max:255',
            'under_name' => 'required|string|max:255',
            'over_name_kana' => 'required|string|max:255',
            'under_name_kana' => 'required|string|max:255',
            'mail_address' => 'required|string|email|max:255|unique:users',
            'sex' => 'required|integer',
            'old_year' => 'required|integer|min:2000|max:' . date('Y'),
            'old_month' => 'required|integer|min:1|max:12',
            'old_day' => 'required|integer|min:1|max:31',
            'birth' => 'data|before:today|after:1999-12-31|',
            'password' => 'required|string|min:8|max:30|confirmed',
            'subject' => 'required|array',
            'subject.*' => 'required|integer',
        ];
    }

    public function messages()
    {
        // カスタムエラーメッセージを定義します。
        return [
            'over_name.required' => '姓は必須です。',
            'under_name.required' => '名は必須です。',
            'over_name_kana.required' => 'セイは必須です。',
            'under_name_kana.required' => 'メイは必須です。',
            'mail_address.required' => 'メールアドレスは必須です。',
            'mail_address.email' => 'メールアドレスの形式が正しくありません。',
            'mail_address.unique' => 'このメールアドレスは既に使用されています。',
            'sex.required' => '性別は必須です。',
            'old_year.required' => '生年は必須です。',
            'old_month.required' => '生月は必須です。',
            'old_day.required' => '生日は必須です。',
            'birth.before' => '今日より前の日付を選択して下さい。',
            'birth.after' => '1999年12月31日より後の日付を選択してください。',
            'birth.data' => '正しい形式で登録してください。',
            'password.required' => 'パスワードは必須です。',
            'password.confirmed' => 'パスワードが一致しません。',
            'subject.required' => '科目は必須です。',
            'subject.*.required' => '科目の各要素は必須です。',
        ];
    }
}
