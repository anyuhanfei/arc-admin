<?php
namespace App\Enums\Users;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

// 普通开关状态枚举值
enum LoginStatusEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const NORMAL = 'normal';
    const FROZEN = 'frozen';

    public static function getDescriptions(): array{
        return [
            self::NORMAL => '正常',
            self::FROZEN => '冻结',
        ];
    }

    public static function getColors(): array{
        return [
            self::NORMAL => 'success',
            self::FROZEN => 'danger',
        ];
    }
}
