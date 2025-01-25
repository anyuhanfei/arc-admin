<?php
namespace App\Tools\Wx;

use Illuminate\Support\Facades\Cache;
use App\Api\Repositories\User\UsersRepository;

/**
 * 微信公众号模版推送
 * 需要在公众平台设置模版
 */
class WxTemplateTool{
    private $appid;
    private $secret;

    public function __construct(){
        $this->appid = env("WX_APPID");
        $this->secret = env("WX_APPSECRET");
    }

    public function index(int $user_id, int $template_id, array $data, string $url = ""):bool{
        $openid = (new UsersRepository())->get_openid_by_id($user_id, "微信公众号");
        if($openid == ''){
            return false;
        }
        $appid = $this->appid;
        $secret = $this->secret;
        // 获得access_token, access_token 可保存7200s
        $access_token = Cache::remember("wx_at", 3600, function() use($appid, $secret){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
            $result = json_decode(file_get_contents($url), true);
            return $result['access_token'];
        });
        //发送模板消息
        $fasuerl = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $params = json_encode(array(
            "touser"=> $openid,
            "template_id"=> $template_id,
            "url"=> $url,
            "data" => $data
        ));
        $res = $this->curl_post($fasuerl,$params);
        return true;
    }

    private function curl_post(string $url , array $data=array()):array{
        $ch = curl_init();//创建curl请求
        curl_setopt($ch, CURLOPT_URL,$url); //设置发送数据的网址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设置有返回值，0，直接显示
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0); //禁用证书验证
        curl_setopt($ch, CURLOPT_POST, 1);//post方法请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//post请求发送的数据包
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data,true); //将json数据转成数组
        return $data;
    }
}