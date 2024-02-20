<?php
namespace App\Api\Requests\UserLogin;

use App\Api\Requests\BaseRequest;

/**
 * 手机号-验证码登录验证
 */
class PhoneSmscodeLoginRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'phone' => 'required',
            'sms_code' => ['required', new \App\Api\Rules\SmsCodeEnterVerify],
        ];
    }

    public function messages(){
        return [
            'phone.required'=> '请填写手机号',
            'sms_code.required'=> '请填写短信验证码'
        ];
    }
}