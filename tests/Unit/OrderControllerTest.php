<?php

namespace Tests\Unit;

use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    private $token;

    /**
     * Ran after EVERY METHOD
     */
    public function setUp(): void
    {
        parent::setUp();

        // seed our products table dear
        $seeder = new ProductSeeder();
        $seeder->run();

        $this->createUser();

        $this->token = $this->getToken();
    }

    /**
     * Test successful order creation
     */
    public function testSuccessfulOrderCreation()
    {
        $product = Product::first();

        $response = $this->json('POST', '/api/orders', [
            'product_id' => $product->id,
            'quantity' => 10
        ]);

        $response->assertSuccessful();
        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'You have successfully ordered this product.'
        ]);

        $oldCount = $product->available_stock;
        // get the updated version
        $product->refresh();

        // assert that a successful deduction had happened
        $this->assertEquals($oldCount - 10, $product->available_stock);
    }

    /**
     * Test failed validation
     */
    public function testFailedValidation()
    {
        /**
         * attempt to make a request with invalid request body
         */
        $response = $this->json('POST', '/api/orders', []);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'product_id' => [
                    'The product id field is required.'
                ],
                'quantity' =>[
                    'The quantity field is required.'
                ]
            ]
        ]);

        /**
         * attempt to make a request with invalid product_id
         */
        $response = $this->json('POST', '/api/orders', [
            'product_id' => 1000,
            'quantity' => 10
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'product_id' => [
                    'The selected product id is invalid.'
                ]
            ]
        ]);

        /**
         * attempt to make a request with invalid qty
         */
        $response = $this->json('POST', '/api/orders', [
            'product_id' => 1,
            'quantity' => 10000
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Failed to order this product due to unavailability of the stock',
        ]);
    }

    /**
     * We will now register a new user
     *
     * @return void
     */
    private function createUser(): void
    {
        $this->json('POST', '/api/register', [
            'email' => 'lastly@thisis.com',
            'password' => 'testcode'
        ]);
    }

    /**
     * We will now get the access token of the user
     *
     * @return string
     */
    private function getToken(): string
    {
        $response = $this->json('POST', '/api/login', [
            'email' => 'lastly@thisis.com',
            'password' => 'testcode'
        ]);

        return $response->json(['access_token']);
    }
}
