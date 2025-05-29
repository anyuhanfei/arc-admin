<?php
namespace App\Enums;

interface BaseEnumInterface{
    // 设置每个枚举值的描述
    static function getDescriptions(): array;
}

