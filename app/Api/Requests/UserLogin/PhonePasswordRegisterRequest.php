<?php
namespace App\Api\Requests\UserLogin;

use Illuminate\Validation\Rules\Password;

use App\Api\Requests\BaseRequest;

/**
 * 手机号-密码注册验证
 */
class PhonePasswordRegisterRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'phone'=> ['required', new \App\Api\Rules\PhoneRuleVerify, new \App\Api\Rules\PhoneExistVerify],
            'sms_code'=> ['required', new \App\Api\Rules\SmsCodeEnterVerify],
            'password'=> ['required', Password::min(6), 'confirmed:password_confirmation'],
            'password_confirmation' => ['required']
        ];
    }

    public function messages(){
        return [
            'phone.required'=> '请填写手机号',
            'sms_code.required'=> '请填写短信验证码',
            'password.required'=> '请填写密码',
            'password.min'=> '密码长度不能小于6',
            'password_confirmation.required'=> '请重复密码',
            'password.confirmed'=> '密码与重复密码填写不一致',
        ];
    }
}