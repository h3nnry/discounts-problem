<?php

namespace App\Rules;

use App\Repositories\ProductRepository;
use Illuminate\Contracts\Validation\Rule;

class PriceValidator implements Rule
{
    /** @var array */
    private $items;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $i = (int) filter_var($attribute, FILTER_SANITIZE_NUMBER_INT);
        $product = ProductRepository::findByProductId($this->items[$i]['product-id']);
        if (!empty($product)) {
            return \Currency::format($value) === \Currency::format($product->price);
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Product price is invalid.';
    }
}
