<?php

namespace App\Enums\SysBanners;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

// 轮播图链接类型
enum LinkTypeEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const NOTHING = 'nothing';
    const EXTERNAL_LINK = 'external_link';
    const INTERNAL_LINK = 'internal_link';
    const ARTICLE_ID = 'article_id';

    public static function getDescriptions(): array{
        return [
            self::NOTHING => '不设置',
            self::EXTERNAL_LINK => '外链',
            self::INTERNAL_LINK => '内链',
            self::ARTICLE_ID => '文章',
        ];
    }
}