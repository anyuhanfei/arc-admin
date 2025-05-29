<?php
namespace App\Tools\Sms;

use Illuminate\Support\Env;

class SmsbaoTool implements SmsInterface{
    public $status_str = [
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
    ];
    public $smsapi = "http://api.smsbao.com/";
    public $user = '';
    public $pass = '';
    public $sign = '';

    public function __construct(){
        $this->user = Env::get('SMSBAO_USERNAME');
        $this->pass = md5(Env::get('SMSBAO_PASSWORD'));
        $this->sign = Env::get('SMSBAO_SIGN');
        if(empty($this->user) || empty($this->pass)){
            throwBusinessException('短信宝配置错误');
        }
    }

    public function send_sms_code($phone, $code, $params = array()){
        $content = $this->sign . "您的验证码是".$code."。如非本人操作，请忽略本短信";
        $sendurl = $this->smsapi."sms?u=".$this->user."&p=".$this->pass."&m=".$phone."&c=".urlencode($content);
        $result = file_get_contents($sendurl) ;
        if($result != "0"){
            throwBusinessException($this->status_str[$result]);
        }
    }

    public function send_sms($phone, $type, $params = array()){
        
    }
}