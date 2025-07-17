<?php
namespace App\Api\Services;

use App\Enums\SysMessageLogs\SendTypeEnum;
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

class SysMessageService{
    protected $user_id;
    protected $user;

    public function __construct(int $user_id = 0){
        $this->user_id = $user_id;
        $this->user = (new Users())->get_data_by_id($user_id);
        (new Users())->verify_status_by_user($this->user);
    }

    public function get_sys_message_count():array{
        // 循环所有的消息类型，获取未读消息数量、最后一条消息的内容(标题)、时间
        $datas = [];
        foreach(SendTypeEnum::getDescriptions() as $key=> $value){
            $unread_number = (new SysMessageLogs())->get_unread_count_by_user($this->user_id, $key);
            $last_message = (new SysMessageLogs())->get_last_data_by_user_type($this->user_id, $key);
            $datas[$key] = [
                // TODO::真实项目中，根据需求返回标题、内容、图片等
                'unread_number'=> $unread_number,
                'last_message_title'=> $last_message ? $last_message->title : '',
                'last_message_image'=> $last_message ? full_url($last_message->image) : '',
                'last_message_content'=> $last_message ? $last_message->content : '',
                'last_message_time'=> $last_message ? $last_message->created_at->format("Y-m-d H:i:s") : '',
            ];
        }
        return $datas;
    }

    /**
     * 获取会员的消息列表
     *
     * @param integer $limit
     * @param string $type
     * @return void
     */
    public function get_sys_messages_list(int $limit, string $type){
        $log_sys_message_repository = new SysMessageLogs();
        $datas = $log_sys_message_repository->get_list_by_user_type($this->user_id, $type, $limit);
        return format_paginated_datas($datas, ['id', 'title', 'image', 'content', 'created_at', 'read_status'], function($item) use($log_sys_message_repository, $type){
            $item->read_status = $log_sys_message_repository->get_data_read_status_by_user($this->user_id, $item->id, $type);
            $item->image = full_url($item->image);
        });
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
        $message->image = full_url($message->image);
        (new SysMessageLogs())->set_data_as_read($this->user_id, $message->id, $message->send_type);
        $message->setVisible(['id', 'title', 'image', 'content', 'created_at']);
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