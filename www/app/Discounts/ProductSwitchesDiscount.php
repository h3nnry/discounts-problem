<?php

namespace App\Discounts;

use App\Repositories\ProductRepository;

class ProductSwitchesDiscount implements DiscountInterface
{
    /** @var array  */
    private $items;

    /**
     * ProductSwitchesDiscount constructor.
     *
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return float|int
     */
    public function calculate()
    {
        $discount = 0;
        foreach ($this->items as $item) {
            $product = ProductRepository::findByProductId($item['product-id']);
            if ($product->category_id == config('discounts.switchesCategoryId')
                && $item['quantity'] > config('discounts.switchesProductsNumberToDiscount')) {

                $productNumberToDiscount = floor($item['quantity'] / config('discounts.switchesProductsNumberToDiscount'));
                $discount += $productNumberToDiscount * $product->price;
            }
        }

        return \Currency::format($discount);
    }
}