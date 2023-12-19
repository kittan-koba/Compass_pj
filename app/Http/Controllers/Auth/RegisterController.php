<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
        $this->validator($request->all())->validate();

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
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password),
            ]);

            $user = User::findOrFail($user_get->id);
            $user->subjects()->attach($subjects);

            DB::commit();
            return view('auth.login.login');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('loginView')->with('error', '登録に失敗しました。');
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'over_name' => ['required', 'string', 'max:10'],
            'under_name' => ['required', 'string', 'max:10'],
            'over_name_kana' => ['required', 'string', 'regex:/^[ァ-ヶー]+$/u', 'max:30'],
            'under_name_kana' => ['required', 'string', 'regex:/^[ァ-ヶー]+$/u', 'max:30'],
            'mail_address' => ['required', 'email', 'max:100', 'unique:users,email'],
            'sex' => ['required', 'in:男性,女性,その他'],
            'old_year' => ['required', 'date', 'after_or_equal:2000-01-01', 'before_or_equal:today'],
            'old_month' => ['required', 'date_format:m', 'after_or_equal:2000-01-01', 'before_or_equal:today'],
            'old_day' => ['required', 'date_format:d', 'after_or_equal:2000-01-01', 'before_or_equal:today'],
            'role' => ['required', 'in:教師(国語),教師(数学),教師(英語),生徒'],
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
        ], $this->validationMessages());
    }

    protected function validationMessages()
    {
        return [
            // バリデーションメッセージのカスタマイズを追加
            'over_name.max' => 'over_nameは10文字以内で入力してください。',
            'under_name.max' => 'under_nameは10文字以内で入力してください。',
            'over_name_kana.regex' => 'over_name_kanaはカタカナのみで入力してください。',
            'under_name_kana.regex' => 'under_name_kanaはカタカナのみで入力してください。',
            'mail_address.unique' => 'このメールアドレスはすでに使用されています。',
            'old_year.*' => '生年月日が正しくありません。',
            'old_month.*' => '生年月日が正しくありません。',
            'old_day.*' => '生年月日が正しくありません。',
            'password.confirmed' => 'パスワードと確認用パスワードが一致しません。',
        ];
    }
}
