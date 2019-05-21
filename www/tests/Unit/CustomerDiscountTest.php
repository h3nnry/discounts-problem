<?php

namespace Tests\Unit;

use App\Customer;
use App\Discounts\CustomerDiscount;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CustomerDiscountTest extends TestCase
{
    use WithFaker;

    /**
     * @return void
     */
    public function testCustomerHasDiscount()
    {
        $customer = new Customer([
            'name' => 'Test',
            'revenue' => config('discounts.maxCustomerBoughtDiscount') + $this->faker->randomNumber(3),
            'since' => $this->faker->date('Y-m-d', 'now'),
        ]);

        $total = $this->faker->randomNumber(3);

        $customerDiscount = new CustomerDiscount($customer, $total);

        $this->assertGreaterThan(0, $customerDiscount->calculate());
    }

    /**
     * @return void
     */
    public function testCustomerHasNotDiscount()
    {
        $customer = new Customer([
            'name' => 'Test',
            'revenue' => config('discounts.maxCustomerBoughtDiscount') - $this->faker->randomNumber(1),
            'since' => $this->faker->date('Y-m-d', 'now'),
        ]);

        $total = $this->faker->randomNumber(3);

        $customerDiscount = new CustomerDiscount($customer, $total);

        $this->assertEquals(0, $customerDiscount->calculate());
    }
}
