<?php
namespace App\Api\Controllers;

use Illuminate\Http\Request;

use App\Api\Controllers\BaseController;
use App\Api\Services\UserLoginService;

/**
 * 会员登录相关
 */
class UserLoginController extends BaseController{
    protected $service;

    public function __construct(Request $request, UserLoginService $UserLoginService){
        parent::__construct($request);
        $this->service = $UserLoginService;
    }

    /**
     * 账号密码注册
     *
     * @param \App\Api\Requests\UserLogin\AccountRegisterRequest $request
     * @return void
     */
    public function account_register(\App\Api\Requests\UserLogin\AccountRegisterRequest $request){
        $account = $request->input('account');
        $password = $request->input('password');
        $res = $this->service->account_register_operation($account, $password);
        return success('注册成功');
    }

    /**
     * 账号密码登录
     *
     * @param \App\Api\Requests\UserLogin\AccountLoginRequest $request
     * @return void
     */
    public function account_login(\App\Api\Requests\UserLogin\AccountLoginRequest $request){
        $account = $request->input('account');
        $password = $request->input('password');
        $data = $this->service->account_login_operation($account, $password);
        return success('登录成功', $data);
    }

    /**
     * 手机号密码注册
     *
     * @param \App\Api\Requests\UserLogin\PhonePasswordRegisterRequest $request
     * @return void
     */
    public function phone_password_register(\App\Api\Requests\UserLogin\PhonePasswordRegisterRequest $request){
        $phone = $request->input('phone');
        $password = $request->input('password');
        $res = $this->service->phone_password_register_operation($phone, $password);
        return success('注册成功');
    }

    /**
     * 手机号密码登录
     *
     * @param \App\Api\Requests\UserLogin\PhonePasswordLoginRequest $request
     * @return void
     */
    public function phone_password_login(\App\Api\Requests\UserLogin\PhonePasswordLoginRequest $request){
        $phone = $request->input('phone');
        $password = $request->input('password');
        $data = $this->service->phone_password_login_operation($phone, $password);
        return success('登录成功', $data);
    }

    /**
     * 手机号短信登录(一键登录不用注册)
     *
     * @param \App\Api\Requests\UserLogin\PhoneSmscodeLoginRequest $request
     * @return void
     */
    public function phone_smscode_login(\App\Api\Requests\UserLogin\PhoneSmscodeLoginRequest $request){
        $phone = $request->input('phone');
        $data = $this->service->phone_smscode_login_operation($phone);
        return success('登录成功', $data);
    }

    /**
     * 易盾一键登录
     *
     * @param Request $request
     * @return void
     */
    public function yidun_oauth_login(\App\Api\Requests\UserLogin\YidunOauthLoginRequest $request){
        $token = $request->input('token', '');
        $accessToken = $request->input('accessToken', '');
        $data = $this->service->yidun_oauth_login_operation($token, $accessToken);
        return success('登录成功', $data);
    }

    /**
     * 微信公众号登录(第三方登录)
     *
     * @param Request $request
     * @return void
     */
    public function wx_oauth_login(\App\Api\Requests\UserLogin\WxOauthLoginRequest $request){
        $code = $request->input('code', '');
        $data = $this->service->wx_oauth_login_operation($code);
        return success('登录成功', $data);
    }

    /**
     * 微信小程序登录(第三方登录)
     *
     * @param Request $request
     * @return void
     */
    public function wxmini_oauth_login(\App\Api\Requests\UserLogin\WxOauthLoginRequest $request){
        $code = $request->input('code', '');
        $iv = $request->input('iv', '') ?? '';
        $encryptedData = $request->input('encryptedData', '') ?? '';
        $data = $this->service->wxmini_oauth_login_operation($code, $iv, $encryptedData);
        return success('登录成功', $data);
    }
}
