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
        Schema::create('user_details', function (Blueprint $table) {
            $table->comment('会员信息详情表');
            $table->integer('id')->primary();
            $table->enum('sex', ['未知', '男', '女'])->nullable()->default('未知')->comment('性别');
            $table->string('birthday')->nullable()->comment('生日');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
