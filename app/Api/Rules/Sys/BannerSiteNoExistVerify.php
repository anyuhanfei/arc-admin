<?php
namespace App\Api\Rules\Sys;

use App\Enums\SysBanners\SiteEnum;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;


/**
 * 判断传入的位置参数是否正确（不正确不能通过验证）
 */
class BannerSiteNoExistVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        if($value == '' || $value == null){
            return true;
        }else{
            return in_array($value, SiteEnum::getKeys());
        }
    }

    public function message(){
        return "请传入正确的位置参数";
    }
}