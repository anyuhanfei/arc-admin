<?php

namespace App\Enums\Feedback;

use App\Enums\BaseEnumInterface;

// 用户反馈数据的状态
enum StatusEnum implements BaseEnumInterface{
    const UNTREATED = 'untreated';
    const SHELF = 'shelved';
    const PROCESSED = 'processed';
    const REJECTED = 'rejected';

    public static function getDescriptions(): array{
        return [
            self::UNTREATED => '未处理',
            self::SHELF => '搁置',
            self::PROCESSED => '已处理',
            self::REJECTED => '拒绝处理',
        ];
    }

    public static function getColors(): array{
        return [
            self::UNTREATED => 'danger',
            self::SHELF => 'warning',
            self::PROCESSED => 'success',
            self::REJECTED => 'danger',
        ];
    }
}

