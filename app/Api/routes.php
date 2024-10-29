<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;


// 上传文件
Route::post('upload', [\App\Api\Controllers\ToolsController::class, 'upload']);
// 发送短信验证码
Route::post('send/sms', [\App\Api\Controllers\ToolsController::class, 'send_sms']);
// 生成验证码图片
Route::get('captcha_image', [\App\Api\Controllers\ToolsController::class, 'captcha_image']);

// 账号登录注册
Route::post('register/account', [\App\Api\Controllers\UserLoginController::class, 'account_register']);
Route::post('login/account', [\App\Api\Controllers\UserLoginController::class, 'account_login']);
// 手机号登录注册
Route::post('register/phone/password', [\App\Api\Controllers\UserLoginController::class, 'phone_password_register']);
Route::post('login/phone/password', [\App\Api\Controllers\UserLoginController::class, 'phone_password_login']);
Route::post('login/phone/smscode', [\App\Api\Controllers\UserLoginController::class, 'phone_smscode_login']);
// 其他登录方式
Route::post('login/yidun_oauth', [\App\Api\Controllers\UserLoginController::class, 'yidun_oauth_login']);
Route::post('login/wx_oauth', [\App\Api\Controllers\UserLoginController::class, 'wx_oauth_login']);
Route::post('login/wxmini_oauth', [\App\Api\Controllers\UserLoginController::class, 'wxmini_oauth_login']);

// 系统设置
Route::post('sys/banner', [\App\Api\Controllers\SysController::class, 'banner_list']);
// 系统公告
Route::post('sys/notice', [\App\Api\Controllers\SysController::class, 'notice']);
Route::post('sys/notice/list', [\App\Api\Controllers\SysController::class, 'notice_list']);
// 文章
Route::post('sys/article/category', [\App\Api\Controllers\SysController::class, 'article_category_list']);
Route::post('sys/article/list', [\App\Api\Controllers\SysController::class, 'article_list']);
Route::post('sys/article/detail', [\App\Api\Controllers\SysController::class, 'article_detail']);

// 第三方支付的回调接口
Route::match(['get', 'post'], 'wxpay/notify', [\App\Api\Controllers\PayController::class, 'wxpay_notify']);
Route::match(['get', 'post'], 'alipay/notify', [\App\Api\Controllers\PayController::class, 'alipay_notify']);

Route::post('test', [\App\Api\Controllers\BaseController::class, 'test']);

Route::group([
    'middleware' => ['user.token'],
], function(Router $router){
    // 会员详情
    $router->post('user/detail', [\App\Api\Controllers\UserController::class, 'user_detail']);
    $router->post('user/update/data', [\App\Api\Controllers\UserController::class, 'update_data']);

    // 会员资产记录、系统消息、提现记录
    $router->post('user/sys/sysmessage/list', [\App\Api\Controllers\UserController::class, 'sys_message_list']);
    $router->post('user/sys/sysmessage/detail', [\App\Api\Controllers\UserController::class, 'sys_message_detail']);
    $router->post('user/fund/list', [\App\Api\Controllers\UserController::class, 'user_fund_list']);
    $router->post('user/withdraw', [\App\Api\Controllers\UserController::class, 'withdraw']);
    $router->post('user/withdraw/list', [\App\Api\Controllers\UserController::class, 'withdraw_list']);

    // 会员密码
    $router->post('user/update_password', [\App\Api\Controllers\UserController::class, 'update_password']);
    $router->post('user/forget_password', [\App\Api\Controllers\UserController::class, 'forget_password']);

    // 会员退出登录
    $router->post('user/logout', [\App\Api\Controllers\UserController::class, 'logout']);
});
