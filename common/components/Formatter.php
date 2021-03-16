<?php


namespace common\components;


class Formatter extends \yii\i18n\Formatter
{
    public function asCurrencyWithDivision($value): string
    {
        return $this->asCurrency($value / 100);
    }

    public function asPriceWithDivision($value): string
    {
        return $value / 100;
    }
}