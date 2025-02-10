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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_balance_logs');
    }
};
