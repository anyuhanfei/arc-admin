<?php
namespace App\Tools\Wx;

use Illuminate\Support\Facades\Log;
use Yansongda\Pay\Pay;

/**
 * 微信支付
 */
class WxPayTool{
    protected $config;

    public function __construct(){
        $this->config = config("pay");
    }

    /**
     * 微信小程序支付，发起支付请求
     *
     * @param int $openid
     * @param string $subject 支付的商品名
     * @param string $order_no 支付记录的支付编号
     * @param int|float|string $amount 支付金额，单位元
     * @return void
     */
    public function mini_pay(int $openid, string $subject, string $order_no, int|float|string $amount){
        $order = [
            'out_trade_no'=> $order_no,
            '_config' => 'default',
            'description'=> $subject,
            'amount' => [
                'total' => intval($amount * 100),
                'currency' => 'CNY',
            ],
            'payer' => [
                'openid' => $openid,
            ]
        ];
        Pay::config($this->config);
        $result = Pay::wechat()->mini($order);
        \Illuminate\Support\Facades\Log::debug($result);
        return $result;
    }

    /**
     * 微信公众号支付
     *
     * @param int $openid
     * @param string $subject 支付的商品名
     * @param string $order_no 支付记录的支付编号
     * @param int|float|string $amount 支付金额，单位元
     * @return void
     */
    public function jsapi_pay(int $openid, string $subject, string $order_no, int|float|string $amount){
        Pay::config($this->config);
        $order = [
            'out_trade_no' => $order_no,
            'description' => $subject,
            'amount' => [
                'total' => intval($amount * 100),
            ],
            'payer' => [
                'openid' => $openid,
            ],
        ];
        $response = Pay::wechat()->mp($order);
        \Illuminate\Support\Facades\Log::debug($response);
        return $response;
    }

    /**
     * app支付
     *
     * @param string $subject
     * @param string $order_no
     * @param integer|float $money
     * @return void
     */
    public function app_pay(string $subject, string $order_no, int|float $money){
        Pay::config($this->config);
        $order = [
            'out_trade_no' => $order_no,
            'description' => $subject,
            'amount' => [
                'total' => intval($money * 100),
            ],
        ];
        $response = Pay::wechat()->app($order);
        return $response;
    }

    /**
     * 退款
     *
     * @param string $order_no 此订单编号是支付记录的订单编号，而非订单数据中的订单编号
     * @param integer|float $money
     * @return void
     */
    public function refund(string $order_no, int|float $money){
        Pay::config($this->config);
        $order = [
            'out_trade_no' => $order_no,
            'out_refund_no' => '' . time(),
            'amount' => [
                'refund' => intval($money * 100),
                'total' => intval($money * 100),
                'currency' => 'CNY',
            ],
        ];
        $result = Pay::wechat()->refund($order);
        if($result['code'] != 'SUCCESS'){
            // throwBusinessException(strval($result));
        }
    }

    /**
     * 转账
     *
     * @param string $openid
     * @param integer $user_id
     * @param integer|float $money
     * @param string $title
     * @return void
     */
    public function transfer(string $openid, int $user_id, int|float $money, string $title){
        Pay::config($this->config);
        $out_batch_no = time().'';
        $order = [
            'out_batch_no' => $out_batch_no,
            'batch_name' => $title,
            'batch_remark' => strval(time()),
            'total_amount' => intval($money * 100),
            'total_num' => 1,
            'transfer_detail_list' => [
                [
                    'out_detail_no' => $out_batch_no.'1',
                    'transfer_amount' => intval($money * 100),
                    'transfer_remark' => strval(time()),
                    'openid' => $openid,
                ],
            ],
        ];
        $result = Pay::wechat()->transfer($order);
        if($result['batch_status'] != 'ACCEPTED'){
            throwBusinessException(strval($result));
        }
        Log::debug($result);
        return $result['batch_id'];
    }


    /**
     * 支付回调验证
     * 微信的支付回调验证返回中包含订单编号
     *
     * @return void
     */
    public function notify_verify(){
        Pay::config($this->config);
        return Pay::wechat()->callback();
    }
}
