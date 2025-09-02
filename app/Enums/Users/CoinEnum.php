<?php

namespace App\Enums\Users;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

// 用户资金类型
// 当这里的资金种类改变时，必须同步改变数据库表 user_fund 中的字段
enum CoinEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const MONEY = 'money';
    const INTEGRAL = 'integral';

    public static function getDescriptions(): array{
        return [
            self::MONEY => '余额',
            self::INTEGRAL => '积分',
        ];
    }
}

