<?php

namespace App\Discounts;

use App\Customer;
use App\Product;

/**
 * Class Discounts
 * @package App\Discounts
 */
class Discounts
{
    const MAX_CUSTOMER_BOUGHT_DISCOUNT = 1000;
    const SWITCHES_CATEGORY_ID = 2;
    const SWITCHES_PRODUCTS_NUMBER_TO_DISCOUNT = 6;
    const TOOLS_CATEGORY_ID = 2;
    const TOOLS_PRODUCTS_NUMBER_TO_DISCOUNT = 2;
    const TOOLS_PRODUCTS_DISCOUNT_PERCENT = 20;

    /** @var Customer */
    private $customer;

    /** @var array */
    private $items;

    /** @var float */
    private $total;

    /**
     * Discounts constructor.
     *
     * @param Customer $customer
     * @param array $items
     * @param float $total
     */
    public function __construct(Customer $customer, array $items, float $total)
    {
        $this->customer = $customer;
        $this->items = $items;
        $this->total = $total;

    }

    /**
     * @return string
     */
    public function getDiscount(): string
    {
        $discount = 0;

        $this->getCustomerDiscount($discount);
        $this->getProductSwitchesDiscount($discount);
        $this->getProductToolsDiscount($discount);

        return number_format((float)$discount, 2);
    }

    /**
     * @param $discount
     */
    private function getCustomerDiscount(&$discount): void
    {
        if ($this->customer->revenue > self::MAX_CUSTOMER_BOUGHT_DISCOUNT) {
            $discount += $this->total * 10 / 100;
        }
    }

    /**
     * @param $discount
     */
    private function getProductSwitchesDiscount(&$discount): void
    {
        foreach ($this->items as $item) {
            $product = Product::where('product_id', '=', $item['product-id'])->first();
            if ($product->category_id === self::SWITCHES_CATEGORY_ID
                && $item['quantity'] > self::SWITCHES_PRODUCTS_NUMBER_TO_DISCOUNT) {

                $productNumberToDiscount = floor($item['quantity'] / self::SWITCHES_PRODUCTS_NUMBER_TO_DISCOUNT);
                $discount += $productNumberToDiscount * $product->price;
            }

        }
    }

    /**
     * @param $discount
     */
    private function getProductToolsDiscount(&$discount): void
    {
        $numberOfProductsOfCategoryTools = 0;

        foreach ($this->items as $item) {
            $product = Product::where('product_id', '=', $item['product-id'])->first();
            if ($product->category_id === self::TOOLS_CATEGORY_ID) {
                $numberOfProductsOfCategoryTools += $item['quantity'];
            }

            if ($numberOfProductsOfCategoryTools >= self::TOOLS_PRODUCTS_NUMBER_TO_DISCOUNT) {

                $productMinPrice = min(array_column($this->items, 'unit-price'));

                $cheapestProducts = array_filter($this->items, function ($item) use ($productMinPrice) {
                    return $item['unit-price'] == $productMinPrice;
                });

                $cheapestProduct = array_shift($cheapestProducts);
                $cheapestProduct && $discount += $cheapestProduct['total'] * self::TOOLS_PRODUCTS_DISCOUNT_PERCENT / 100;

                break;
            }
        }
    }
}