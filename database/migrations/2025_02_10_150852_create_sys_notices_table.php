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
        Schema::create('sys_notices', function (Blueprint $table) {
            $table->comment('系统公告表');
            $table->integer('id', true)->comment('公告id');
            $table->string('title')->default('')->comment('标题');
            $table->text('content')->nullable()->comment('内容');
            $table->string('image')->default('')->comment('图片');
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
        Schema::dropIfExists('sys_notices');
    }
};
