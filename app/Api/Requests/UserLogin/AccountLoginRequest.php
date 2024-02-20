<?php
namespace App\Api\Requests\UserLogin;

use App\Api\Requests\BaseRequest;

/**
 * 账号-密码登录验证
 */
class AccountLoginRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'account'=> ['required'],
            'password'=> ['required'],
        ];
    }

    public function messages(){
        return [
            'account.required'=> '请填写账号',
            'password.required'=> '请填写密码',
        ];
    }
}