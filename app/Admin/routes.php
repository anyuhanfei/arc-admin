<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('idx/banner', 'Idx\IdxBannerController');
    $router->resource('sys/setting/set', 'Sys\SysSettingController');
    $router->resource('sys/setting', 'Sys\SysSettingController');
    $router->resource('sys/notice', 'Sys\SysNoticeController');
    $router->resource('users/users', 'Users\UsersController');
    $router->get("get/users", "Users\UsersController@get_users");

    $router->resource('article/article', 'Article\ArticleController');
    $router->resource('article/category', 'Article\ArticleCategoryController');
    $router->get("get/article/categories", "Article\ArticleCategoryController@get_categories");

    $router->resource('log/userfund', 'Log\LogUsersFundController');
    $router->resource('log/sysmessage', 'Log\LogSysMessageController');
    $router->resource('log/userwithdraw', 'Log\LogUserWithdrawController');

});
Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
], function (Router $router) {
    Route::get("captcha/image", "AuthController@captcha_image");
});