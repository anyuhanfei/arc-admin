<?php
namespace App\Api\Rules\User;

use App\Repositories\Feedback\FeedbackTypes;
use App\Repositories\Users\Users;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;


/**
 * 判断反馈类型是否存在（存在才能通过验证）
 */
class FeedbackTypeNoExistVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        $type_names = (new FeedbackTypes())->get_names();
        return in_array($value, $type_names);
    }

    public function message(){
        return "选择的反馈类型不存在";
    }
}