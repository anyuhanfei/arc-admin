<?php
namespace App\Enums\SysMessageLogs;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

// 消息发送类型枚举值
enum SendTypeEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const SYS = 'sys';

    public static function getDescriptions(): array{
        return [
            self::SYS => '系统消息',
        ];
    }
}
