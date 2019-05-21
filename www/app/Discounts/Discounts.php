<?php

namespace App\Discounts;

class Discounts
{

    /** @var  DiscountInterface[]  */
    private $discounts;

    /**
     * Discounts constructor.
     *
     * @param DiscountInterface[] $discounts
     */
    public function __construct($discounts)
    {
        $this->discounts = $discounts;
    }

    /**
     * @return float
     */
    public function calculate()
    {
        $discountSum = 0;
        foreach ($this->discounts as $discount) {
            $discountSum += $discount->calculate();
        }

        return \Currency::format($discountSum);
    }
}