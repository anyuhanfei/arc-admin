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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payment_logs');
    }
};
