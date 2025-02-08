<?php
namespace App\Api\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

use App\Repositories\Sys\SysBanners;

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
            $site_array = (new SysBanners())->site_array();
            return in_array($value, $site_array);
        }
    }

    public function message(){
        return "请传入正确的位置参数";
    }
}