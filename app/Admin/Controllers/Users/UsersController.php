<?php

namespace App\Admin\Controllers\Users;

use App\Enums\StatusEnum;
use App\Enums\Users\CoinEnum;
use App\Enums\Users\LoginStatusEnum;
use App\Repositories\Users\Users;
use App\Repositories\Users\UserBalances;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 会员管理模块控制器
 */
class UsersController extends AdminController{
    // 会员是否可后台添加、删除
    protected bool $create_operation = true;
    protected bool $delete_operation = true;
    // 上级id字段是否启用
    protected bool $field_parent_enable = true;

    protected function grid(){
        return Grid::make(new Users(['parentUser', 'balances']), function (Grid $grid){
            $grid->showColumnSelector();
            $grid->model()->orderby("id", 'desc');
            $grid->column('id')->sortable();
            $grid->column('avatar')->image("", 60, 60);
            $grid->column('nickname');
            $grid->column('account');
            $grid->column('phone');
            $grid->column('email');
            $grid->column('fund')->display(function(){
                $str = '';
                foreach(CoinEnum::getDescriptions() as $key=>$value){
                    $str .= $value . ': ' . $this->balances->$key . '<br/>';
                }
                return $str;
            });
            $grid->column('parent_user_id', '上级会员信息')->width("300px")->display(function(){
                return $this->parent_user_id == 0 ? '' : admin_grid_user_field($this->parentUser);
            });
            $grid->column('login_status')->select(LoginStatusEnum::getDescriptions())->help('如果关闭则此会员无法登录');
            $grid->column('created_at');
            $field_parent_enable = $this->field_parent_enable;
            $grid->filter(function (Grid\Filter $filter) use($field_parent_enable){
                $filter->equal('id');
                $filter->like('nickname');
                $filter->like('account');
                $filter->like('phone');
                $filter->like('email');
                if($field_parent_enable){
                    $filter->like('parent_user_id');
                    $filter->like('parentUser.account', '上级会员账号');
                }
                $filter->equal('login_status')->select(LoginStatusEnum::getDescriptions());
            });
            // 添加、删除按钮
            if($this->create_operation == false){
                $grid->disableCreateButton();
            }
            if($this->delete_operation == false){
                $grid->disableDeleteButton();
            }
            // 导出
            $titles = [
                'id'=> "ID", 'nickname'=> "昵称", 'account'=> "账号", 'phone'=> "手机号", 'email'=> "邮箱", 'parent_user_id'=> "上级会员ID", 'parentUser.phone'=> "上级手机号", 'login_status'=> "登录权限", 'created_at'=> "创建时间"
            ];
            foreach(CoinEnum::getDescriptions() as $key=>$value){
                $titles[$key] = $value;
            }
            $grid->export()->titles($titles)->rows(function($rows){
                foreach($rows as $index=> &$row){
                    $row['parentUser.phone'] = $row['parentUser'] == null ? '' : $row['parentUser']['phone'];
                    foreach(CoinEnum::getDescriptions() as $key=>$value){
                        $row[$key] = $row->balances->$key;
                    }
                    $row['login_status'] = LoginStatusEnum::getDescription($row->login_status);
                }
                return $rows;
            });
        });
    }

    protected function detail($id){
        return Show::make($id, new Users(['details', 'balances', 'parentUser']), function (Show $show) {
            $show->field('id');
            $show->field('avatar')->image("", 60, 60);
            $show->field('nickname');
            $show->field('account');
            $show->field('phone');
            $show->field('email');
            $show->divider();
            $show->field('parent_user_id');
            $show->field('parentUser.phone', '上级手机号');
            $show->divider();
            foreach(CoinEnum::getDescriptions() as $key=>$value){
                $show->field('balances.'.$key, $value);
            }
            $show->divider();
            // TODO::项目中需要什么详情信息需要手动添加
            $show->field('details.sex', '性别');
            $show->field('details.birthday', '出生日期');
            $show->divider();
            $show->field('login_status')->using(LoginStatusEnum::getDescriptions());
            $show->field('created_at');
        });
    }

