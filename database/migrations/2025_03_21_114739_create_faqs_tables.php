<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('faq_types');
        Schema::create('faq_types', function (Blueprint $table) {
            $table->comment('常见问题类型表');
            $table->bigIncrements('id');
            $table->string('name')->default('')->comment('类型名称');
            $table->enum('status', ['normal', 'hidden'])->default('normal')->comment('状态');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::dropIfExists('faqs');
        Schema::create('faqs', function (Blueprint $table) {
            $table->comment('常见问题表');
            $table->bigIncrements('id');
            $table->integer('type_id')->default(0)->comment('类型ID');
            $table->string('question')->default('')->comment('问题');
            $table->text('answer')->comment('回答');
            $table->enum('status', ['normal', 'hidden'])->default('normal')->comment('状态');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_types');
        Schema::dropIfExists('faqs');
    }
}
