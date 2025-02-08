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
    $router->resource('sys/messages', "Sys\SysMessageLogsController");

    $router->resource('users/users', 'Users\UsersController');
    $router->resource('log/balances', 'Users\UserBalanceLogsController');
    $router->resource('log/withdraws', 'Users\UserWithdrawLogsController');

    $router->resource('article/articles', 'Article\ArticlesController');
    $router->resource('article/categories', 'Article\ArticleCategoriesController');
    $router->resource('feedback/types', 'Feedback\FeedbackTypesController');
    $router->resource('feedback/feedbacks', 'Feedback\FeedbacksController');


});
Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
], function (Router $router) {
    Route::get("captcha/image", "AuthController@captcha_image");
    Route::get("/get/articles/list", "Article\ArticlesController@get_articles_list");
    Route::get("get/article/categories", "Article\ArticleCategoriesController@get_categories");
    Route::get("get/users", "Users\UsersController@get_users");
});