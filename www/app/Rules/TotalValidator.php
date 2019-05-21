<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TotalValidator implements Rule
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
        $total = 0;
        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                !empty($item['unit-price']) && $total += $item['total'];
            }
        }

        return \Currency::format($value) === \Currency::format($total);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The total is invalid.';
    }
}
