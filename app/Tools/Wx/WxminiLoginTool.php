<?php
namespace App\Tools\Wx;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

/**
 * 微信小程序授权登录
 */
class WxminiLoginTool{
    protected $appid;
    protected $secret;
    protected $repository;

    public function __construct(){
        //微信小程序配置
        $this->appid = env("WXMINI_APPID");
        $this->secret = env("WXMINI_SECRET");
    }

    /**
     * 获取openid
     *
     * 当前小程序的政策为：所有用户解析出来的昵称和头像都是微信默认，iv 和 encryptedData 参数可以用来解析用户手机号。
     *  但是当前小程序的逻辑是使用code获取到微信信息后，才可授权获取用户手机号（分步进行）
     *
     * @param string $code
     * @return array
     */
    public function oauth(string $code):array{
        $data = $this->jscode2session($code);
        $this->save_session_key($data['openid'], $data['session_key']);
        return [
            'openid'=> $data['openid'],
            'nickname'=> '微信用户',
            'avatar'=> "https://thirdwx.qlogo.cn/mmopen/vi_32/POgEwh4mIHO4nibH0KlMECNjjGxQUq24ZEaGT4poC6icRiccVGKSyXwibcPq4BWmiaIGuG1icwxaQX6grC9VemZoJ8rg/132",
            'phone'=> '',
        ];
    }

    /**
     * 通过 iv 和 encryptedData 解析到手机号
     *
     * @param string $openid
     * @param string $iv
     * @param string $encryptedData
     * @return string phone
     */
    public function get_wx_phone(string $openid, string $iv, string $encryptedData):string{
        $session_key = $this->get_session_key($openid);
        $user_info = $this->decryptData($this->appid, $session_key, $encryptedData, $iv);
        try{
            return $user_info['phoneNumber'];
        }catch(\Exception $e){
            throwBusinessException($e->getMessage());
        }
    }

    /**
     * 访问微信小程序接口，获取会员openid
     *
     * @param string $code
     * @return void
     */
    private function jscode2session(string $code):array{
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$this->appid}&secret={$this->secret}&js_code={$code}&grant_type=authorization_code";
        $res = json_decode(Http::get($api), true);
        if(!empty($res['errcode'])){
            throwBusinessException($res['errcode']);
        }
        return [
            'session_key'=> $res['session_key'],
            'openid'=> $res['openid'],
        ];
    }

    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return array 返回数据
     */
    private function decryptData($appid, $sessionKey, $encryptedData, $iv){
        if(strlen($sessionKey) != 24){
            throwBusinessException('encodingAesKey 非法');
        }
        $aesKey = base64_decode($sessionKey);
        if(strlen($iv) != 24){
            throwBusinessException('aes 解密失败');
        }
        $aesIV = base64_decode($iv);
        $aesCipher = base64_decode($encryptedData);
        $result = openssl_decrypt($aesCipher, "aes-128-cbc", $aesKey, OPENSSL_RAW_DATA, $aesIV);
        $result = $this->decode($result);
        $dataObj = json_decode($result);
        if($dataObj == NULL){
            throwBusinessException('解密后得到的buffer非法');
        }
        if($dataObj->watermark->appid != $appid){
            throwBusinessException('base64解密失败');
        }
        $data = json_decode($result, true);
        return $data;
    }

    private function decode($text){
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }

    /**
     * 保存openid对应的session_key
     *
     * @param string $openid
     * @param string $session_key
     * @return void
     */
    private function save_session_key(string $openid, string $session_key){
        Redis::set($openid, $session_key);
    }

    /**
     * 获取openid对应的session_key
     *
     * @param string $openid
     * @return string
     */
    private function get_session_key(string $openid):string{
        return Redis::get($openid) ?? '';
    }
}