<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
            'avatar' => ['required', 'image', 'max:1024'],
        ])->validate();

        // アバターのアップロード処理

        // 現在の日付と時刻（秒まで）を取得
        $timestamp = now()->format('YmdHis');
        // 元のファイル名を取得
        $originalName = $input['avatar']->getClientOriginalName();
        // 新しいファイル名を生成（タイムスタンプ + 元のファイル名）
        $filename = $timestamp . '_' . $originalName;
        // storage/app/public/avatar に保存
        $input['avatar']->storeAs('avatar', $filename, 'public');

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'avatar' => $filename,
        ]);
    }
}
