<?php

namespace Tests\Unit;

use App\Discounts\ProductToolsDiscount;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ProductToolsDiscountTest extends TestCase
{
    use WithFaker;

    /**
     * @return void
     */
    public function testProductToolsHasDiscount()
    {
        $product = $this->createProduct();

        $quantity = config('discounts.toolsProductsNumberToDiscount') + $this->faker->randomDigit;
        $productSwitchesDiscount = new ProductToolsDiscount([[
            'product-id' =>  $product->product_id,
            'quantity' =>  $quantity,
            'unit-price' => $product->price,
            'total' => $product->price * $quantity,
        ]]);

        $this->assertGreaterThan(0, $productSwitchesDiscount->calculate());
    }

    /**
     * @return void
     */
    public function testProductToolsHasNotDiscount()
    {
        $product = $this->createProduct();

        $quantity = config('discounts.toolsProductsNumberToDiscount') - $this->faker->randomDigit;
        $productSwitchesDiscount = new ProductToolsDiscount([[
            'product-id' =>  $product->product_id,
            'quantity' =>  $quantity,
            'unit-price' => $product->price,
            'total' => $product->price * $quantity,
        ]]);

        $this->assertEquals(0, $productSwitchesDiscount->calculate());
    }

    /**
     * @return mixed
     */
    private function createProduct()
    {
        return factory(Product::class)->create([
            'product_id' => $this->faker->ean8,
            'description' => $this->faker->sentence(5),
            'category_id' => config('discounts.toolsCategoryId'),
            'price' => $this->faker->randomFloat(2, 10, 100),
        ]);
    }
}
