<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Redis;

/**
 * 杂项数据查询
 */
class Misc{
    /**
     * 存储已发送的短信的验证码，便于后续验证
     *
     * @param string $phone
     * @param integer $sms_code
     * @return void
     */
    public function save_smscode(string $phone, int $sms_code):bool{
        Redis::setex("sms_code:{$phone}", 60 * 5, $sms_code);
        return true;
    }

    /**
     * 验证验证码是否正确
     *
     * @param string $phone
     * @param integer $sms_code
     * @return void
     */
    public function verify_smscode(string $phone, int $sms_code):bool{
        $res = Redis::get("sms_code:{$phone}") == $sms_code;
        if($res){
            Redis::del("sms_code:{$phone}");
        }
        return $res;
    }
}