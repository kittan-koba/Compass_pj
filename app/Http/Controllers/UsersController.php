<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegistrationRequest;

class UsersController extends Controller
{
    //
    public function store(UserRegistrationRequest $request)
    {
        // バリデーションを通過したら、ユーザー情報を保存する処理を記述
    }
}
