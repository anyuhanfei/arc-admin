<?php
namespace App\Api\Rules;

use App\Repositories\Users\Users;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

/**
 * 判断手机号是否已注册（已注册不能通过验证）
 */
class PhoneExistVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        $data = (new Users())->get_data_by_phone($value);
        return !boolval($data);
    }

    public function message(){
        return "此账号已被注册";
    }
}