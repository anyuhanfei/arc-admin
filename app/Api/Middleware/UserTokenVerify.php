<?php

namespace App\Api\Middleware;

use App\Api\Services\UserService;
use Closure;

use App\Repositories\Users\Users;

class UserTokenVerify{

    /**
     * 判断header中是否传token以验证用户是否登录
     *
     * @param [type] $request
     * @param Closure $next
     * @return void
     */
    public function handle($request, Closure $next){
        if(!$request->hasHeader('token')){
            return error('请先登录', NO_LOGIN);
        }
        $user_id = (new UserService())->use_token_get_id($request->header('token'));
        if($user_id == 0){
            return error('请先登录', NO_LOGIN);
        }
        $request->merge(['user_id' => $user_id]);
        return $next($request);
    }
}
