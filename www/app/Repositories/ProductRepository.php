<?php

namespace App\Repositories;

use App\Product;

class ProductRepository
{
    /**
     * @param $productId
     * @return mixed
     */
    public static function findByProductId($productId)
    {
        return Product::where('product_id', '=', $productId)->first();
    }
}