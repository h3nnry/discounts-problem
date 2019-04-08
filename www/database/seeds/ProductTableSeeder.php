<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'product_id' => 'A101',
            'description' => 'Screwdriver',
            'category_id' => '1',
            'price' => '9.75',
        ]);
        Product::create([
            'product_id' => 'A102',
            'description' => 'Electric screwdriver',
            'category_id' => '1',
            'price' => '49.50',
        ]);
        Product::create([
            'product_id' => 'B101',
            'description' => 'Basic on-off switch',
            'category_id' => '2',
            'price' => '4.99',
        ]);
        Product::create([
            'product_id' => 'B102',
            'description' => 'Press button',
            'category_id' => '2',
            'price' => '4.99',
        ]);
        Product::create([
            'product_id' => 'B103',
            'description' => 'Switch with motion detector',
            'category_id' => '2',
            'price' => '12.95',
        ]);
    }
}
