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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function birth()
    {
        $year = $this->input('old_year');
        $month = $this->input('old_month');
        $day = $this->input('old_day');
        $data = $year . '-' . $month . '-' . $day;

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
            'over_name_kana' => 'required|string|max:255min:1|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'under_name_kana' => 'required|string|max:255min:1|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'mail_address' => 'required|string|email|max:255|unique:users',
            'sex' => 'required|integer',
            'birth' => 'data|before:today|after:1999-12-31|before:tomorrow',
            'password' => 'required|string|min:8|max:30|confirmed',
            'subject' => 'required|array',
            'subject.*' => 'required|integer',
        ];
    }

    public function messages()
    {
        // カスタムエラーメッセージを定義します。
        return [
            "required" => "必須項目です",
            "email" => "メールアドレスの形式で入力してください",
            "regex" => "全角カタカナで入力してください",
            "string" => "文字列で入力してください",
            "max" => "30文字以内で入力してください",
            "over_name.max" => "10文字以内で入力してください",
            "under_name.max" => "10文字以内で入力してください",
            "min" => "8文字以上で入力してください",
            "mail_address.max" => "100文字以内で入力してください",
            "unique" => "登録済みのメールアドレスを入力しないでください",
            "confirmed" => "パスワード確認が一致していません",
            "birth_day.date" => "有効な日付を入力してください"
        ];
    }
}
