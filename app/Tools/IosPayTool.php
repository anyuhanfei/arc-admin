<?php
namespace App\Tools;

class IosPayTool{
    private $itunes = 'https://buy.itunes.apple.com/verifyReceipt';  //正式
    private $sandbox = 'https://sandbox.itunes.apple.com/verifyReceipt';  //沙箱

    # ios商品号=> 价格
    private $price_array = [
        '20221'=> 6,
        '20222'=> 30,
        '20223'=> 68,
        '20224'=> 98,
        '20225'=> 198,
        '20226'=> 298,
    ];

    private $err_msg = array(
        '21000' => 'App Store不能读取你提供的JSON对象',
        '21002' => 'receipt-data域的数据有问题1',
        '21003' => 'receipt无法通过验证',
        '21004' => '提供的shared secret不匹配你账号中的shared secret',
        '21005' => 'receipt服务器当前不可用',
        '21006' => 'receipt合法, 但是订阅已过期。服务器接收到这个状态码时, receipt数据仍然会解码并一起发送',
        '21007' => 'receipt是Sandbox receipt, 但却发送至生产系统的验证服务',
        '21008' => 'receipt是生产receipt, 但却发送至Sandbox环境的验证服务',
        '21199' => '21199'
    );

    public function pay($receipt_data){
        $data = '{"receipt-data":"'.$receipt_data.'"}';
        $res = json_decode($this->https_request($this->itunes, $data), true);
        // 0或 21007表示请求成功了
        if(intval($res['status']) === 0 || intval($res['status']) == 21007){
            $apple_order = $res['receipt']['in_app'][0];
            // 判断支付状态,成功则执行支付后代码
            $is_pay = false;
            if(intval($res['status']) === 0 && $apple_order['in_app_ownership_type'] == 'PURCHASED'){
                $is_pay = true;
            }
            if(intval($res['status']) == 21007){
                $is_pay = true;
            }
            if($is_pay){
                // TODO：此时支付验证已通过，做业务逻辑
            }else{
                throwBusinessException('充值失败!');
            }
        }else{
            throwBusinessException($this->err_msg[$res['status']]);
        }
        return true;
    }


    function https_request($url, $data=null){
        //初始化curl
        $curl = curl_init();
        //curlopt_url
        curl_setopt($curl,CURLOPT_URL,$url);
        //curlopt_ssl_verifypeer禁止 CURL 验证对等证书
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
        //curlopt_ssl_verifyhost禁止验证host
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
        //验证$data
        if(!empty($data)){
            //curlopt_post
            curl_setopt($curl,CURLOPT_POST,1);
            //curl_postfieleds
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        }
        //curlopt_returntransfer
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        //Content-Type: application/json 修改
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data)
        ));
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}