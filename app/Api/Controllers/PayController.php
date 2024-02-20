<?php
namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Api\Controllers\BaseController;

use App\Api\Services\PayService;


/**
 * 支付模块
 */
class PayController extends BaseController{

    protected $service;

    public function __construct(Request $request, PayService $PayService){
        parent::__construct($request);
        $this->service = $PayService;
    }

    /**
     * 支付宝回调
     *
     * @param Request $request
     * @return void
     */
    public function alipay_notify(Request $request){
        $this->service->alipay_notify_operation($request->input());
    }

    /**
     * 微信回调
     *
     * @param Request $request
     * @return void
     */
    public function wxpay_notify(Request $request){
        $this->service->wxpay_notify_operation($request->input());
    }
}
