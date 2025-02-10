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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
