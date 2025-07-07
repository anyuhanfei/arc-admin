<?php

namespace App\Tools\Wx;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WxappLoginTool{
    protected $appId;
    protected $appSecret;
    protected $httpClient;

    public function __construct(){
        $this->appId = env('WXAPP_APPID');
        $this->appSecret = env('WXAPP_SECRET');
        $this->httpClient = new Client([
            'base_uri' => 'https://api.weixin.qq.com/',
            'timeout' => 5.0,
        ]);
    }

    /**
     * 通过code获取access_token和openid
     */
    public function get_access_token($code){
        try{
            $response = $this->httpClient->get('sns/oauth2/access_token', [
                'query' => [
                    'appid' => $this->appId,
                    'secret' => $this->appSecret,
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if(isset($data['errcode'])){
                Log::error('微信获取access_token失败', $data);
                throwBusinessException($data['errmsg'].'('.$data['errcode'].')');
            }
        }catch(\Exception $e){
            $msg = '微信获取access_token异常: '.$e->getMessage();
            Log::error($msg);
            throwBusinessException($msg);
        }
        return $data;

    }

    /**
     * 获取用户信息
     */
    public function get_user_info($accessToken, $openId){
        try{
            $response = $this->httpClient->get('sns/userinfo', [
                'query' => [
                    'access_token' => $accessToken,
                    'openid' => $openId,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if(isset($data['errcode'])){
                Log::error('微信获取用户信息失败', $data);
                throwBusinessException($data['errmsg'].'('.$data['errcode'].')');
            }
        }catch(\Exception $e){
            $msg = '微信获取用户信息异常: '.$e->getMessage();
            Log::error($msg);
            throwBusinessException($msg);
        }
        return $data;
    }

    /**
     * 刷新access_token
     */
    public function refresh_token($refreshToken){
        try{
            $response = $this->httpClient->get('sns/oauth2/refresh_token', [
                'query' => [
                    'appid' => $this->appId,
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                ],
            ]);
            return json_decode($response->getBody()->getContents(), true);
        }catch(\Exception $e){
            $msg = '微信刷新token异常: '.$e->getMessage();
            Log::error($msg);
            throwBusinessException($msg);
        }
    }
}