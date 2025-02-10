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
        Schema::dropIfExists('articles');
    }
};
