<?php

namespace App\Admin\Controllers;

use App\Tools\CaptchaImageTool;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;
use Dcat\Admin\Http\Controllers\AuthController as BaseAuthController;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseAuthController{

    protected $view = 'admin.login';

    public function getLogin(Content $content){
        if ($this->guard()->check()) {
            return redirect($this->getRedirectPath());
        }
        return $content->full()->body(view($this->view, ['app_name'=> Env::get("APP_NAME")]));
    }

    /**
     * Handle a login request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function postLogin(Request $request){
        // 判断账户、密码是否填写
        $credentials = $request->only([$this->username(), 'password']);
        $validator = Validator::make($credentials, [
            $this->username()   => 'required',
            'password'          => 'required',
        ], [
            $this->username() . '.required'=> "请输入用户名",
            'password.required' => '请输入密码',
        ]);
        if($validator->fails()) {
            return $this->validationErrorsResponse($validator->errors());
        }

        // 验证验证码
        $captcha = $request->input('captcha', '');
        if(!$captcha){
            return $this->validationErrorsResponse([
                'captcha' => "验证码不能为空",
            ]);
        }
        $_token = $request->input('_token', '');
        $check_res = CaptchaImageTool::check_captcha($_token, $captcha);
        if(!$check_res){
            return $this->validationErrorsResponse([
                'captcha' => "验证码输入错误",
            ]);
        }
        return parent::postLogin($request);
    }

    /**
     * 创建验证码图片
     *
     * @param Request $request
     * @return void
     */
    public function captcha_image(Request $request){
        $_token = $request->input('_token', '');
        return CaptchaImageTool::generate_captcha($_token);
    }
}
