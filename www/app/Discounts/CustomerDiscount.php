<?php

namespace App\Discounts;

use App\Customer;

class CustomerDiscount implements DiscountInterface
{

    /** @var Customer */
    private $customer;

    /** @var float */
    private $total;


    /**
     * CustomerDiscount constructor.
     *
     * @param Customer $customer
     * @param float $total
     */
    public function __construct(Customer $customer, float $total)
    {
        $this->customer = $customer;
        $this->total = $total;
    }

    /**
     * @return float|int
     */
    public function calculate()
    {
        if ($this->customer->revenue > config('discounts.maxCustomerBoughtDiscount')) {
            return \Currency::format($this->total * config('discounts.customerDiscountPercent') / 100);
        }

        return 0;
    }
}