<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Utils\Calculate;
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
        $data = Product::factory(10)->create();

        $this->assertDatabaseCount('products', 10);
        $this->assertDatabaseHas('products', $data->toArray());

        $response = $this->getJson(self::PRODUCT_URI);
        $response->assertOk();
    }

    /**
     * Testing the status code of list on specific product.
     * 
     * @return void
     */
    public function test_making_get_request_to_list_one_product()
    {
        $data = Product::factory()->create();

        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', $data->toArray());

        $response = $this->getJson(self::PRODUCT_URI . '/' . $data->id);
        $response->assertOk();
    }

    /**
     * Testing the case that the user try to get a product but it don't exists.
     * 
     * @return void
     */
    public function test_making_get_request_to_list_product_that_dont_exists()
    {
        $data = Product::factory(10)->create();
        $id = 999;

        $this->assertDatabaseCount('products', 10);
        $this->assertDatabaseHas('products', $data->toArray());

        $response = $this->getJson(self::PRODUCT_URI . '/' . $id);
        $response->assertNotFound();
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
        $response->assertCreated();
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

        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'name' => 'Picanha'
        ]);

        $response = $this->putJson(self::PRODUCT_URI . '/' . $data->id, $toUpdate);
        $response->assertOk(); 
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

        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', $data->toArray());

        $response = $this->deleteJson(self::PRODUCT_URI . '/' . $data->id);
        $response->assertOk();

        $this->assertDeleted('products', $data->toArray());
    }

    /**
     * Testing the incrementing the quantity of a single product with a put request.
     * 
     * @return void
     */
    public function test_making_put_request_to_increment_quantity()
    {
        $data = Product::factory()->create();
        $calculate = new Calculate($data->quantity);
        $toIncrement = [
            'quantity' => 75
        ];

        $this->assertEquals($data->quantity + 75, $calculate->increment(75));
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'quantity' => $calculate->increment(75)
        ]);

        $response = $this->putJson(self::PRODUCT_URI . '/' . $data->id . '/increments', $toIncrement);
        $response->assertOk(); 
    }

    /**
     * Testing the incrementing the quantity of a single product with a put request.
     * 
     * @return void
     */
    public function test_making_put_request_to_decrement_quantity()
    {
        $data = Product::factory()->create();
        $calculate = new Calculate($data->quantity);
        $toDecrement = [
            'quantity' => -15
        ];

        $this->assertEquals($data->quantity - 15, $calculate->increment(-15));
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'quantity' => $calculate->increment(-15)
        ]);

        $response = $this->putJson(self::PRODUCT_URI . '/' . $data->id . '/increments', $toDecrement);
        $response->assertOk();
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
