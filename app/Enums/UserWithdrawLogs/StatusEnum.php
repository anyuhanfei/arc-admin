<?php

namespace App\Enums\UserWithdrawLogs;

use App\Enums\BaseEnumInterface;

// 用户提现数据的状态
enum StatusEnum implements BaseEnumInterface{
    const APPLY = 'apply';
    const PASSED = 'passed';
    const PAID = 'paid';
    const REJECTED = 'rejected';

    public static function getDescriptions(): array{
        return [
            self::APPLY => '申请中',
            self::PASSED => '已通过',
            self::PAID => '已打款',
            self::REJECTED => '已驳回',
        ];
    }

    public static function getColors(): array{
        return [
            self::APPLY => 'danger',
            self::PASSED => 'warning',
            self::PAID => 'success',
            self::REJECTED => 'danger',
        ];
    }
}

