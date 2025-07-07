<?php
namespace App\Api\Requests\UserLogin;

use App\Api\Requests\BaseRequest;


/**
 * 微信公众号/小程序/APP授权登录验证
 */
class WxOauthLoginRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'code'=> ['required'],
        ];
    }

    public function messages(){
        return [
            'code.required'=> '缺少参数：code',
        ];
    }
}