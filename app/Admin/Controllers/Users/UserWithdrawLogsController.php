<?php

namespace App\Admin\Controllers\Users;

use App\Enums\Users\CoinEnum;
use App\Enums\UserWithdrawLogs\StatusEnum;
use App\Repositories\Sys\SysMessageLogs;
use App\Repositories\Users\UserWithdrawLogs;
use App\Repositories\Users\UserBalances;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;

/**
 * 会员提现记录控制器
 */
class UserWithdrawLogsController extends AdminController{
    protected function grid(){
        return Grid::make(new UserWithdrawLogs(['user']), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            $grid->column("user", '会员信息')->width("270px")->display(function(){
                return admin_grid_user_field($this->user);
            });
            $grid->column('coin_type')->using(CoinEnum::getDescriptions());
            $grid->column('amount')->display(function(){
                return '提现金额: ¥' . $this->amount . "<br/>手续费: ¥" . $this->fee . "<br/>应发金额: <span  class='label' style='background:#586cb1'>¥ " . ($this->amount - $this->fee) . '</span>';
            });
            $grid->column('data', "账户信息")->display(function(){
                if($this->wx_openid != ''){
                    return "微信授权账号";
                }
                if($this->wx_account != ''){
                    return "微信账号：{$this->wx_account}<br/>微信实名：{$this->wx_username}";
                }
                if($this->alipay_account != ''){
                    return "支付宝账号：{$this->alipay_account}<br/>支付宝实名：{$this->alipay_username}";
                }
                if($this->bank_card_code != ''){
                    return "银行卡账号：{$this->bank_card_code}<br/>银行卡姓名：{$this->bank_card_username}<br/>银行卡开户行：{$this->bank_card_bank}<br/>银行卡支行：{$this->bank_card_sub_bank}";
                }
            });
            $grid->column('content');
            $grid->column('remark');
            $grid->column('status')->using(StatusEnum::getDescriptions())->dot(StatusEnum::getColors());
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('user_id');
                $filter->like('user.account', '会员账号');
                $filter->like('user.nickname', '会员昵称');
                $filter->like('user.phone', '会员手机号');
            });
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select("coin_type", "币种", CoinEnum::getDescriptions());
                $selector->select("status", "状态", StatusEnum::getDescriptions());
            });
            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableViewButton();
        });
    }

    protected function form(){
        return Form::make(new UserWithdrawLogs(), function (Form $form) {
            $form->display('id');
            $form->display('user_id');
            // $form->display('amount');
            // $form->display('fee');
            $form->display('remit_amount', '打款金额')->value($form->model()->amount - $form->model()->fee);
            $form->display('content');
            $form->display('remark');
            $form->display('created_at');
            if($form->model()->wx_openid != ''){
                $form->html("将自动提现到授权微信");
            }
            if($form->model()->wx_account != ''){
                $form->display("wx_account", '微信账号');
                $form->display("wx_username", '微信实名');
            }
            if($form->model()->alipay_account != ''){
                $form->display("alipay_account", '支付宝账号');
                $form->display("alipay_username", '支付宝实名');
            }
            if($form->model()->bank_card_code != ''){
                $form->display("bank_card_code", '银行卡号');
                $form->display("bank_card_username", '银行卡实名');
                $form->display("bank_card_bank", '银行卡开户行');
                $form->display("bank_card_sub_bank", "银行卡支行");
            }
            if($form->model()->status == 0){
                $form->radio('status')->options(['1' => '通过', '3' => '驳回'])->when('1', function(Form $form){
                    // 如果是自动转账，请注释\删除
                    $form->radio('remit_status', '打款状态')->options(['2' => '已打款'])->help("如果现实中已打款，请勾选");
                })->when("3", function(Form $form){
                    // 输入驳回原因
                    $form->text('reject_cause', '驳回原因')->required();
                })->required();
            }
            // 如果是自动转账，请注释\删除
            if($form->model()->status == 1){
                $form->radio('status', '打款状态')->options(['2' => '已打款'])->required()->help("请在打款后勾选此项");
            }
            $form->saving(function (Form $form) {
                // 是否是自动转账状态
                $is_auto = false;
                if($form->status == 1){  // 通过的处理操作
                    // TODO::自动转账操作（手动打款无需编写额外代码）
                    if($is_auto){
                        $form->status = 2;
                    }
                }elseif($form->status == 3){  // 驳回的处理操作, 退回金额，发送驳回消息
                    DB::beginTransaction();
                    try{
                        (new UserBalances())->update_fund($form->model()->user_id, $form->model()->coin_type, $form->model()->amount, '提现申请驳回', $form->model()->id);
                        (new SysMessageLogs())->send_message($form->model()->user_id, "您的提现申请已被驳回", "提现申请被驳回，原因：{$form->reject_cause}，请重新提交申请。", '', "withdraw:{$form->model()->id}");
                        DB::commit();
                    }catch(\Exception $e){
                        DB::rollBack();
                        return $form->response()->error($e->getMessage());
                    }
                }
                // 如果手动勾选了自动打款
                if($form->remit_status == 2){
                    $form->status = 2;
                }
                $form->deleteInput('remit_status');
                $form->deleteInput('reject_cause');
            });
            $form->disableDeleteButton();
            $form->disableCreatingCheck();
            $form->disableEditingCheck();
            $form->disableViewButton();
            $form->disableViewCheck();
        });
    }
}
