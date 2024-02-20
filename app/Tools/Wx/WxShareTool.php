<?php
namespace App\Tools\Wx;

use Illuminate\Support\Facades\Cache;

/**
 * 微信分享
 * 分享出的数据可以不是普通url，而是图文样式
 */
class WxShareTool{
    private $appid;
    private $secret;

    public function __construct(){
        $this->appid = env("WX_APPID");
        $this->secret = env("WX_APPSECRET");
    }

    /**
     * 将需要分享的url做成前端分享需要的数据格式
     *
     * @param string $url 需要分享的真实url
     * @return array
     */
    public function index(string $url):array{
        $jsapi_ticket = $this->get_jsapi_ticket();

        $timestamp = time();
        $noncestr = create_captcha(16, "lowercase+uppercase+figure");
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket={$jsapi_ticket}&noncestr={$noncestr}&timestamp={$timestamp}&url={$url}";
        $signature = sha1($string);

        $sign_package = array(
            "appId"     => $this->appid,
            "noncestr"  => $noncestr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $sign_package;
    }

    /**
     * 获取ticket
     *
     * @return string
     */
    private function get_jsapi_ticket():string{
        $appid = $this->appid;
        $secret = $this->secret;
        // 获得access_token, access_token 可保存7200s
        $access_token = Cache::remember("wx_at", 3600, function() use($appid, $secret){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
            $result = json_decode(file_get_contents($url), true);
            return $result['access_token'];
        });
        // 获取 ticket, ticket 同样可保存 7200s
        $ticket = Cache::remember("wx_ticket", 3600, function() use($access_token){
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token={$accessToken}";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token={$access_token}";
            $res = $this->curl_post($url);
            return $res['ticket'];
        });
        return $ticket;
    }

    private function curl_post(string $url , array $data = array()):array{
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
