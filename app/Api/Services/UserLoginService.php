<?php
namespace App\Api\Services;

use Illuminate\Support\Str;

use App\Repositories\Users\Users;

use App\Tools\Wx\WxappLoginTool;
use App\Tools\Wx\WxLoginTool;
use App\Tools\Wx\WxminiLoginTool;
use App\Tools\YidunMobileTool;

/**
 * 用户登录服务
 */
class UserLoginService{
    protected $repository;

    public function __construct(Users $users){
        $this->repository = $users;
    }

    /**
     * 账号密码注册
     *
     * @param string $account
     * @param string $password
     * @return void
     */
    public function account_register_operation(string $account, string $password){
        $data = $this->repository->create_data([
            'account' => $account,
            'password' => $password
        ]);
        return boolval($data);
    }

    /**
     * 账号密码登录
     *
     * @param string $account
     * @param string $password
     * @return void
     */
    public function account_login_operation(string $account, string $password){
        $data = $this->repository->get_data_by_account($account);
        if(!$data || $this->repository->verify_user_password($data->password, $password) == false){
            throwBusinessException("账号或密码错误");
        }
        return $this->_user_login_data($data);
    }

    /**
     * 手机号-密码注册
     *
     * @param string $phone
     * @param string $password
     * @return void
     */
    public function phone_password_register_operation(string $phone, string $password){
        $data = $this->repository->create_data([
            'phone' => $phone,
            'password' => $password
        ]);
        return boolval($data);
    }

    /**
     * 手机号密码登录
     *
     * @param string $phone
     * @param string $password
     * @return void
     */
    public function phone_password_login_operation(string $phone, string $password){
        $data = $this->repository->get_data_by_phone($phone);
        if(!$data || $this->repository->verify_user_password($data->password, $password) == false){
            throwBusinessException("手机号或密码错误");
        }
        return $this->_user_login_data($data);
    }

    /**
     * 手机号验证码登录（前置条件：在接收数据阶段已经进行了短信验证码验证）
     *
     * @param string $phone
     * @return void
     */
    public function phone_smscode_login_operation(string $phone){
        $data = $this->repository->get_data_by_phone($phone);
        if(!$data){
            // 走注册流程
            $data = $this->repository->create_data([
                'phone' => $phone,
            ]);
        }
        return $this->_user_login_data($data);
    }

    /**
     * 网易易盾一键获取手机号登录(自动注册)
     *
     * @param string $token
     * @param string $accessToken
     * @return void
     */
    public function yidun_oauth_login_operation(string $token, string $accessToken){
        try{
            $yidun_data = (new YidunMobileTool())->oauth($token, $accessToken);
            $phone = $yidun_data['data']['phone'];
        }catch(\Exception $e){
            throwBusinessException("获取手机号失败，原因为:{$e->getMessage()}");
        }
        $data = $this->repository->get_data_by_phone($phone);
        if(!$data){
            // 走注册流程
            $data = $this->repository->create_data([
                'phone' => $phone,
            ]);
        }
        return $this->_user_login_data($data);
    }

    /**
     * 微信公众号授权登录（自动注册）
     *
     * @param string $code
     * @return void
     */
    public function wx_oauth_login_operation(string $code){
        $wx_data = (new WxLoginTool())->oauth($code);
        if($wx_data['openid'] == ''){
            throwBusinessException("登录失败");
        }
        $data = $this->repository->get_data_by_wx_openid($wx_data['openid']);
        if(!$data){
            // 走注册流程
            $data = $this->repository->create_data([
                'wx_openid'=> $wx_data['openid'],
                'unionid'=> $wx_data['unionid'],
                'nickname'=> $wx_data['nickname'],
                'avatar'=> $wx_data['headimgurl'],
            ]);
        }
        return $this->_user_login_data($data);
    }

    /**
     * 微信小程序授权登录（自动注册）
     *
     * @param string $code
     * @return void
     */
    public function wxmini_oauth_login_operation(string $code){
        $wx_data = (new WxminiLoginTool())->oauth($code);
        $data = $this->repository->get_data_by_wxmini_openid($wx_data['openid']);
        if(!$data){
            // 走注册流程
            $data = $this->repository->create_data([
                'wxmini_openid'=> $wx_data['openid'],
                'nickname'=> $wx_data['nickname'],
                'avatar'=> $wx_data['avatar'],
                'phone'=> $wx_data['phone'],
            ]);
        }
        return $this->_user_login_data($data);
    }

    /**
     * 微信APP授权登录（自动注册）
     *
     * @param string $code
     * @return void
     */
    public function wxapp_oauth_login_operation(string $code){
        $token_data = (new WxappLoginTool())->get_access_token($code);
        $openid = $token_data['openid'];
        $access_token = $token_data['access_token'];
        // 获取到了openid，检测是否已经注册
        $user_data = (new Users())->get_data_by_wxapp_openid($openid);
        if(!$user_data){
            // 走注册流程
            $wx_user_data = (new WxappLoginTool())->get_user_info($access_token, $openid);
            $user_data = (new Users())->create_data([
                'wxapp_openid'=> $openid,
                'nickname' => $wx_user_data['nickname'] ?? "微信用户_".Str::random(6),
                'avatar' => $wx_user_data['headimgurl'],
            ]);
        }
        return $this->_user_login_data($user_data);
    }

    /**
     * 整合登录后需要的基本信息
     */
    public function _user_login_data($user_data){
        $this->repository->verify_status_by_user($user_data);
        $data = [
            'user_id'=> $user_data->id,
            'avatar'=> $user_data->full_avatar,
            'phone'=> $user_data->phone,
            'token'=> $this->repository->set_token($user_data->id),
            'openid'=> $user_data->openid
        ];
        return $data;
    }
}
