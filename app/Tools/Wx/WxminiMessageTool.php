<?php
namespace App\Tools\Wx;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * 微信小程序消息推送工具类
 */
class WxminiMessageTool{
    protected $appid;
    protected $appsecret;

    public function __construct(){
        $this->appid = env("WXMINI_APPID");
        $this->appsecret = env("WXMINI_SECRET");
    }

    // 使用实例
    // public function 司机消息($openid, $thing1, $thing2, $phone_number7, $number3, $time10){
    //     $template_id = "q_Xv-v4-hxR6XhtAbGOoGgHmIWsfZHVSuxWJZYXi1P8";
    //     $data = [
    //         'thing1'=> ['value'=> $thing1],  //出发地
    //         'thing2'=> ['value'=> $thing2],  //目的地
    //         'phone_number7'=> ['value'=> $phone_number7],  //乘客手机
    //         'number3'=> ['value'=> $number3],  //乘车人数
    //         'time10'=> ['value'=> $time10],  //出发时间
    //     ];
    //     return self::sendMessageWithAccessToken($openid, $template_id, $data);
    // }


    /**
     * 发送订阅消息
     *
     * @param string $openid
     * @param string $template_id 模版id
     * @param array $data  模版对应的内容
     * @return bool
     */
    public function sendMessageWithAccessToken(string $openid, string $template_id, array $data):bool{
        $access_token = $this->get_access_token();
        // 发送订阅消息的接口
        $url = "https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=$access_token";
        // 需要发送的消息体
        $message_data = [
            "touser" => $openid,
            "template_id" => $template_id,
            "page" => "pages/index/index",
            "miniprogram_state" => "formal",
            "lang" => "zh_CN",
            "data" => $data
        ];
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => json_encode($message_data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);
        $response = curl_exec($ch);
        Log::debug($response);
        if (curl_errno($ch)) {
            return false;
        } else {
            return true;
        }
        curl_close($ch);
    }

    /**
     * 获取access_token
     *
     * @return string
     */
    private function get_access_token():string{
        return Cache::remember("wxmini_message_access_token", 60, function(){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($response, true);
            if(isset($data['access_token'])){
                return $data['access_token'];
            }else{
                Log::debug("微信小程序消息推送获取access_token失败");
                return "";
            }
        });
    }
}
