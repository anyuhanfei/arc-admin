<?php
namespace App\Enums;

trait BaseEnumTrait{

    /**
     * 根据值获取描述。
     *
     * @param string $value
     * @return string|null
     */
    public static function getDescription(string $value){
        return self::getDescriptions()[$value] ?? null;
    }

    /**
     * 根据描述获取枚举值。
     *
     * @param string $description
     * @return string|null
     */
    public static function getValueByDescription(string $description): ?string{
        $descriptions = self::getDescriptions();
        return array_search($description, $descriptions) ?: null;
    }

    /**
     * 获取反向映射关系。
     *
     * @return array
     */
    public static function getReverseMap(): array{
        $descriptions = self::getDescriptions();
        return array_flip($descriptions);
    }

    /**
     * 获取所有枚举值的描述。
     *
     * @return array
     */
    public static function getValues(): array{
        // 修改：直接返回 getDescriptions 的值数组
        return array_values(self::getDescriptions());
    }

    /**
     * 获取所有枚举值的名称。
     *
     * @return array
     */
    public static function getKeys(): array{
        // 修改：直接返回 getDescriptions 的键数组
        return array_keys(self::getDescriptions());
    }
}
