<?php
namespace App\Api\Rules;

use App\Repositories\Users\Users;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;


/**
 * 判断账号是否已存在（存在不能通过验证）
 */
class AccountExistVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        $data = (new Users())->use_account_get_data($value);
        return !boolval($data);
    }

    public function message(){
        return "此账号已被注册";
    }
}