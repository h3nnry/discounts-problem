<?php

use Symfony\Component\HttpFoundation\Response;

class DicountTest extends TestCase
{

    /**
     * @return void
     */
    public function testInvalidCustomer()
    {
        $data = array (
            'id' =>  1,
            'customer-id' =>  0,
            'items' => [
                [
                    'product-id' => 'B102',
                    'quantity' => 10,
                    'unit-price' => 4.99,
                    'total' => 49.90,
                ]
            ],
            'total' => 49.90,
        );
        $response = $this->post('/discount', $data);
        $response->seeJson(['customer-id' => ['The selected customer-id is invalid.']]);
        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return void
     */
    public function testInvalidTotal()
    {
        $data = array (
            'id' =>  1,
            'customer-id' =>  1,
            'items' => [
                [
                    'product-id' => 'B102',
                    'quantity' => 10,
                    'unit-price' => 4.99,
                    'total' => 49.90,
                ]
            ],
            'total' => 500,
        );
        $response = $this->post('/discount', $data);
        $response->seeJson(['total' => ['Order total is invalid.']]);
        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return void
     */
    public function testInvalidItemUnitPrice()
    {
        $data = array (
            'id' =>  1,
            'customer-id' =>  1,
            'items' => [
                [
                    'product-id' => 'B102',
                    'quantity' => 10,
                    'unit-price' => 41.99,
                    'total' => 49.90,
                ]
            ],
            'total' => 49.90,
        );
        $response = $this->post('/discount', $data);
        $response->seeJson(['items.0.unit-price' => ['Item price is invalid.']]);
        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return void
     */
    public function testInvalidItemProductId()
    {
        $data = array (
            'id' =>  1,
            'customer-id' =>  1,
            'items' => [
                [
                    'product-id' => 'Inexistent',
                    'quantity' => 10,
                    'unit-price' => 41.99,
                    'total' => 49.90,
                ]
            ],
            'total' => 500,
        );
        $response = $this->post('/discount', $data);
        $response->seeJson(['items.0.product-id' => ['The selected items.0.product-id is invalid.']]);
        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return void
     */
    public function testGetCustomerDiscount()
    {
        $data = array (
            'id' =>  1,
            'customer-id' =>  2,
            'items' => [
                [
                    'product-id' => 'B102',
                    'quantity' => 5,
                    'unit-price' => 4.99,
                    'total' => 24.95,
                ],
                [
                    'product-id' => 'A102',
                    'quantity' => 1,
                    'unit-price' => 49.50,
                    'total' => 49.50,
                ]
            ],
            'total' => 74.45,
        );
        $response = $this->post('/discount', $data);
        $response->seeJson(['discount' => '7.45']);
        $response->seeStatusCode(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testGetSwitchesCategoryDiscount()
    {
        $data = array (
            'id' =>  1,
            'customer-id' =>  1,
            'items' => [
                [
                    'product-id' => 'B102',
                    'quantity' => 15,
                    'unit-price' => 4.99,
                    'total' => 74.85,
                ]
            ],
            'total' => 74.85,
        );
        $response = $this->post('/discount', $data);
        $response->seeJson(['discount' => '9.98']);
        $response->seeStatusCode(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testGetToolsCategoryDiscount()
    {
        $data = array (
            'id' =>  1,
            'customer-id' =>  1,
            'items' => [
                [
                    'product-id' => 'A101',
                    'quantity' => 10,
                    'unit-price' => 9.75,
                    'total' => 97.50,
                ],
                [
                    'product-id' => 'A102',
                    'quantity' => 1,
                    'unit-price' => 49.50,
                    'total' => 49.50,
                ]
            ],
            'total' => 147.00,
        );
        $response = $this->post('/discount', $data);
        $response->seeJson(['discount' => '19.50']);
        $response->seeStatusCode(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testGetSwitchesCategoryDiscountAndCustomerDiscount()
    {
        $data = array (
            'id' =>  1,
            'customer-id' =>  2,
            'items' => [
                [
                    'product-id' => 'B102',
                    'quantity' => 15,
                    'unit-price' => 4.99,
                    'total' => 74.85,
                ]
            ],
            'total' => 74.85,
        );
        $response = $this->post('/discount', $data);
        $response->seeJson(['discount' => '17.47']);
        $response->seeStatusCode(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testGetToolsCategoryDiscountAndCustomerDiscount()
    {
        $data = array (
            'id' =>  1,
            'customer-id' =>  2,
            'items' => [
                [
                    'product-id' => 'A101',
                    'quantity' => 10,
                    'unit-price' => 9.75,
                    'total' => 97.50,
                ],
                [
                    'product-id' => 'A102',
                    'quantity' => 1,
                    'unit-price' => 49.50,
                    'total' => 49.50,
                ]
            ],
            'total' => 147.00,
        );
        $response = $this->post('/discount', $data);
        $response->seeJson(['discount' => '34.20']);
        $response->seeStatusCode(Response::HTTP_OK);
    }

    /**
     * @return void
     */
    public function testGetAllPossibleDiscounts()
    {
        $data = array (
            'id' =>  1,
            'customer-id' =>  2,
            'items' => [
                [
                    'product-id' => 'A101',
                    'quantity' => 10,
                    'unit-price' => 9.75,
                    'total' => 97.50,
                ],
                [
                    'product-id' => 'A102',
                    'quantity' => 1,
                    'unit-price' => 49.50,
                    'total' => 49.50,
                ],
                [
                    'product-id' => 'B102',
                    'quantity' => 15,
                    'unit-price' => 4.99,
                    'total' => 74.85,
                ]
            ],
            'total' => 221.85,
        );
        $response = $this->post('/discount', $data);
        $response->seeJson(['discount' => '47.14']);
        $response->seeStatusCode(Response::HTTP_OK);
    }
}
