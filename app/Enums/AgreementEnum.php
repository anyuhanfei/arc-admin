<?php
namespace App\Enums;

// 协议类型枚举值
enum AgreementEnum implements BaseEnumInterface{
    use BaseEnumTrait;

    const USER_AGREEMENT = 'user_agreement';
    const USER_PRIVACY = 'user_privacy';
    const ABOUT_US = 'about_us';

    public static function getDescriptions(): array{
        return [
            self::USER_AGREEMENT => '用户协议',
            self::USER_PRIVACY => '隐私政策',
            self::ABOUT_US => '关于我们',
        ];
    }
}
