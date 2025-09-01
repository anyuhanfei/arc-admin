<?php

namespace App\Enums\SysBanners;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

// 轮播图位置
enum SiteEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const HOME = 'home';
    const USER = 'user';

    public static function getDescriptions(): array{
        return [
            self::HOME => '首页',
            self::USER => '用户中心',
        ];
    }
}