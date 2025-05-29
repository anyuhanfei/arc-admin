<?php
namespace App\Enums\SysNotices;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

// 公告开关状态枚举值
enum StatusEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const NORMAL = 'normal';
    const HIDDEN = 'hidden';

    public static function getDescriptions(): array{
        return [
            self::NORMAL => '发布',
            self::HIDDEN => '草稿',
        ];
    }

    public static function getColors(): array{
        return [
            self::NORMAL => 'success',
            self::HIDDEN => 'danger',
        ];
    }
}
