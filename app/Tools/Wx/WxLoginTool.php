<?php
namespace App\Tools\Wx;

/**
 * 微信公众号登录
 */
class WxLoginTool{
    protected $appid;
    protected $appsecret;

    public function __construct(){
        $this->appid = env("WX_APPID");
        $this->appsecret = env("WX_APPSECRET");
    }

    /**
     * 获取用户在公众号中的信息
     * 当前逻辑为，通过code获取 access_token 和 openid,
     * 然后通过 access_token 和 openid 获取用户信息
     * 返回微信用的信息数据
     *
     * 注：只获取信息，项目的业务逻辑在外层处理
     *
     * @param string $code
     * @return array 微信用户数据
     */
    public function oauth(string $code):array{
        $tokens = $this->access_token($code);
        $user_info = $this->get_userinfo($tokens['access_token'], $tokens['openid']);
        return $user_info;
    }

    /**
     * 获取access_token
     *
     * @param string $code
     * @return array
     */
    private function access_token(string $code):array{
        $token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->appid . '&secret=' . $this->appsecret . '&code=' . $code . '&grant_type=authorization_code';
        $token = json_decode(file_get_contents($token_url));
        if(isset($token->errcode)){
            throwBusinessException($token->errcode . ': ' . $token->errmsg);
        }
        return [
            'access_token'=> $token->access_token,
            'refresh_token'=> $token->refresh_token,
            'openid'=> $token->openid
        ];
    }

    /**
     * 刷新access_token
     *
     * @param string $refresh_token
     * @return array
     */
    private function refresh_token(string $refresh_token):array{
        $access_token_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=' . $this->appid . '&grant_type=refresh_token&refresh_token=' . $refresh_token;
        $access_token = json_decode(file_get_contents($access_token_url));
        if(isset($access_token->errcode)){
            throwBusinessException($access_token->errcode . ': ' . $access_token->errmsg);
        }
        return [
            'access_token'=> $access_token->access_token,
            'refresh_token'=> $access_token->refresh_token,
            'openid'=> $access_token->openid
        ];
    }

    /**
     * 获取微信用户信息
     *
     * @param string $access_token
     * @param string $openid
     * @return array
     */
    private function get_userinfo(string $access_token, string $openid):array{
        $user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
        $user_info = json_decode(file_get_contents($user_info_url));
        if(isset($user_info->errcode)){
            throwBusinessException($user_info->errcode . ': ' . $user_info->errmsg);
        }
        return [
            'openid'=> $user_info->openid ?? '',
            'unionid'=> $this->get_unionid($access_token, $openid),
            'nickname'=> $user_info->nickname ?? '',
            'sex'=> $user_info->sex ?? '',
            'language'=> $user_info->language ?? '',
            'city'=> $user_info->city ?? '',
            'province'=> $user_info->province ?? '',
            'country'=> $user_info->country ?? '',
            'headimgurl'=> $user_info->headimgurl ?? '',
        ];
    }

    /**
     * 获取微信用户的unionid
     * TODO::未测试
     *
     * @param string $access_token
     * @param string $openid
     * @return string unionid
     */
    private function get_unionid(string $access_token, string $openid):string{
        try{
            $user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $access_token . "&openid=" . $openid . "&lang=zh_CN";
            $result = json_decode(file_get_contents($user_info_url));
            if(isset($result->errcode)){
                throwBusinessException($result->errcode . ': ' . $result->errmsg);
            }
            return empty($result['unionid']) ? '' : $result['unionid'];
        }catch(\Exception $e){
            return "";
        }
    }
}

/**
 * 以上三个接口的具体返回内容：
 *  https://api.weixin.qq.com/sns/oauth2/access_token：
 *   object(stdClass)#1777 (5) {
 *       ["access_token"]=> string(110) "66_DtB6.............KYOVcaXQ"
 *       ["expires_in"]=> int(7200)
 *       ["refresh_token"]=> string(110) "66_8g-.............i8TCGhfc"
 *       ["openid"]=> string(28) "ohyvq6axEpySwbGGfIOxV0a1QTrw"
 *       ["scope"]=> string(15) "snsapi_userinfo"
 *   }
 *
 * https://api.weixin.qq.com/sns/oauth2/refresh_token
 *  object(stdClass)#1776 (5) {
 *       ["openid"]=> string(28) "ohyvq6axEpySwbGGfIOxV0a1QTrw"
 *       ["access_token"]=> string(110) "66_DtB6.............KYOVcaXQ"
 *       ["expires_in"]=> int(7200)
 *       ["refresh_token"]=> string(110) "66_8g-.............i8TCGhfc"
 *       ["scope"]=> string(15) "snsapi_userinfo"
 *   }
 *
 * https://api.weixin.qq.com/sns/userinfo
 *  object(stdClass)#1779 (9) {
 *       ["openid"]=> string(28) "ohyvq6axEpySwbGGfIOxV0a1QTrw"
 *       ["nickname"]=> string(6) "奈亚"
 *       ["sex"]=> int(0)
 *       ["language"]=> string(0) ""
 *       ["city"]=> string(0) ""
 *       ["province"]=> string(0) ""
 *       ["country"]=> string(0) ""
 *       ["headimgurl"]=> string(131) "https://thirdwx.qlogo.cn/mmopen/vi_32/2M99jhPTcZDd3510WQmTC3CHj4s30oMzvnH4H6YMlE0hd7jCibztudNDYibyWYm7tBBic6RR7VMsH3JdurDAXB8Ug/132"
 *       ["privilege"]=> array(0) { }
 *   }
 */