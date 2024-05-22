<?php

namespace App\Admin\Controllers\Users;

use App\Repositories\Users\Users;
use App\Repositories\Users\UsersFund;
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
        $fund_types = UsersFund::fund_type_array();
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
                    $str .= $value . ': ' . $this->funds->$key . '<br/>';
                }
                return $str;
            });
            $grid->column('parent_user_id', '上级会员信息')->width("300px")->display(function(){
                return $this->parent_user_id == 0 ? '' : admin_show_user_data($this->parentUser);;
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
        });
    }

    protected function detail($id){
        return Show::make($id, new Users(), function (Show $show) {
            $show->field('id');
            $show->field('avatar');
            $show->field('nickname');
            $show->field('account');
            $show->field('phone');
            $show->field('email');
            $show->field('password');
            $show->field('parent_user_id');
            $show->field('login_status');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form(){
        return Form::make(new Users(["funds", "detail"]), function (Form $form) {
            $form->hidden('login_status');
            if($form->isCreating()){  // 添加
                admin_image_field($form->image('image')->required());
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
                    (new \App\Repositories\Users\UsersFund())->create_data($result);
                    (new \App\Repositories\Users\UsersDetail())->create_data($result);
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
                    $form->number('funds.money', '余额');
                    $form->number('funds.integral', '积分');
                });
                // 详情信息
                $form->tab('详细信息', function(Form $form){
                    
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
                });
            }
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
        });
    }

    public function get_users(Request $request){
        $account = $request->get('q');
        return (new Users())->admin_get_users($account);
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