<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    const PRODUCT_URI = '/api/v1/products';

    /**
     * Testing the status code of user try to list products without any created.
     * 
     * @return void
     */
    public function test_making_get_request_to_list_without_products()
    {
        Product::factory()->make();

        $response = $this->getJson(self::PRODUCT_URI);
        $response->assertStatus(404);
    }

    /**
     * Testing the status code of listing products.
     * 
     * @return void
     */
    public function test_making_get_request_to_list_products()
    {
        Product::factory(10)->create();

        $response = $this->getJson(self::PRODUCT_URI);
        $response->assertStatus(200);
    }

    /**
     * Testing the status code of list on specific product.
     * 
     * @return void
     */
    public function test_making_get_request_to_list_one_product()
    {
        $data = Product::factory()->create();

        $response = $this->getJson(self::PRODUCT_URI . '/' . $data->id);
        $response->assertStatus(200);
    }

    /**
     * Testing the case that the user try to get a product but it don't exists.
     * 
     * @return void
     */
    public function test_making_get_request_to_list_product_that_dont_exists()
    {
        Product::factory(10)->create();
        $id = 999;

        $response = $this->getJson(self::PRODUCT_URI . '/' . $id);
        $response->assertStatus(404);
    }

    /**
     * Testing the status code to store a new product
     * 
     * @return void
     */
    public function test_making_post_request_to_store_product()
    {
        $data = Product::factory()->create();

        $response = $this->postJson(self::PRODUCT_URI, $data->toArray());
        $response->assertStatus(201);
    }

    /**
     * Testing the post request sending invalid value.
     * 
     * @return void
     */
    public function test_making_post_request_to_store_product_with_invalid_data()
    {
        $data = [
            'name' => null,
            'type' => 'Limpeza',
            'quantity' => 'Cinquenta e oito'
        ];

        $response = $this->postJson(self::PRODUCT_URI, $data);
        $response->assertStatus(500);
    }

     /**
     * Testing the put request to update a product.
     * 
     * @return void
     */
    public function test_making_put_request_to_update_product()
    {
        $data = Product::factory()->create();

        $toUpdate = [
            'name' => 'Picanha',
            'type' => 'Carnes',
            'quantity' => 75
        ];

        $response = $this->putJson(self::PRODUCT_URI . '/' . $data->id, $toUpdate);
        $response->assertStatus(200);
    }

    /**
     * Testing the put request sending invalid value.
     * 
     * @return void
     */
    public function test_making_put_request_to_update_product_with_invalid_data()
    {
        $data = Product::factory()->create();

        $toUpdate = [
            'name' => 'Picanha',
            'type' => 80,
            'quantity' => ['1', '2', '3']
        ];

        $response = $this->putJson(self::PRODUCT_URI . '/' . $data->id, $toUpdate);
        $response->assertStatus(500);
    }

    /**
     * Testing the delete request to product.
     * 
     * @return void
     */
    public function test_making_delete_request_to_delete_product()
    {
        $data = Product::factory()->create();

        $response = $this->deleteJson(self::PRODUCT_URI . '/' . $data->id);
        $response->assertStatus(200);
    }

    /**
     * Testing the incrementing the quantity of a single product with a put request.
     * 
     * @return void
     */
    public function test_making_put_request_to_increments_quantity()
    {
        $data = Product::factory()->create();

        $toIncrement = [
            'quantity' => 75
        ];

        $response = $this->putJson(self::PRODUCT_URI . '/' . $data->id . '/increments', $toIncrement);
        $response->assertStatus(200);
    }

    /**
     * Testing the incrementing the quantity with a put request sending invalid value
     * 
     * @return void
     */
    public function test_making_put_request_to_increments_quantity_with_invalid_data()
    {
        $data = Product::factory()->create();

        $toIncrement = [
            'quantity' => null
        ];

        $response = $this->putJson(self::PRODUCT_URI . '/' . $data->id . '/increments', $toIncrement);
        $response->assertStatus(500);
    }
}
