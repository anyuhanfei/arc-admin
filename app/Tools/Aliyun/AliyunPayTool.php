<?php
namespace App\Tools\Aliyun;

use Alipay\EasySDK\Kernel\Factory;
use Alipay\EasySDK\Kernel\Util\ResponseChecker;
use Alipay\EasySDK\Kernel\Config as AliConfig;

# 阿里云支付工具类
# composer require alipaysdk/easysdk
class AliyunPayTool{
    protected $config;

    public function __construct(){
        $this->config = [
            // 必填-支付宝分配的 app_id
            'app_id' => config('pay.alipay.default.app_id'),
            // 必填-应用私钥 字符串或路径
            'app_secret_cert' => config('pay.alipay.default.app_secret_cert'),
            // 必填-应用公钥证书 路径
            'app_public_cert_path' => config('pay.alipay.default.app_public_cert_path'),
            // 必填-支付宝公钥证书 路径
            'alipay_public_cert_path' => config('pay.alipay.default.alipay_public_cert_path'),
            // 必填-支付宝根证书 路径
            'alipay_root_cert_path' => config('pay.alipay.default.alipay_root_cert_path'),
            'return_url' => config('pay.alipay.default.return_url'),
            'notify_url' => config('pay.alipay.default.notify_url'),
        ];
        $options = new AliConfig();
        $options->protocol = 'https';
        $options->gatewayHost = 'openapi.alipay.com';
        $options->signType = 'RSA2';
        $options->appId = $this->config['app_id'];
        // 为避免私钥随源码泄露，推荐从文件中读取私钥字符串而不是写入源码中
        $options->merchantPrivateKey = $this->config['app_secret_cert'];
        $options->alipayCertPath = $this->config['alipay_public_cert_path'];
        $options->alipayRootCertPath = $this->config['alipay_root_cert_path'];
        $options->merchantCertPath = $this->config['app_public_cert_path'];

        //注：如果采用非证书模式，则无需赋值上面的三个证书路径，改为赋值如下的支付宝公钥字符串即可
        // $options->alipayPublicKey = '<-- 请填写您的支付宝公钥，例如：MIIBIjANBg... -->';

        //可设置异步通知接收服务地址（可选）
        $options->notifyUrl = $this->config['notify_url'];

        //可设置AES密钥，调用AES加解密相关接口时需要（可选）
        // $options->encryptKey = "<-- 请填写您的AES密钥，例如：aa4BtZ4tspm2wnXLb1ThQA== -->";
        Factory::setOptions($options);
    }

    /**
     * APP支付
     *
     * @param string $subject  商品名
     * @param string $order_no  支付流水号
     * @param int|float $money  金额
     * @return void
     */
    public function app(string $subject, string $out_trade_no, int|float $money){
        try {
            $result = Factory::payment()->app()->pay($subject, $out_trade_no, $money);
            $responseChecker = new ResponseChecker();
            if ($responseChecker->success($result)) {
                return $result->body;
            } else {
                throwBusinessException("调用失败，原因：". $result->msg."，".$result->subMsg.PHP_EOL);
            }
        } catch (\Exception $e) {
            throwBusinessException("调用失败，". $e->getMessage(). PHP_EOL);
        }
    }

    /**
     * h5网页支付
     *
     * @param string $subject
     * @param string $out_trade_no
     * @param integer|float $money
     * @return void
     */
    public function wap(string $subject, string $out_trade_no, int|float $money){
        try {
            $result = Factory::payment()->wap()->pay($subject, $out_trade_no, $money, config("app.url"), config("app.url"));
            $responseChecker = new ResponseChecker();
            if ($responseChecker->success($result)) {
                return $result->body;
            } else {
                throwBusinessException("调用失败，原因：". $result->msg."，".$result->subMsg.PHP_EOL);
            }
        } catch (\Exception $e) {
            throwBusinessException("调用失败，". $e->getMessage(). PHP_EOL);
        }
    }

    /**
     * 调用退款接口
     *
     * @param string  $out_trade_no  支付流水号
     * @param inf|float $money  金额
     * @return void
     */
    public function refund(string $out_trade_no, int|float $money){
        try {
            $result = Factory::payment()->common()->refund($out_trade_no, $money);
            $responseChecker = new ResponseChecker();
            if ($responseChecker->success($result)) {
                return true;
            } else {
                throwBusinessException("调用失败，原因：". $result->msg."，".$result->subMsg.PHP_EOL);
            }
        } catch (\Exception $e) {
            throwBusinessException("调用失败，". $e->getMessage(). PHP_EOL);
        }
    }

    /**
     * 转账
     *
     * @param string $alipay_account  支付宝账号
     * @param string $alipay_username  支付宝实名
     * @param integer|float $money  金额
     * @param string $title  转账说明
     * @return void
     */
    public function transfer(string $alipay_account, string $alipay_username, int|float $money, string $title){
        try {
            $bizParams = array(
                "out_biz_no" => strval(time()),
                "trans_amount" => $money,
                "product_code" => "TRANS_ACCOUNT_NO_PWD",
                "biz_scene" => "DIRECT_TRANSFER",
                "order_title" => $title,
                "payee_info"=> [
                    "identity"=> $alipay_account,
                    "identity_type"=> "ALIPAY_LOGON_ID",
                    "name"=> $alipay_username,
                ],
            );
            $result = Factory::util()->generic()->execute("alipay.fund.trans.uni.transfer", [], $bizParams);
            $responseChecker = new ResponseChecker();
            if ($responseChecker->success($result)) {
                return true;
            } else {
                throwBusinessException("调用失败，原因：". $result->msg."，".$result->subMsg.PHP_EOL);
            }
        } catch (\Exception $e) {
            throwBusinessException("调用失败，". $e->getMessage(). PHP_EOL);
        }
    }

    /**
     * 支付回调的验证判断
     *
     * @param [type] $params
     * @return void
     */
    public function notify_verify($params){
        return Factory::payment()->common()->verifyNotify($params);
    }
}