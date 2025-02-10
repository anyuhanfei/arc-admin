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
        Schema::create('user_withdraw_logs', function (Blueprint $table) {
            $table->comment('会员提现记录');
            $table->integer('id', true);
            $table->integer('user_id')->comment('会员id');
            $table->string('coin_type')->default('')->comment('币种');
            $table->decimal('amount', 10)->default(0)->comment('金额');
            $table->decimal('fee', 10)->default(0)->comment('手续费');
            $table->string('content')->default('')->comment('提现说明');
            $table->string('remark')->default('')->comment('会员备注');
            $table->boolean('status')->default(false)->comment('状态，0=申请中、1=通过、2=驳回');
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_withdraw_logs');
    }
};
