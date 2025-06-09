<?php
namespace App\Api\Requests\Sys;

use App\Api\Requests\BaseRequest;

// 验证轮播图位置参数
class BannerRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'site' => [new \App\Api\Rules\Sys\BannerSiteNoExistVerify],
        ];
    }

    public function messages(){
        return [
        ];
    }
}