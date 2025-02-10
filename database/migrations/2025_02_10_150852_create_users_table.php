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
            $table->string('openid')->default('');
            $table->boolean('login_status')->default(true)->comment('登录状态(0=冻结、1=正常)');
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
        Schema::dropIfExists('users');
    }
};
