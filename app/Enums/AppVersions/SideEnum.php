<?php
namespace App\Enums\AppVersions;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

// APP的端枚举值
// 至少有一个枚举值
enum SideEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const USER_SIDE = 'user_side';
    const ADMIN_SIDE = 'admin_side';

    public static function getDescriptions(): array{
        return [
            self::USER_SIDE => '用户端',
            self::ADMIN_SIDE => '管理端',
        ];
    }
}
