<?php

return [
    'maxCustomerBoughtDiscount' => env('DISCOUNTS_MAX_CUSTOMER_BOUGHT_DISCOUNT', 1000),
    'customerDiscountPercent' => env('DISCOUNTS_CUSTOMER_DISCOUNT_PERCENT', 10),
    'switchesCategoryId' => env('DISCOUNTS_SWITCHES_CATEGORY_ID', 2),
    'switchesProductsNumberToDiscount' => env('DISCOUNTS_SWITCHES_PRODUCTS_NUMBER_TO_DISCOUNT', 6),
    'toolsCategoryId' => env('DISCOUNTS_TOOLS_CATEGORY_ID', 1),
    'toolsProductsNumberToDiscount' => env('DISCOUNTS_TOOLS_PRODUCTS_NUMBER_TO_DISCOUNT', 2),
    'toolsProductsDiscountPercent' => env('DISCOUNTS_TOOLS_PRODUCTS_DISCOUNT_PERCENT', 20),
];