<?php
namespace App\Tools\Wx;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * 微信小程序二维码生成
 */
class WxminiQrcodeTool{
    protected $appid;
    protected $secret;
    protected $uploads_file;

    public function __construct(){
        //微信小程序配置
        $this->appid = env("WXMINI_APPID");
        $this->secret = env("WXMINI_SECRET");
        $this->uploads_file = "./uploads/wxmini_qrcode/";  # 必须自行创建目录
    }

    /**
     * 创建并返回小程序二维码路径
     *
     * @param string $scene
     * @param string $page
     * @return void
     */
    public function get_qrcode_path(string $scene, string $page = ''):string{
        if(!file_exists($this->uploads_file . $scene. '.png')){
            // 文件不存在
            $this->create_qrcode($scene, $page);
        }
        return config("app.url") . "/uploads/wxmini_qrcode/" . $scene . ".png";
    }

    /**
     * 获取access_token
     *
     * @return string
     */
    private function get_access_token():string{
        return Cache::remember("wxmini_message_access_token", 60, function(){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->secret}";
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

    /**
     * 获取小程序码，适用于需要的码数量极多的业务场景。通过该接口生成的小程序码，永久有效，数量暂无限制
     * @param scene 进入小程序时的参数，最大32个可见字符 (必填参数 不能为空，不传会报错)
     *              同时也是保存的图片名称，如果业务不符合，需要自行修改
     * @param page 必须是已经发布的小程序存在的页面（否则报错） 根路径前不要加 /，如：pages/index/index  如果不填写这个字段，默认跳主页面
     * @param width 二维码的宽度，默认值：430  单位 px，最小 280px，最大 1280px
     * @param autoColor 自动配置线条颜色，如果颜色依然是黑色，则说明不建议配置主色调，默认 false
     * @param line_color auto_color 为 false 时生效，使用 rgb 设置颜色 例如 {"r":"xxx","g":"xxx","b":"xxx"} 十进制表示
     * @param is_hyaline 是否需要透明底色，为 true 时，生成透明底色的小程序
     */
    private function create_qrcode($scene, $page = '', $width = 430, $autoColor = false, $lineColor = [], $isHyaline = false){
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $this->get_access_token();
        $lineColor = $lineColor ?? ["r" => "0", "g" => "0", "b" => "0"];
        $params = [
            'scene' => $scene,
            'page' => $page,
            'width' => intval($width),
            'auto_color' => $autoColor,
            'is_hyaline' => $isHyaline
        ];
        $result = $this->post($url, json_encode($params));
        // 判断是否是 json格式， 如果请求失败，会返回 JSON 格式的数据。
        if (!is_null(json_decode($result))) {
            Log::debug("微信小程序消息推送二维码生成失败");
            Log::debug(json_decode($result));
            return false;
        }
        $filePath = "{$this->uploads_file}{$scene}.png";
        $file = fopen($filePath, 'w');
        fwrite($file, $result);
        fclose($file);
        return true;
    }


    /**
     * 发送POST请求
     * @param url  请求的地址
     * @param data 请求的参数
     */
    private function post($url, $data){
        $curl = curl_init($url);
        $upload = false;
        if(is_array($data)){
            foreach($data as $key=> $rs){
                if(is_object($rs)){
                    $upload = true;
                }
            }
            if(!$upload){
                $data = http_build_query($data);
            }
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $return = curl_exec($curl);
        curl_close($curl);
        return $return;
    }
}