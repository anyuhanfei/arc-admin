<?php
namespace App\Api\Services;

use App\Repositories\Feedback\Feedbacks;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Repositories\Users\Users;
use App\Repositories\Sys\SysMessageLogs;
use App\Repositories\Users\UserBalanceLogs;
use App\Repositories\Sys\SysSettings;
use App\Repositories\Users\UserDetails;
use App\Repositories\Users\UserBalances;
use App\Repositories\Users\UserWithdrawLogs;

class UserService{
    protected $user_id;

    public function __construct(int $user_id = 0){
        $this->user_id = $user_id;
    }


    /**
     * 通过token获取到会员id
     *
     * @param string $token token
     * @return int
     */
    public function use_token_get_id(string $token):int{
        return (new Users())->use_token_get_id($token);
    }

    /**
     * 退出登录
     *
     * @param string $token
     * @return void
     */
    public function logout_operation(string $token){
        (new Users())->delete_token($this->user_id, $token);
    }

    /**
     * 获取会员详情
     *
     * @return array
     */
    public function get_user_detail():array{
        $data = (new Users())->get_data_by_id($this->user_id);
        (new Users())->verify_status_by_user($data);
        return [
            'id'=> $data->id,
            'phone'=> $data->phone,
            'avatar'=> $data->avatar,
            'nickname'=> $data->nickname,
            'sex'=> $data->details->sex,
            'birthday'=> $data->details->birthday,
            'balances'=> [
                'money'=> $data->balances->money,
                'integral'=> $data->balances->integral,
            ]
        ];
    }

