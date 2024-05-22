<?php

namespace App\Admin\Controllers\Log;

use App\Repositories\Log\LogUsersFund;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

/**
 * 会员资金管理模块控制器
 */
class LogUsersFundController extends AdminController{

    protected function grid(){
        $coin_array = LogUsersFund::coin_array();
        return Grid::make(new LogUsersFund(['user']), function (Grid $grid) use($coin_array){
            $grid->column('id')->sortable();
            $grid->column("user", '会员信息')->width("370px")->display(function(){
                return admin_show_user_data($this->user);
            });
            $grid->column('fund_type');
            $grid->column('coin_type')->display(function() use($coin_array){
                return $coin_array[$this->coin_type] ?? '未知币种';
            });
            $grid->column('amount')->display(function(){
                return "<span class='label' style='background:#586cb1;padding-bottom: 2px;'>{$this->amount}</span><br/><span>操作前金额: {$this->before_money}</span><br/><span>操作后金额: {$this->after_money}</span>";
            });
            $grid->column('created_at');
            $grid->filter(function (Grid\Filter $filter){
                $filter->equal('id');
                $filter->equal('user_id');
                $filter->equal('user.account', '会员账号');
                $filter->equal('user.phone', '会员手机号');
                $fund_type_array = LogUsersFund::fund_type_array();
                $filter->equal('fund_type')->select(array_combine($fund_type_array, $fund_type_array));
                $filter->between('created_at')->datetime();
            });
            $grid->selector(function (Grid\Tools\Selector $selector) use($coin_array){
                $selector->select("coin_type", "币种", $coin_array);
            });
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->disableRowSelector();

        });
    }

    protected function detail($id){
        $coin_array = LogUsersFund::coin_array();
        return Show::make($id, new LogUsersFund(['user']), function (Show $show) use($coin_array){
            $show->field('id');
            $show->field('user_id');
            $show->field('user.account', '会员账号');
            $show->field('coin_type')->as(function() use($coin_array){
                return $coin_array[$this->coin_type] ?? '未知币种';
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
