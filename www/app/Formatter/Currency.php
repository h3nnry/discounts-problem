<?php

namespace App\Formatter;

class Currency
{
    /**
     * @param $value
     * @return string
     */
    public function format($value)
    {
        return money_format('%.2n', $value);
    }
}