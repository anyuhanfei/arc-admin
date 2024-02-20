<?php
namespace App\Api\Requests\UserLogin;

use Illuminate\Validation\Rules\Password;

use App\Api\Requests\BaseRequest;

/**
 * 账号-密码注册验证
 */
class AccountRegisterRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'account'=> ['required', "min:8", new \App\Api\Rules\AccountExistVerify],
            'password'=> ['required', Password::min(6), 'confirmed:password_confirmation'],
            'password_confirmation' => ['required']
        ];
    }

    public function messages(){
        return [
            'account.required'=> '请填写账号',
            'account.min'=> '账号长度不能小于8',
            'password.required'=> '请填写密码',
            'password.min'=> '密码长度不能小于6',
            'password_confirmation.required'=> '请重复密码',
            'password.confirmed'=> '密码与重复密码填写不一致',
        ];
    }
}