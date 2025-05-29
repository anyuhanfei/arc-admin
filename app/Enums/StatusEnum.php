<?php
namespace App\Enums;

// 普通开关状态枚举值
enum StatusEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const NORMAL = 'normal';
    const HIDDEN = 'hidden';

    public static function getDescriptions(): array{
        return [
            self::NORMAL => '正常',
            self::HIDDEN => '隐藏',
        ];
    }

    public static function getColors(): array{
        return [
            self::NORMAL => 'success',
            self::HIDDEN => 'danger',
        ];
    }
}
