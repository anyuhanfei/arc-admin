<?php
namespace App\Api\Requests\UserLogin;

use App\Api\Requests\BaseRequest;


/**
 * 网易易盾登录验证
 */
class YidunOauthLoginRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'token'=> ['required'],
            'accessToken'=> ['required'],
        ];
    }

    public function messages(){
        return [
            'token.required'=> '缺少参数：token',
            'accessToken.required'=> '缺少参数：accessToken',
        ];
    }
}