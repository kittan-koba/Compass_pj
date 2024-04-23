<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // 追加

use Illuminate\Http\Request;
use DB;

use App\Models\Users\Subjects;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    public function registerPost(Request $request)
    {
        // $this->validator($request->all())->validate(); // 修正
        $this->validate($request, [ // 修正
            'over_name' => 'required|string|max:255',
            'under_name' => 'required|string|max:255',
            'over_name_kana' => 'required|string|max:255',
            'under_name_kana' => 'required|string|max:255',
            'mail_address' => 'required|string|email|max:255|unique:users',
            'sex' => 'required|integer',
            'old_year' => 'required|date|after_or_equal:2000-01-01|before_or_equal:today',
            'old_month' => 'required|date_format:m|after_or_equal:2000-01-01|before_or_equal:today',
            'old_day' => 'required|date_format:d|after_or_equal:2000-01-01|before_or_equal:today',
            'password' => 'required|string|min:8|max:30|confirmed',
            'subject' => 'required|array', // 配列であることを検証
            'subject.*' => 'required|integer', // 配列の各要素が整数であることを検証
        ]);

        DB::beginTransaction();
        try {
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;

            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->input('mail_address'),
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            $user = User::findOrFail($user_get->id);
            $user->subjects()->attach($subjects);

            DB::commit();
            return redirect()->route('loginView')->with('success', 'ユーザーが正常に登録されました。');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('loginView')->with('error', '登録に失敗しました。');
        }
    }

    // バリデーションメソッドを追加
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'over_name' => 'required|string|max:255',
            'under_name' => 'required|string|max:255',
            'over_name_kana' => 'required|string|max:255',
            'under_name_kana' => 'required|string|max:255',
            'mail_address' => 'required|string|email|max:255|unique:users',
            'sex' => 'required|integer',
            'old_year' => 'required|date|after_or_equal:2000-01-01|before_or_equal:today',
            'old_month' => 'required|date_format:m|after_or_equal:2000-01-01|before_or_equal:today',
            'old_day' => 'required|date_format:d|after_or_equal:2000-01-01|before_or_equal:today',
            'role' => 'required|integer',
            'password' => 'required|string|min:8|max:30|confirmed',
            'subject' => 'required|array',
            'subject.*' => 'required|integer',
        ]);

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
