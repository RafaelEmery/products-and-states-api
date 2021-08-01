<?php

namespace Tests\Feature\Controllers;

use App\Models\State;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StateControllerTest extends TestCase
{
    use DatabaseMigrations;

    const STATE_URI = '/api/v1/states';

    /**
     * Testing the status code of user try to list products without any created.
     *
     * @return void
     */
    public function test_making_get_request_to_list_without_products()
    {
        State::factory()->make();

        $response = $this->getJson(self::STATE_URI);
        $response->assertStatus(404);
    }

    /**
     * Testing the status code of listing states.
     *
     * @return void
     */
    public function test_making_get_request_to_list_states()
    {
        State::factory(10)->create();

        $response = $this->getJson(self::STATE_URI);
        $response->assertStatus(200);
    }
}
