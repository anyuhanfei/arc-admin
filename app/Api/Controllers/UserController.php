<?php
namespace App\Api\Controllers;

use Illuminate\Http\Request;

use App\Api\Controllers\BaseController;

use App\Api\Services\UserService;

/**
 * 会员信息相关
 */
class UserController extends BaseController{
    protected $service;

    public function __construct(Request $request){
        parent::__construct($request);
        $this->service = new UserService($this->user_id);
    }

    /**
     * 获取会员信息
     *
     * @return void
     */
    public function user_detail(){
        $data = $this->service->get_user_detail();
        return success("会员信息", $data);
    }

    /**
     * 修改基本数据
     *
     * @param Request $request
     * @return void
     */
    public function update_basic_detail(Request $request){
        $params['nickname'] = $request->input("nickname", '') ?? '';
        $params['avatar'] = $request->input("avatar", '') ?? '';
        $params['sex'] = $request->input("sex", '') ?? '';
        $params['birthday'] = $request->input("birthday", '') ?? '';
        $res = $this->service->update_datas_operation($params);
        return success("修改成功");
    }

    /**
     * 绑定微信手机号
     *
     * @param Request $request
     * @return void
     */
    public function bind_wxmini_phone(Request $request){
        $iv = $request->input('iv');
        $encryptedData = $request->input('encryptedData');
        $phone = $this->service->bind_wxmini_phone_operation($iv, $encryptedData);
        return success("绑定成功", ['phone'=> $phone]);
    }

    /**
     * 获取系统消息列表
     *
     * @param \App\Api\Requests\PageRequest $request
     * @return void
     */
    public function sys_messages_list(\App\Api\Requests\PageRequest $request){
        $page = $request->input("page");
        $limit = $request->input("limit");
        $data = $this->service->get_sys_messages_list($page, $limit);
        return success("系统消息列表", $data);
    }

    /**
     * 获取系统消息详情
     *
     * @param Request $request
     * @return void
     */
    public function sys_message_detail(Request $request){
        $id = $request->input("id");
        $data = $this->service->get_sys_message_detail($id);
        return success("系统消息详情", $data);
    }

    /**
     * 获取会员资金流水记录
     *
     * @param Request $request
     * @return void
     */
    public function user_balances_log_list(Request $request){
        $page = $request->input("page");
        $limit = $request->input("limit");
        $search['coin_type'] = $request->input("coin_type", '') ?? '';
        $search['fund_type'] = $request->input("fund_type", '') ?? '';
        $data = $this->service->get_user_balances_log_list($page, $limit, $search);
        return success("会员资金列表", $data);
    }

    /**
     * 会员提现申请
     *
     * @param \App\Api\Requests\User\WithdrawRequest $request
     * @return void
     */
    public function withdraw(\App\Api\Requests\User\WithdrawRequest $request){
        $amount = $request->input('amount');
        $account_type = $request->input('account_type');
        $coin_type = $request->input('coin_type');
        $remark = $request->input('remark', '') ?? '';
        $accounts['wx_account'] = $request->input("wx_account", '') ?? '';
        $accounts['wx_username'] = $request->input("wx_username", '') ?? '';
        $accounts['alipay_account'] = $request->input("alipay_account", '') ?? '';
        $accounts['alipay_username'] = $request->input("alipay_username", '') ?? '';
        $accounts['bank_card_code'] = $request->input("bank_card_code", '') ?? '';
        $accounts['bank_card_username'] = $request->input("bank_card_username", '') ?? '';
        $accounts['bank_card_bank'] = $request->input("bank_card_bank", '') ?? '';
        $accounts['bank_card_sub_bank'] = $request->input("bank_card_sub_bank", '') ?? '';
        $res = $this->service->user_withdraw_operation($amount, $account_type, $coin_type, $accounts, $remark);
        return success("提现申请成功");
    }

    /**
     * 会员提现列表
     *
     * @param \App\Api\Requests\PageRequest $request
     * @return void
     */
    public function withdraws_list(\App\Api\Requests\PageRequest $request){
        $page = $request->input("page");
        $limit = $request->input("limit");
        $data = $this->service->get_withdraws_list($page, $limit);
        return success("提现列表", $data);
    }

    /**
     * 退出登录
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request){
        $this->service->logout_operation($this->token);
        return success("退出成功");
    }
}
