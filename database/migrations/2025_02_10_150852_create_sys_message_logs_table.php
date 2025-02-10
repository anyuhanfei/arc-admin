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
        Schema::create('sys_message_logs', function (Blueprint $table) {
            $table->comment('系统消息表');
            $table->integer('id', true);
            $table->string('user_ids', 2550)->default('0')->comment('会员id集');
            $table->string('title')->default('')->comment('标题');
            $table->string('image')->default('')->comment('图片');
            $table->string('content')->default('')->comment('内容');
            $table->string('relevance_data', 2550)->comment('关联数据');
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
        Schema::dropIfExists('sys_message_logs');
    }
};
