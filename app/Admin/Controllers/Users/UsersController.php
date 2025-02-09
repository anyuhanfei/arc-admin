<?php

namespace App\Admin\Controllers\Users;

use App\Repositories\Users\Users;
use App\Repositories\Users\UserBalances;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;

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
        $fund_types = UserBalances::fund_type_array();
        return Grid::make(new Users(['parentUser']), function (Grid $grid) use($fund_types){
            $grid->showColumnSelector();
            $grid->model()->orderby("id", 'desc');
            $grid->column('id')->sortable();
            $grid->column('avatar')->image("", 60, 60);
            $grid->column('nickname');
            $grid->column('account');
            $grid->column('phone');
            $grid->column('email');
            $grid->column('fund')->display(function() use($fund_types){
                $str = '';
                foreach($fund_types as $key=>$value){
                    $str .= $value . ': ' . $this->balances->$key . '<br/>';
                }
                return $str;
            });
            $grid->column('parent_user_id', '上级会员信息')->width("300px")->display(function(){
                return $this->parent_user_id == 0 ? '' : admin_show_user_data($this->parentUser);
            });
            $grid->column('login_status')->switch()->help('如果关闭则此会员无法登录');
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
                $filter->equal('login_status')->select(Users::login_status_array());
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
            foreach($fund_types as $key=>$value){
                $titles[$key] = $value;
            }
            $grid->export()->titles($titles)->rows(function($rows) use($fund_types){
                foreach($rows as $index=> &$row){
                    $row['parentUser.phone'] = $row['parentUser'] == null ? '' : $row['parentUser']['phone'];
                    foreach($fund_types as $key=>$value){
                        $row[$key] = $row->balances->$key;
                    }
                    $row['login_status'] = $row->login_status == 1 ? '正常' : '冻结';
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
            $fund_types = UserBalances::fund_type_array();
            foreach($fund_types as $key=>$value){
                $show->field('balances.'.$key, $value);
            }
            $show->divider();
            // TODO::项目中需要什么详情信息需要手动添加
            $show->field('details.sex', '性别');
            $show->field('details.birthday', '出生日期');
            $show->divider();
            $show->field('login_status')->as(function($value){
                return $value == 1 ? '正常' : '冻结';
            });
            $show->field('created_at');
        });
    }

    protected function form(){
        return Form::make(new Users(["balances", "details"]), function (Form $form) {
            $form->hidden('login_status');
            if($form->isCreating()){  // 添加
                admin_image_field($form->image('avatar')->required());
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
                    $form->password = (new Users())->set_user_password($form->password ?? '');
                    $form->avatar = $form->avatar ?? '';
                    $form->nickname = $form->nickname ?? '';
                    $form->account = $form->account ?? '';
                    $form->phone = $form->phone ?? '';
                    $form->email = $form->email ?? '';
                    $form->parent_user_id = $form->parent_user_id ?? 0;
                    $form->login_status = 1;
                });
                // 同步创建资产表与详情表
                $form->saved(function (Form $form, $result) {
                    (new \App\Repositories\Users\UserBalances())->create_data($result);
                    (new \App\Repositories\Users\UserDetails())->create_data($result);
                });
            }else{  // 修改
                $form->tab('基本信息', function(Form $form){
                    $form->display('id');
                    $this->admin_image_compress(admin_image_field($form->image('avatar')->required()));
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
                });
                // 资产管理
                $form->tab('资产', function(Form $form){
                    $fund_types = UserBalances::fund_type_array();
                    foreach($fund_types as $key=>$value){
                        $form->number('balances.'.$key, $value);
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
                    $form->avatar = $form->avatar ?? $form->model()->avatar;
                    $form->nickname = $form->nickname ?? $form->model()->nickname;
                    $form->account = $form->account ?? $form->model()->account;
                    $form->phone = $form->phone ?? $form->model()->phone;
                    $form->email = $form->email ?? $form->model()->email;
                    $form->parent_user_id = $form->parent_user_id ?? $form->model()->parent_user_id;
                    $form->login_status = $form->login_status ?? $form->model()->login_status;
                    //判断是否填写了密码，并加密
                    if($form->password == null){
                        $form->deleteInput('password');
                    }else{
                        $form->password = (new Users())->set_user_password($form->password ?? '');
                    }
                    $fund_types = UserBalances::fund_type_array();
                    foreach($fund_types as $key=>$value){
                        if($form->model()->balances->$key != $form->balances[$key]){
                            (new UserBalances())->update_fund($form->model()->id, $key, $form->balances[$key] - $form->model()->balances->$key, '管理员更新', '', '管理员更新');
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


    protected function admin_image_compress($image_obj){
        return $image_obj->compress([
            'width' => 180,
            'height' => 180,
            'quality' => 70,
            'crop' => false,
            'noCompressIfLarger' => true,
        ]);
    }
}