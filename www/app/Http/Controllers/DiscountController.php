<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Discounts\CustomerDiscount;
use App\Discounts\Discounts;
use App\Discounts\ProductSwitchesDiscount;
use App\Discounts\ProductToolsDiscount;
use App\Http\Requests\DiscountRequest;

class DiscountController extends Controller
{
    /**
     * @param DiscountRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(DiscountRequest $request)
    {
        $request->validated();

        $customer = Customer::find($request->get('customer-id'));

        $discounts = new Discounts([
            new CustomerDiscount($customer, $request->get('total')),
            new ProductSwitchesDiscount($request->get('items')),
            new ProductToolsDiscount($request->get('items')),
        ]);

        return response()->json(['discount' => $discounts->calculate() ]);
    }
}
