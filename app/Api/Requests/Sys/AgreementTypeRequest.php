<?php
namespace App\Api\Requests\Sys;

use App\Api\Requests\BaseRequest;

// 验证协议类型参数
class AgreementTypeRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'type' => ['required', 'string', new \App\Api\Rules\Sys\AgreementTypeNoExistVerify],
        ];
    }

    public function messages(){
        return [
            'type.required' => '协议类型不能为空',
            'type.string' => '协议类型必须为字符串',
        ];
    }
}