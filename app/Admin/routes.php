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

    $router->resource('sys/banners', 'Sys\SysBannersController');
    $router->resource('sys/settings/set', 'Sys\SysSettingsController');
    $router->resource('sys/settings', 'Sys\SysSettingsController');
    $router->resource('sys/notices', 'Sys\SysNoticesController');
    $router->resource('sys/message/Log', "Sys\SysMessageLogController");

    $router->resource('users/users', 'Users\UsersController');

    $router->resource('article/article', 'Article\ArticleController');
    $router->resource('article/category', 'Article\ArticleCategoryController');

    $router->resource('log/userfund', 'Log\LogUsersFundController');
    $router->resource('log/userswithdraw', 'Log\LogUsersWithdrawController');

});
Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
], function (Router $router) {
    Route::get("captcha/image", "AuthController@captcha_image");
    Route::get("/get/article/list", "Article\ArticleController@get_article_list");
    Route::get("get/article/categories", "Article\ArticleCategoryController@get_categories");
    Route::get("get/users", "Users\UsersController@get_users");
});