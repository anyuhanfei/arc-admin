<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;


// 上传文件
Route::post('upload', [\App\Api\Controllers\ToolsController::class, 'upload']);
// 发送短信验证码
Route::post('send/sms', [\App\Api\Controllers\ToolsController::class, 'send_sms_code']);


// 账号登录注册
Route::post('register/account', [\App\Api\Controllers\UserLoginController::class, 'account_register']);
Route::post('login/account', [\App\Api\Controllers\UserLoginController::class, 'account_login']);
// 手机号密码登录注册
Route::post('register/phone/password', [\App\Api\Controllers\UserLoginController::class, 'phone_password_register']);
Route::post('login/phone/password', [\App\Api\Controllers\UserLoginController::class, 'phone_password_login']);
// 手机号验证码登录注册
Route::post('login/phone/smscode', [\App\Api\Controllers\UserLoginController::class, 'phone_smscode_login']);
// 其他登录方式（云盾、微信公众号、微信小程序）
Route::post('login/yidun/oauth', [\App\Api\Controllers\UserLoginController::class, 'yidun_oauth_login']);
Route::post('login/wx/oauth', [\App\Api\Controllers\UserLoginController::class, 'wx_oauth_login']);
Route::post('login/wxmini/oauth', [\App\Api\Controllers\UserLoginController::class, 'wxmini_oauth_login']);
Route::post('login/wxapp/oauth', [\App\Api\Controllers\UserLoginController::class, 'wxapp_oauth_login']);


// 轮播图列表
Route::post('sys/banners/list', [\App\Api\Controllers\SysController::class, 'banners_list']);
// 系统公告
Route::post('sys/notices/list', [\App\Api\Controllers\SysController::class, 'notices_list']);
Route::post('sys/notice/detail', [\App\Api\Controllers\SysController::class, 'notice_detail']);
// 文章
Route::post('sys/article/categories', [\App\Api\Controllers\SysController::class, 'article_categories_list']);
Route::post('sys/articles/list', [\App\Api\Controllers\SysController::class, 'articles_list']);
Route::post('sys/article/detail', [\App\Api\Controllers\SysController::class, 'article_detail']);
// 协议
Route::post('sys/agreement/detail', [\App\Api\Controllers\SysController::class, 'agreement_detail']);
// 意见反馈类型
Route::post('feedback/types', [\App\Api\Controllers\SysController::class, 'feedback_types_list']);
// 常见问题
Route::post('sys/faqs/list', [\App\Api\Controllers\SysController::class, 'faqs_list']);
// 系统设置
Route::post('sys/data', [\App\Api\Controllers\SysController::class, 'sys_data']);
// 版本控制
Route::post('sys/app/version/check', [\App\Api\Controllers\SysController::class, 'app_version_check']);


// 第三方支付的回调接口
Route::match(['get', 'post'], 'wxpay/notify', [\App\Api\Controllers\PayController::class, 'wxpay_notify']);
Route::match(['get', 'post'], 'alipay/notify', [\App\Api\Controllers\PayController::class, 'alipay_notify']);


// 需要登录凭证的接口
Route::group([
    'middleware' => ['user.token'],
], function(Router $router){
    // 会员详情
    $router->post('user/detail', [\App\Api\Controllers\UserController::class, 'user_detail']);
    // 修改会员基本信息
    $router->post('user/update/data', [\App\Api\Controllers\UserController::class, 'update_basic_detail']);

    // 绑定微信小程序/APP/公众号手机号
    $router->post('user/bind/wxmini/phone', [\App\Api\Controllers\UserController::class, 'bind_wxmini_phone']);
    $router->post('user/bind/wxapp/phone', [\App\Api\Controllers\UserController::class, 'bind_wxapp_phone']);
    $router->post('user/bind/wx/phone', [\App\Api\Controllers\UserController::class, 'bind_wx_phone']);

    // 系统消息
    $router->post('user/sys/messages/count', [\App\Api\Controllers\UserController::class, 'sys_message_count']);
    $router->post('user/sys/messages/list', [\App\Api\Controllers\UserController::class, 'sys_messages_list']);
    $router->post('user/sys/message/detail', [\App\Api\Controllers\UserController::class, 'sys_message_detail']);

    // 资产记录
    $router->post('user/balances/list', [\App\Api\Controllers\UserController::class, 'user_balances_log_list']);
    // 提现
    $router->post('user/withdraw', [\App\Api\Controllers\UserController::class, 'withdraw']);
    $router->post('user/withdraws/list', [\App\Api\Controllers\UserController::class, 'withdraws_list']);

    // 意见反馈
    $router->post('feedback/apply', [\App\Api\Controllers\SysController::class, 'feedback']);

    // 会员退出登录
    $router->post('user/logout', [\App\Api\Controllers\UserController::class, 'logout']);

});