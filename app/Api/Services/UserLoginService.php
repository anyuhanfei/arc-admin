<?php
namespace App\Api\Services;

use App\Repositories\Users\Users;

use App\Tools\Wx\WxLoginTool;
use App\Tools\Wx\WxminiLoginTool;
use App\Tools\YidunMobileTool;

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
        $this->账号冻结验证($data);
        return $this->返回登录数据($data);
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
        $this->账号冻结验证($data);
        return $this->返回登录数据($data);
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
        $this->账号冻结验证($data);
        return $this->返回登录数据($data);
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
        $this->账号冻结验证($data);
        return $this->返回登录数据($data);
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
        $data = $this->repository->get_data_by_openid($wx_data['openid']);
        if(!$data){
            // 走注册流程
            $data = $this->repository->create_data([
                'openid'=> $wx_data['openid'],
                'unionid'=> $wx_data['unionid'],
                'nickname'=> $wx_data['nickname'],
                'avatar'=> $wx_data['headimgurl'],
            ]);
        }
        $this->账号冻结验证($data);
        return $this->返回登录数据($data);
    }

    /**
     * 微信小程序授权登录（自动注册）
     *
     * @param string $code
     * @param string $iv
     * @param string $encryptedData
     * @return void
     */
    public function wxmini_oauth_login_operation(string $code, string $iv, string $encryptedData){
        $wx_data = (new WxminiLoginTool())->oauth($code, $iv, $encryptedData);
        $data = $this->repository->get_data_by_openid($wx_data['openid']);
        if(!$data){
            // 走注册流程
            $data = $this->repository->create_data([
                'openid'=> $wx_data['openid'],
                'nickname'=> $wx_data['nickname'],
                'avatar'=> $wx_data['avatar'],
                'phone'=> $wx_data['phone'],
            ]);
        }
        $this->账号冻结验证($data);
        return $this->返回登录数据($data);
    }

    /**
     * 判断登录的账号是否已冻结，如果已冻结则抛出异常
     *
     * @param object $user_data
     * @return void
     */
    private function 账号冻结验证($user_data){
        if($user_data->login_status == 0){
            throwBusinessException('当前用户已被冻结');
        }
    }

    /**
     * 整合登录后需要的基本信息
     */
    private function 返回登录数据($user_data){
        $data = [
            'user_id'=> $user_data->id,
            'avatar'=> $user_data->avatar,
            'phone'=> $user_data->phone,
            'token'=> $this->repository->set_token($user_data->id),
            'openid'=> $user_data->openid
        ];
        return $data;
    }
}
