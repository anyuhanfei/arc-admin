<?php

use App\Admin\Controllers\AppVersionsController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

use App\Admin\Controllers\Sys;
use App\Admin\Controllers\Users;
use App\Admin\Controllers\Article;
use App\Admin\Controllers\AuthController;
use App\Admin\Controllers\Feedback;
use App\Admin\Controllers\Faqs;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('sys/banners', Sys\SysBannersController::class);
    $router->resource('sys/settings/set', Sys\SysSettingsController::class);
    $router->resource('sys/settings', Sys\SysSettingsController::class);
    $router->resource('sys/notices', Sys\SysNoticesController::class);
    $router->resource('sys/messages', Sys\SysMessageLogsController::class);

    $router->resource('users/users', Users\UsersController::class);
    $router->resource('log/balances', Users\UserBalanceLogsController::class);
    $router->resource('log/withdraws', Users\UserWithdrawLogsController::class);

    $router->resource('article/articles', Article\ArticlesController::class);
    $router->resource('article/categories', Article\ArticleCategoriesController::class);
    $router->resource('feedback/types', Feedback\FeedbackTypesController::class);
    $router->resource('feedback/feedbacks', Feedback\FeedbacksController::class);
    $router->resource('faqs/types', Faqs\FaqTypesController::class);
    $router->resource('faqs/faqs', Faqs\FaqsController::class);
    $router->resource('app/versions', AppVersionsController::class);

});
Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
], function (Router $router) {
    Route::get("captcha/image", [AuthController::class, 'captcha_image']);
    Route::get("/get/articles/list", [Article\ArticlesController::class, 'get_articles_list']);
    Route::get("get/article/categories", [Article\ArticleCategoriesController::class, 'get_categories']);
    Route::get("get/users", [Users\UsersController::class, 'get_users']);
    Route::get("get/faqs/types", [Faqs\FaqTypesController::class, 'get_types']);
});