    protected function form(){
        return Form::make(new Users(["balances", "details"]), function (Form $form) {
            $form->hidden('login_status');
            if($form->isCreating()){  // 添加
                admin_form_media_selector_field($form->mediaSelector('avatar')->required(), 1, ['image']);
                $form->text('nickname')->required();
                $form->text('account')->required();
                $form->text('phone')->required();
                $form->text('email');
                $form->text('password')->required();
                if($this->field_parent_enable){
                    $form->select('parent_user_id', '选择上级')->options("get/users");
                }
                // 密码加密、数据添加默认值
                $form->saving(function (Form $form) {
                    DB::beginTransaction();
                    $form->password = (new Users())->set_user_password($form->password ?? '');
                    $form->avatar = $form->avatar ?? 'avatar.jpeg';
                    $form->nickname = $form->nickname ?? '';
                    $form->account = $form->account ?? '';
                    $form->phone = $form->phone ?? '';
                    $form->email = $form->email ?? '';
                    $form->parent_user_id = $form->parent_user_id ?? 0;
                    $form->login_status = LoginStatusEnum::NORMAL;
                });
                // 同步创建资产表与详情表
                $form->saved(function (Form $form, $result) {
                    (new \App\Repositories\Users\UserBalances())->create_data($result);
                    (new \App\Repositories\Users\UserDetails())->create_data($result);
                    DB::commit();
                });
            }else{  // 修改
                $form->tab('基本信息', function(Form $form){
                    $form->display('id');
                    admin_form_media_selector_field($form->mediaSelector('avatar')->required(), 1, ['image']);
                    $form->text('nickname');
                    $form->text('account');
                    $form->text('phone');
                    $form->text('email');
                    if($this->field_parent_enable){
                        $form->select('parent_user_id', '选择上级')->options("get/users");
                    }
                    $form->text('password')->customFormat(function(){
                        return '';
                    })->help('不填写则不修改');
                    $form->hidden('login_status', '登录权限')->options(LoginStatusEnum::getDescriptions());
                });
                // 资产管理
                $form->tab('资产', function(Form $form){
                    foreach(CoinEnum::getDescriptions() as $key=>$value){
                        admin_form_number_field($form->text('balances.'.$key, $value), '0.01');
                    }
                });
                // TODO::项目中需要什么详情信息需要手动添加
                $form->tab('详细信息', function(Form $form){
                    $form->radio("details.sex", "性别")->options([
                        '未知'=> "未知", '男'=> "男", '女'=> "女"
                    ])->default('0');
                    $form->date("details.birthday", "出生日期");
                });
                $form->saving(function (Form $form) {
                    if($form->avatar == null){
                        $form->deleteInput('avatar');
                    }
                    if($form->nickname == null){
                        $form->deleteInput('nickname');
                    }
                    if($form->account == null){
                        $form->deleteInput('account');
                    }
                    if($form->phone == null){
                        $form->deleteInput('phone');
                    }
                    if($form->email == null){
                        $form->deleteInput('email');
                    }
                    if($form->parent_user_id == null){
                        $form->deleteInput('parent_user_id');
                    }
                    if($form->login_status == null){
                        $form->deleteInput('login_status');
                    }
                    //判断是否填写了密码，并加密
                    if($form->password == null){
                        $form->deleteInput('password');
                    }else{
                        $form->password = (new Users())->set_user_password($form->password ?? '');
                    }
                    if($form->balances != null){
                        foreach(CoinEnum::getDescriptions() as $key=>$value){
                            if($form->model()->balances->$key != $form->balances[$key]){
                                (new UserBalances())->update_fund($form->model()->id, $key, $form->balances[$key] - $form->model()->balances->$key, '管理员更新', '', '管理员更新');
                            }
                        }
                    }
                });
            }
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
        });
    }

    public function get_users(Request $request){
        $account = $request->get('q');
        return (new Users())->admin_get_datas_by_account($account);
    }
}