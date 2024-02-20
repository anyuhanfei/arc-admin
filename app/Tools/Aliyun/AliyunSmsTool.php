<?php
namespace App\Tools\Aliyun;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use \Exception;
use AlibabaCloud\Tea\Exception\TeaError;

use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;

# 阿里云短信发送工具
# composer require alibabacloud/dysmsapi-20170525 2.0.23
class AliyunSmsTool{

    protected $accessKeyId;
    protected $accessKeySecret;
    protected $config;

    public function __construct(){
        $this->accessKeyId = env('ALIYUN_AK');
        $this->accessKeySecret = env("ALIYUN_AS");
        $this->config = new Config([
            "accessKeyId" => $this->accessKeyId,
            "accessKeySecret" => $this->accessKeySecret
        ]);
    }

    /**
     * 使用阿里云发送短信验证码
     *
     * @param string $phone
     * @param integer $sms_code
     * @return void
     */
    public function aliyun_sms_code(string $phone, int $sms_code){
        $this->config->endpoint = "dysmsapi.aliyuncs.com";
        $client = new Dysmsapi($this->config);
        $sendSmsRequest = new SendSmsRequest([
            "phoneNumbers" => $phone,
            "signName" => env("ALIYUN_SMS_SIGN_NAME"),
            "templateCode" => env("ALIYUN_SMS_TEMPLATE_CODE"),
            "templateParam" => "{\"code\": \"" . $sms_code . "\"}"
        ]);
        $runtime = new RuntimeOptions([]);
        try{
            $client->sendSmsWithOptions($sendSmsRequest, $runtime);
        }catch(Exception $error){
            if(!($error instanceof TeaError)){
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            throwBusinessException($error->message);
        }
    }
}