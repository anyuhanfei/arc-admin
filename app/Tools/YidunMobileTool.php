<?php
namespace App\Tools;


class YidunMobileTool{
    private $url = "https://ye.dun.163.com/v1/oneclick/check";
    private $secretId;
    private $businessId;
    private $version = 'v1';
    private $secretKey;

    public function __construct(){
        $this->secretId = env("YIDUN_SECRET_ID");
        $this->businessId = env("YIDUN_BUSINESS_ID");
        $this->secretKey = env("YIDUN_SECRET_KEY");
    }

    /**
     * TODO::返回数据未知
     *
     * @param [type] $token
     * @param [type] $accessToken
     * @return void
     */
    public function oauth($token, $accessToken){
        $params["token"] = $token;
        $params["accessToken"] = $accessToken;
        $params["secretId"] = $this->secretId;
        $params["businessId"] = $this->businessId;
        $params["version"] = $this->version;
        $params["timestamp"] = sprintf("%d", round(microtime(true) * 1000));
        $params["nonce"] = substr(md5(time()), 0, 32);
        $params = $this->toUtf8($params);
        $params["signature"] = $this->gen_signature($this->secretKey, $params);
        $options = array('http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'timeout' => 5,
            'content' => http_build_query($params)
        ));
        $context = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);
        if($result === FALSE) {
            throwBusinessException("file_get_contents failed.");
        }
        $result = json_decode($result, true);
        if($result['code'] == '401'){
            throwBusinessException("401，登录失败");
        }
        if($result['code'] == '405'){
            throwBusinessException("405，异常");
        }
        return $result;
    }

    public function gen_signature($secretKey, $params){
        ksort($params);
        $buff="";
        foreach($params as $key=>$value){
            $buff .=$key;
            $buff .=$value;
        }
        $buff .= $secretKey;
        return md5(mb_convert_encoding($buff, "utf8", "auto"));
    }

    /**
     * 将输入数据的编码统一转换成utf8
     * @params 输入的参数
     */
    public function toUtf8($params){
        $utf8s = array();
        foreach ($params as $key => $value) {
            $utf8s[$key] = is_string($value) ? mb_convert_encoding($value, "utf8", 'auto') : $value;
        }
        return $utf8s;
    }
}