<?php

namespace App\Discounts;

use App\Repositories\ProductRepository;

class ProductToolsDiscount implements DiscountInterface
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
        $numberOfProductsOfCategoryTools = $discount = 0;

        foreach ($this->items as $item) {
            $product = ProductRepository::findByProductId($item['product-id']);
            if ($product->category_id == config('discounts.toolsCategoryId')) {
                $numberOfProductsOfCategoryTools += $item['quantity'];
            }

            if ($numberOfProductsOfCategoryTools >= config('discounts.toolsProductsNumberToDiscount')) {

                $productMinPrice = min(array_column($this->items, 'unit-price'));

                $cheapestProducts = array_filter($this->items, function ($item) use ($productMinPrice) {
                    return $item['unit-price'] == $productMinPrice;
                });

                $cheapestProduct = array_shift($cheapestProducts);
                $cheapestProduct && $discount += $cheapestProduct['total'] * config('discounts.toolsProductsNumberToDiscount') / 100;

                break;
            }
        }

        return \Currency::format($discount);
    }
}