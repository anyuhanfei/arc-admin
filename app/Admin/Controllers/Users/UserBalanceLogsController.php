<?php

namespace App\Admin\Controllers\Users;

use App\Enums\Users\CoinEnum;
use App\Repositories\Users\UserBalanceLogs;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

/**
 * 会员资金管理模块控制器
 */
class UserBalanceLogsController extends AdminController{

    protected function grid(){
        return Grid::make(new UserBalanceLogs(['user']), function (Grid $grid){
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            $grid->column("user", '会员信息')->display(function($value){
                return admin_grid_user_field($value);
            });
            $grid->column('fund_type');
            $grid->column('coin_type')->display(function($value){
                return CoinEnum::getDescription($value) ?? "";
            });
            $grid->column('amount')->display(function($value){
                return "<span class='label' style='background:#586cb1;padding-bottom: 2px;'>{$value}</span><br/><span>操作前金额: {$this->before_money}</span><br/><span>操作后金额: {$this->after_money}</span>";
            });
            $grid->column('created_at');
            $grid->filter(function (Grid\Filter $filter){
                $filter->equal('id');
                $filter->equal('user_id');
                $filter->equal('user.account', '会员账号');
                $filter->equal('user.phone', '会员手机号');
                $fund_type_array = UserBalanceLogs::fund_type_array();
                $filter->equal('fund_type')->select(array_combine($fund_type_array, $fund_type_array));
                $filter->between('created_at')->datetime();
            });
            $grid->selector(function (Grid\Tools\Selector $selector){
                $selector->select("coin_type", "币种", CoinEnum::getDescriptions());
            });
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->disableRowSelector();
        });
    }

    protected function detail($id){
        return Show::make($id, new UserBalanceLogs(['user']), function (Show $show){
            $show->field('id');
            $show->field('user_id');
            $show->field('user.account', '会员账号');
            $show->field('coin_type')->as(function($value){
                return CoinEnum::getDescription($value) ?? "";
            });
            $show->field('fund_type');
            $show->field('amount');
            $show->field('before_money');
            $show->field('after_money');
            $show->field('relevance');
            $show->field('reamrk');
            $show->field('created_at');
            $show->field('updated_at');
            $show->disableDeleteButton();
            $show->disableEditButton();
        });
    }
}
