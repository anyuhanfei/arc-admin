<?php
namespace App\Api\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Repositories\Log\LogUsersPay;
use App\Repositories\Users\Users;

use App\Tools\Aliyun\AliyunPayTool;
use App\Tools\Wx\WxPayTool;

class PayService{
    public function pay(int $user_id, string $pay_method, string $pay_type, int|float $amount, string $relevance, string $subject, string $out_trade_no = ''){
        // 格式化金额
        $amount = round($amount, 2);
        // 创建、使用支付记录
        $pay_log = false;
        if($out_trade_no != ''){
            $pay_log = (new LogUsersPay())->get_data_by_no($out_trade_no);
        }
        if(!$pay_log){
            $out_trade_no = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
            $pay_log = (new LogUsersPay())->create_data($user_id, $out_trade_no, $pay_method, $pay_type, $amount, $relevance);
        }
        // 调用第三方支付
        switch($pay_method){
            case 'app支付宝':
                return ((new AliyunPayTool()))->wap($subject, $out_trade_no, $amount);
                break;
            case "h5支付宝":
                return ((new AliyunPayTool()))->wap($subject, $out_trade_no, $amount);
                break;
            case "app微信":
                return ((new WxPayTool()))->app_pay($subject, $out_trade_no, $amount);
                break;
            case "h5微信":
                $openid = (new Users())->get_openid_by_id($user_id);
                if($openid == ''){
                    throwBusinessException("您尚未绑定微信公众号");
                }
                return ((new WxPayTool()))->jsapi_pay($openid, $subject, $out_trade_no, $amount);
                break;
            case "小程序微信":
                $openid = (new Users())->get_openid_by_id($user_id);
                if($openid == ''){
                    throwBusinessException("您尚未绑定微信小程序");
                }
                return ((new WxPayTool()))->mini_pay($openid, $subject, $out_trade_no, $amount);
                break;
            case "银行卡":
                break;
            default:
                throwBusinessException('支付调用失败');
                break;
        }
        throwBusinessException('支付调用失败');
    }

    /**
     * 阿里云支付回调
     *
     * @param array $request
     * @return bool
     */
    public function alipay_notify_operation(array $params):bool{
        $result = (new AliyunPayTool())->notify_verify($params);
        Log::debug("支付宝支付：" . json_encode($result));
        $res = $this->notify_execute($params['out_trade_no']);
        return $res;
    }

    /**
     * 微信支付回调
     *
     * @param array $request
     * @return bool
     */
    public function wxpay_notify_operation(array $params):bool{
        $result = (new WxPayTool())->notify_verify();
        Log::debug("微信支付：" . json_encode($result));
        $res = $this->notify_execute($result['resource']['ciphertext']['out_trade_no']);
        return $res;
    }

    /**
     * 支付回调后，逻辑执行
     *
     * @param string $out_trade_no 流水编号，数据的唯一标识，由支付方回调数据中获得
     * @return boolean
     */
    protected function notify_execute(string $out_trade_no):bool{
        // 获取支付记录
        $pay_log = (new LogUsersPay())->get_data_by_no($out_trade_no);
        if(!$pay_log || $pay_log->status != 0){
            return true;
        }
        // 根据记录类型做支付成功后的逻辑处理
        DB::beginTransaction();
        try{
            // 将支付记录修改为已处理(已回调)
            (new LogUsersPay())->update_status_by_no($out_trade_no, 1);
            switch($pay_log->pay_type){
                case "测试":
                    $this->测试($pay_log->relevance);
                    break;
                default:
                    break;
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            throwBusinessException($e->getMessage());
        }
        return true;
    }

    // 方便测试时直接处理支付后的操作
    public function 测试($id){
        //TODO::这里是支付后对应的操作
    }
}