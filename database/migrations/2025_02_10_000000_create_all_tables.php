<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 创建会员表
        Schema::create('users', function (Blueprint $table) {
            $table->comment('会员表');
            $table->integer('id', true);
            $table->string('avatar')->default('')->comment('头像');
            $table->string('nickname')->default('')->comment('昵称');
            $table->string('account')->default('')->comment('账号');
            $table->string('phone')->default('')->comment('手机号');
            $table->string('email')->default('')->comment('邮箱');
            $table->string('password')->default('')->comment('密码');
            $table->integer('parent_user_id')->default(0)->comment('上级会员id');
            $table->string('unionid')->default('');
            $table->string('wxmini_openid')->default('');
            $table->string("wxapp_openid")->default('');
            $table->string("wx_openid")->default('');
            $table->string("wx_session_key")->default('');
            $table->string("wxapp_session_key")->default('');
            $table->string("wxmini_session_key")->default('');
            $table->enum('login_status', ['normal', 'frozen'])->default('normal')->comment('状态(normal=正常、frozen=冻结)');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        // 创建会员信息详情表
        Schema::create('user_details', function (Blueprint $table) {
            $table->comment('会员信息详情表');
            $table->integer('id')->primary();
            $table->enum('sex', ['未知', '男', '女'])->nullable()->default('未知')->comment('性别');
            $table->string('birthday')->nullable()->comment('生日');
        });

        // 创建会员资金表
        Schema::create('user_balances', function (Blueprint $table) {
            $table->comment('会员资金表');
            $table->integer('id')->primary();
            $table->decimal('money', 10)->default(0)->comment('余额');
            $table->decimal('integral', 10)->default(0)->comment('积分');
        });

        // 创建会员资金记录表
        Schema::create('user_balance_logs', function (Blueprint $table) {
            $table->comment('会员资金记录');
            $table->integer('id', true);
            $table->integer('user_id')->default(0)->comment('会员id');
            $table->string('coin_type')->default('')->comment('币种');
            $table->string('fund_type')->default('')->comment('记录说明');
            $table->string('relevance')->default('')->comment('关联数据');
            $table->string('remark')->default('')->comment('备注');
            $table->decimal('amount', 10)->default(0)->comment('金额');
            $table->decimal('before_money', 10)->default(0)->comment('操作前余额');
            $table->decimal('after_money', 10)->default(0)->comment('操作后余额');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        // 创建用户支付记录表
        Schema::create('user_payment_logs', function (Blueprint $table) {
            $table->comment('用户支付记录');
            $table->string('out_trade_no')->primary()->comment('支付流水号');
            $table->integer('user_id')->default(0)->comment('会员id');
            $table->string('pay_method')->default('')->comment('支付方式');
            $table->string('pay_type')->default('')->comment('支付用途');
            $table->decimal('amount', 10)->default(0)->comment('支付金额');
            $table->boolean('status')->comment('状态(0=未支付、1=已支付、2=已退款)');
            $table->string('relevance')->default('')->comment('关联数据');
            $table->string('out_refund_no')->default('')->comment('退款流水号');
            $table->dateTime('refund_at')->nullable()->comment('退款时间');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        // 创建会员提现记录表
        Schema::create('user_withdraw_logs', function (Blueprint $table) {
            $table->comment('会员提现记录');
            $table->integer('id', true);
            $table->integer('user_id')->comment('会员id');
            $table->string('coin_type')->default('')->comment('币种');
            $table->decimal('amount', 10)->default(0)->comment('金额');
            $table->decimal('fee', 10)->default(0)->comment('手续费');
            $table->string('content')->default('')->comment('提现说明');
            $table->string('remark')->default('')->comment('会员备注');
            $table->enum('status', ['apply', 'passed', 'paid', 'rejected'])->default('apply')->comment('状态，apply=申请中、passed=已通过、paid=已打款、rejected=已驳回');
            $table->string('alipay_account')->default('')->comment('支付宝账号');
            $table->string('alipay_username')->default('')->comment('支付宝实名');
            $table->string('wx_account')->default('')->comment('微信账号');
            $table->string('wx_username')->default('')->comment('微信实名');
            $table->string('wx_openid')->default('')->comment('微信openid');
            $table->string('bank_card_code')->default('')->comment('银行卡卡号');
            $table->string('bank_card_username')->default('')->comment('银行卡实名');
            $table->string('bank_card_bank')->default('')->comment('银行卡所属银行');
            $table->string('bank_card_sub_bank')->default('')->comment('银行卡支行');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        // 创建文章分类表
        Schema::create('article_categories', function (Blueprint $table) {
            $table->comment('文章分类表');
            $table->integer('id', true);
            $table->string('name')->default('')->comment('分类名称');
            $table->string('image')->default('')->comment('分类图片');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        // 创建文章表
        Schema::create('articles', function (Blueprint $table) {
            $table->comment('文章表');
            $table->integer('id', true);
            $table->integer('category_id')->comment('文章分类id');
            $table->string('title')->default('')->comment('标题');
            $table->string('intro')->default('')->comment('简介');
            $table->string('image')->default('')->comment('图片');
            $table->string('author')->default('')->comment('作者');
            $table->string('keyword')->default('')->comment('关键词');
            $table->longText('content')->comment('内容');
            $table->enum('status', ['normal', 'hidden'])->default('normal')->comment('状态：normal-发布，hidden-隐藏');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        // 创建意见反馈类型表
        Schema::create('feedback_types', function (Blueprint $table) {
            $table->comment('意见反馈类型表');
            $table->integer('id', true);
            $table->string('name', 50)->default('')->comment('类型名称');
            $table->tinyInteger('sort')->default(0)->comment('排序');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        // 创建意见反馈表
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->comment('意见反馈表');
            $table->integer('id', true);
            $table->integer('user_id')->default(0)->comment('会员ID');
            $table->string('type', 50)->default('')->comment('反馈类型');
            $table->text('content')->comment('反馈内容');
            $table->string('contact', 100)->default('')->comment('联系方式');
            $table->text('images')->nullable()->comment('图片列表');
            $table->enum('status', ['shelved', 'processed', 'rejected', 'untreated'])->default('untreated')->comment('状态:untreated=未处理,shelve=搁置,success=已处理,reject=拒绝处理');
            $table->string('admin_remark', 2550)->default('')->comment('管理员备注');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        // 创建轮播图表
        Schema::create('sys_banners', function (Blueprint $table) {
            $table->comment('轮播图表');
            $table->integer('id', true);
            $table->string('site')->comment('位置');
            $table->string('image')->comment('图片');
            $table->enum('link_type', ['nothing', 'external_link', 'internal_link', 'article_id'])->default('nothing');
            $table->string('link')->default('')->comment('链接');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        // 创建系统消息表
        Schema::create('sys_message_logs', function (Blueprint $table) {
            $table->comment('系统消息表');
            $table->integer('id', true);
            $table->string('send_users_group', 50)->default('USERS')->comment('发送用户组');
            $table->string("send_type", 50)->default('SYS')->comment('发送类型');
            $table->string('user_ids', 2550)->default('0')->comment('会员id集');
            $table->string('title')->default('')->comment('标题');
            $table->string('image')->default('')->comment('图片');
            $table->string('content')->default('')->comment('内容');
            $table->string('relevance_data', 2550)->default('')->comment('关联数据');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        // 创建系统公告表
        Schema::create('sys_notices', function (Blueprint $table) {
            $table->comment('系统公告表');
            $table->integer('id', true)->comment('公告id');
            $table->string('title')->default('')->comment('标题');
            $table->text('content')->nullable()->comment('内容');
            $table->string('image')->default('')->comment('图片');
            $table->enum('status', ['normal', 'hidden'])->default('normal')->comment('状态');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        // 创建网站设置表
        Schema::create('sys_settings', function (Blueprint $table) {
            $table->comment('网站设置表');
            $table->string('key')->default('')->primary()->comment('键');
            $table->longText('value')->comment('值');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_settings');
        Schema::dropIfExists('sys_notices');
        Schema::dropIfExists('sys_message_logs');
        Schema::dropIfExists('sys_banners');
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('feedback_types');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_categories');
        Schema::dropIfExists('user_withdraw_logs');
        Schema::dropIfExists('user_payment_logs');
        Schema::dropIfExists('user_balance_logs');
        Schema::dropIfExists('user_balances');
        Schema::dropIfExists('user_details');
        Schema::dropIfExists('users');
    }
};