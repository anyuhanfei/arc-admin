<?php

namespace App\Enums\SysBanners;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

// 轮播图位置
enum SiteEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const HOME = 'home';

    public static function getDescriptions(): array{
        return [
            self::HOME => '首页',
        ];
    }
}