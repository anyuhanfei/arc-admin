<?php

namespace App\Enums\SysBanners;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

// 轮播图内链类型
enum InternalLikeEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const ONE = '/page/page/index';
    const TWO = '/page/page/my';

    public static function getDescriptions(): array{
        return [
            self::ONE => '首页',
            self::TWO => '个人中心',
        ];
    }
}