<?php

namespace Indeximstudio\Helpers\Numerals;

class Price
{
    /**
     * Преобразует цену в Английский формат
     *
     * Пример: 3,562,568.27
     * @param $price
     * @return string
     */
    public static function getEnglishFormat($price): string
    {
        return number_format($price, 2, '.', ',');
    }
}