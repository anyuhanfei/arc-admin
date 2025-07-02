<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('app_versions', function (Blueprint $table) {
            $table->id();
            $table->string('side')->nullable()->comment('端');
            $table->boolean('is_force')->default(0)->comment('是否强制更新');
            $table->string('wgt_url')->nullable()->comment('wgt包下载地址');
            $table->string('i_app_url')->nullable()->comment('iOS应用商店地址');
            $table->string('a_app_url')->nullable()->comment('Android应用下载地址');
            $table->boolean('is_complete')->default(0)->comment('是否整包更新');
            $table->integer('version')->comment('版本号(数字)');
            $table->string('version_name')->comment('版本名称');
            $table->string('size')->nullable()->comment('包大小');
            $table->text('content')->nullable()->comment('更新内容');
            $table->timestamps();
            $table->index('version');
        });
    }

    public function down(): void{
        Schema::dropIfExists('app_versions');
    }
};
