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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_banners');
    }
};
