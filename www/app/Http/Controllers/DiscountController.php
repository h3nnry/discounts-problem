<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Discounts\Discounts;
use App\Product;
use Illuminate\Http\Request;

/**
 * Class EmailController
 * @package App\Http\Controllers
 */
class DiscountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {

        $data = $request->all();
        \Validator::extend('validate_price', function($field, $value) use ($data) {
            $i = (int) filter_var($field, FILTER_SANITIZE_NUMBER_INT);
            $product = Product::where('product_id', '=', $data['items'][$i]['product-id'])->first();
            return number_format((float)$value, 2) === number_format((float)$product->price, 2);
        });
        \Validator::extend('validate_total', function($field, $value) use ($data) {
            $total = 0;
            if (!empty($data['items'])) {
                foreach ($data['items'] as $item) {
                    !empty($item['unit-price']) && $total += $item['total'];
                }
            }
            return number_format((float)$value, 2) === number_format((float)$total, 2);
        });
        $this->validate($request, [
            'id' => 'required|numeric',
            'customer-id' => 'required|numeric|exists:customer,id',
            'items' => 'required|array',
            'items.*.product-id' => 'required|string|exists:product,product_id',
            'items.*.quantity' => 'required|numeric',
            'items.*.unit-price' => 'required|regex:/^\d+(\.\d{1,2})?$/|validate_price',
            'items.*.total' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'total' => 'required|regex:/^\d+(\.\d{1,2})?$/|validate_total',
        ]);

        $customer = Customer::find($data['customer-id']);

        $discounts = new Discounts($customer, $data['items'], $data['total']);
        $discount = $discounts->getDiscount();

        return response()->json(['discount' => $discount ]);
    }

}
