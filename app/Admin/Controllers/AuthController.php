<?php

namespace App\Admin\Controllers;

use Illuminate\Support\Facades\Validator;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;
use Dcat\Admin\Http\Controllers\AuthController as BaseAuthController;

class AuthController extends BaseAuthController{

    protected $view = 'admin.login';

    public function getLogin(Content $content){
        if ($this->guard()->check()) {
            return redirect($this->getRedirectPath());
        }

        return $content->full()->body(view($this->view));
    }

    /**
     * Handle a login request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function postLogin(Request $request){
        // 验证验证码
        $captcha = $request->input('captcha', '');
        $storedCaptcha = $request->input('captcha_code', '');
        if(!hash_equals(strtolower($captcha), strtolower($storedCaptcha))){
            return $this->validationErrorsResponse([
                'captcha' => "验证码输入错误",
            ]);
        }
        return parent::postLogin($request);
    }
}
