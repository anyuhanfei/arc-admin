<?php
namespace App\Api\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Api\Services\UserService;

/**
 * 控制器基类
 */
class BaseController extends Controller{
    protected $user_id;
    protected $token;

    public function __construct(Request $request){
        // 通过 header 中的 token 获取对应的 会员id
        if($request->hasHeader('token')){
            $user_service = new UserService();
            $this->user_id = $user_service->use_token_get_id($request->header('token'));
            $this->token = $request->header('token');
        }else{
            $this->user_id = 0;
            $this->token = '';
        }
    }

    public function test(){
        $data = ['products' => ['desk' => ['price' => 100]]];
        data_set($data, 'products.desk.price', 200);
    }
}
