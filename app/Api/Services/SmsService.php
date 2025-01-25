<?php
namespace App\Api\Services;

use Illuminate\Support\Facades\Redis;

use App\Repositories\Misc;
use App\Repositories\Users\Users;

class SmsService{
    /**
     * 发送短信验证码
     *
     * @param int $phone
     * @return void
     */
    public function send_sms_code_operation(int|string $phone, int $user_id){
        if($phone == ''){
            $user = (new Users())->get_data_by_id($user_id);
            if(!$user){
                throwBusinessException("请填写手机号");
            }
        }
        $sms_code = rand(100000, 999999);
        (new Misc())->save_smscode($phone, $sms_code);
        $this->send('code', $phone, ['code'=> $sms_code]);
    }

    /**
     * 发送短信（提示语等非验证码场景）
     *
     * @param string|integer $phone
     * @param string $type
     * @param array $params
     * @return void
     */
    public function send_sms(string|int $phone, string $type, array $params = array()){
        switch($type){
            default:
                throwBusinessException('请传入正确的发送类型');
        }
        $this->send($type, $phone, $params);
    }

    /**
     * 调用第三方短信发送接口
     *
     * @param int $phone
     * @param int $sms_code
     * @return bool
     */
    protected function send(string $type, string $phone, array $param = []){
        // TODO::这里是第三方短信的发送逻辑代码
    }
}