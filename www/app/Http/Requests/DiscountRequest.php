<?php

namespace App\Http\Requests;

use App\Rules\PriceValidator;
use App\Rules\TotalValidator;
use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric',
            'customer-id' => 'required|numeric|exists:customer,id',
            'items' => 'required|array',
            'items.*.product-id' => 'required|string|exists:product,product_id',
            'items.*.quantity' => 'required|numeric',
            'items.*.unit-price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', new PriceValidator($this->items)],
            'items.*.total' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'total' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', new TotalValidator($this->items)],
        ];
    }
}
