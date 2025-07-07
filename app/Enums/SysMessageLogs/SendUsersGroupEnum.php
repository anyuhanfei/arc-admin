<?php
namespace App\Enums\SysMessageLogs;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

// 消息发送用户组枚举值
// 用于后台系统消息发送时选择用户组，每个枚举值的对应的用户列表需要自行获取
enum SendUsersGroupEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const USERS = 'users';
    

    public static function getDescriptions(): array{
        return [
            self::USERS => '用户',
        ];
    }
}
