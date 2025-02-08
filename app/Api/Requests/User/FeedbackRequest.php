<?php
namespace App\Api\Requests\User;

use App\Api\Requests\BaseRequest;

// 意见反馈提交验证器
class FeedbackRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'type' => ['required', new \App\Api\Rules\User\FeedbackTypeNoExistVerify()],
            'content' => 'required',
        ];
    }

    public function messages(){
        return [
            'type.required' => '反馈类型不能为空',
            'content.required' => '反馈内容不能为空',
        ];
    }
}