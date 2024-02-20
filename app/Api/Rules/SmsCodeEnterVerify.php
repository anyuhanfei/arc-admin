<?php
namespace App\Api\Rules;

use App\Repositories\Misc;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

use App\Repositories\Users\Users;

/**
 * 判断短信验证码是否正确（不正确不能通过验证）
 */
class SmsCodeEnterVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        // 如果在开发模式下，可使用通用验证码通过验证
        if(config("app.debug") && $this->data['sms_code'] == '123456'){
            return true;
        }
        // 如果没有传手机号(已登录状态可以不传), 则根据当前登录的id获取手机号
        if(empty($this->data['phone'])){
            if($this->data['user_id'] == 0){
                return false;
            }
            $user = (new Users())->use_id_get_data($this->data['user_id']);
            if(!$user){
                return false;
            }
            $this->data['phone'] = $user->phone;
        }
        // 判断验证码是否正确
        return (new Misc())->verify_smscode($this->data['phone'], $this->data['sms_code']);
    }

    public function message(){
        return '短信验证码输入错误';
    }
}