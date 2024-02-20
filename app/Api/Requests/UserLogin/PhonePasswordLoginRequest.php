<?php
namespace App\Api\Requests\UserLogin;

use App\Api\Requests\BaseRequest;

/**
 * 手机号-密码登录验证
 */
class PhonePasswordLoginRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'phone'=> ['required'],
            'password'=> ['required'],
        ];
    }

    public function messages(){
        return [
            'phone.required'=> '请填写手机号',
            'password.required'=> '请填写密码',
        ];
    }
}