    /**
     * 修改会员数据, 会员信息包含会员表和详情表
     *  逻辑上，会员的数据只能存放在 user 表和 user_detail 表中，如果有存放在其他表中的数据无法使用此方法修改
     *  注:密码不能在此修改
     *
     * @param array $params
     * @return bool
     */
    public function update_datas_operation(array $params = []):bool{
        $user_data = (new Users())->get_data_by_id($this->user_id)->toArray();
        DB::beginTransaction();
        try{
            $update_user_data = [];
            $update_detail_data = [];
            foreach($params as $key=> $value){
                if($value == '' || $value == null || $value == false){
                    continue;
                }
                // 不是会员主表的数据就是会员详情数据
                if(array_key_exists($key, $user_data)){
                    $update_user_data[$key] = $value;
                }else{
                    $update_detail_data[$key] = $value;
                }
            }
            if(count($update_user_data) >= 1){
                (new Users())->update_datas_by_user($this->user_id, $update_user_data);
            }
            if(count($update_detail_data) >= 1){
                (new UserDetails())->update_datas_by_user($this->user_id, $update_detail_data);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throwBusinessException($e->getMessage());
        }
        return true;
    }

    /**
     * 获取微信小程序绑定的手机号并保存手机号
     *
     * @param string $iv
     * @param string $encryptedData
     * @return void
     */
    public function bind_wxmini_phone_operation(string $iv, string $encryptedData){
        // 通过微信小程序的参数获取手机号
        $user_data = (new Users())->get_data_by_id($this->user_id);
        $phone = (new \App\Tools\Wx\WxminiLoginTool())->get_wx_phone($user_data->wxmini_openid, $iv, $encryptedData);
        // 执行绑定手机号/合并账号操作
        return $this->_bind_phone_operation($phone, 'wxmini_openid');
    }

    /**
     * 微信公众号/H5授权时，绑定输入的手机号
     *
     * @param string $phone
     * @return void
     */
    public function bind_wx_phone_operation(string $phone){
        // 执行绑定手机号/合并账号操作
        return $this->_bind_phone_operation($phone, 'wx_openid');
    }

    /**
     * 微信小程序绑定输入的手机号
     *
     * @param string $phone
     * @return void
     */
    public function bind_wxapp_phone_operation(string $phone){
        // 执行绑定手机号/合并账号操作
        return $this->_bind_phone_operation($phone, 'wxapp_openid');
    }

    /**
     * 绑定手机号/合并账号操作
     *
     * @param string $phone
     * @param string $openid_field_name
     * @return void
     */
    private function _bind_phone_operation(string $phone, string $openid_field_name){
        $user_data = (new Users())->get_data_by_id($this->user_id);
        if($user_data->phone != ''){
            throwBusinessException('您已经绑定过手机号，无需再次绑定');
        }
        $verify_user_data = (new Users())->get_data_by_phone($phone);
        if($verify_user_data){
            // 当前手机号已经存在账号，那么进行合并操作
            if($verify_user_data->$openid_field_name != ''){
                throwBusinessException('当前手机号已经绑定过微信账号，无法再次绑定');
            }
            (new Users())->update_datas_by_user($verify_user_data->id, [
                $openid_field_name=> $user_data->$openid_field_name,
            ]);
            $user_data->delete();
            $user_data = $verify_user_data;
        }else{
            // 当前手机号不存在账号，那么进行绑定操作
            $this->update_datas_operation(['phone' => $phone]);
        }
        $user_data = (new Users())->get_data_by_id($user_data->id);
        return (new UserLoginService((new Users())))->_user_login_data($user_data);
    }


    /**
     * 获取会员资金流水记录
     *
     * @param integer $page
     * @param integer $limit
     * @param array $search
     * @return void
     */
    public function get_user_balances_log_list(int $page, int $limit, array $search):array{
        $_search = [];
        foreach($search as $key=> $value){
            if(!in_array($value, ['', '0', 'undefined', null])){
                $_search[$key] = $value;
            }
        }
        $datas = (new UserBalanceLogs())->get_list_by_user($this->user_id, $page, $limit, $_search);
        $datas = format_paginated_datas($datas, ["id", "coin_type", "fund_type", "amount", "before_money", "after_money", "relevance", "remark", "created_at"]);

        return $datas;
    }

    /**
     * 获取会员的消息列表
     *
     * @param integer $page
     * @param integer $limit
     * @return void
     */
    public function get_sys_messages_list(int $page, int $limit){
        $log_sys_message_repository = new SysMessageLogs();
        $datas = $log_sys_message_repository->get_list_by_user($this->user_id, $page, $limit);

        foreach($datas as &$message){
            $message->read_status = $log_sys_message_repository->get_read_status_by_id($this->user_id, $message->id);
            unset($message->updated_at, $message->deleted_at, $message->user_ids);
        }
        $datas = format_paginated_datas($datas, ['id', 'title', 'image', 'content', 'created_at', 'read_status']);
        return $datas;
    }

    /**
     * 获取会员的系统消息详情
     *
     * @param integer $message_id
     * @return Model
     */
    public function get_sys_message_detail(int $message_id):Model{
        $message = (new SysMessageLogs())->get_data_by_id($this->user_id, $message_id);
        if(!$message){
            throwBusinessException("消息不存在");
        }
        (new SysMessageLogs())->get_read_status_by_id($this->user_id, $message->id);
        unset($message->updated_at, $message->deleted_at, $message->user_ids);
        return $message;
    }

    /**
     * 会员提现申请操作
     *
     * @param integer|float $amount
     * @param string $account_type
     * @param string $coin_type
     * @param array $accounts
     * @param string $remark
     * @return bool
     */
    public function user_withdraw_operation(int|float $amount, string $account_type, string $coin_type, array $accounts, string $remark = ''):bool{
        $user_data = (new Users())->get_data_by_id($this->user_id);
        (new Users())->verify_status_by_user($user_data);
        switch($account_type){
            case "微信":  // 情况分支：openid、绑定数据、传参 (正式项目需要将除业务逻辑外的分支判断代码都删除/注释)
                // 系统自动转账：微信直接获取openid即可。（如果不是自动转账，则需要将此判断删除）
                // if($user_data->openid == ''){
                //     throwBusinessException("请先绑定微信", NO_BIND_WX);
                // }
                // 手动转账、提前绑定微信账号信息：需要获取微信账号、实名信息（如果不是提前绑定，则需要将此判断删除）
                // if($user_data->detail->wx_account == '' || $user_data->detail->wx_username == ''){
                //     throwBusinessException("请先绑定微信", NO_BIND_WX);
                // }
                // $accounts['wx_account'] = $user_data->detail->wx_account;
                // $accounts['wx_username'] = $user_data->detail->wx_username;
                // 手动转账、提现时提交微信账号信息：需要获取传参的微信账号、实名信息
                if($accounts['wx_account'] == '' || $accounts['wx_username'] == ''){
                    throwBusinessException("请填写微信账号信息");
                }
                break;
            case "支付宝":   // 情况分支：绑定数据、传参 (正式项目需要将除业务逻辑外的分支判断代码都删除/注释)
                // 手动转账、提前绑定支付宝账号信息：需要获取支付宝账号、实名信息（如果不是提前绑定，则需要将此判断删除）
                if($user_data->details->alipay_account == '' || $user_data->details->alipay_username == ''){
                    throwBusinessException("请先绑定支付宝", NO_BIND_WX);
                }
                $accounts['alipay_account'] = $user_data->detail->alipay_account;
                $accounts['alipay_username'] = $user_data->detail->alipay_username;
                // 手动转账、提现时提交支付宝账号信息：需要获取传参的支付宝账号、实名信息
                if($accounts['alipay_account'] == '' || $accounts['alipay_username'] == ''){
                    throwBusinessException("请填写支付宝账号信息");
                }
                break;
            case "银行卡":  // 无情况分支（银行卡绑定一般会绑定多个，所以这里可以规定无论是绑定还是填写都需要传参）
                if($accounts['bank_card_account'] == '' || $accounts['bank_card_username'] == '' || $accounts['bank_card_bank'] == '' || $accounts['bank_card_sub_bank'] == ''){
                    throwBusinessException("请填写银行卡信息");
                }
                break;
        }
        $withdraw_fee_rate_set = floatval((new SysSettings())->get_data_by_key("withdraw_fee_rate")) ?? 0;
        $fee = $amount * $withdraw_fee_rate_set * 0.01;
        DB::beginTransaction();
        try{
            $withdraw_log = (new UserWithdrawLogs())->create_data($this->user_id, $amount, $fee, $coin_type, $accounts, '资金提现', $remark);
            $money = (new UserBalances())->update_fund($this->user_id, $coin_type, $amount * -1, "提现申请", $withdraw_log->id, '');
            if($money < 0){
                throwBusinessException("提现失败, 当前余额不足");
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throwBusinessException($e->getMessage());
        }
        return true;
    }

    /**
     * 会员提现列表
     *
     * @param integer $page
     * @param integer $limit
     * @return Collection
     */
    public function get_withdraws_list(int $page, int $limit):array{
        $datas = (new UserWithdrawLogs())->get_list_by_user($this->user_id, $page, $limit);
        $datas = format_paginated_datas($datas, ["id", "amount", "fee", "content", "remark", "status", "created_at"]);
        return $datas;
    }

    /**
     * 提交意见反馈信息
     *
     * @param string $type
     * @param string $content
     * @param string $contact
     * @param array $images
     * @return void
     */
    public function apply_feedback_operation(string $type, string $content, string $contact, array $images){
        $data = (new Feedbacks())->create_data($this->user_id, $type, $content, $contact, $images);
        return $data;
    }
}