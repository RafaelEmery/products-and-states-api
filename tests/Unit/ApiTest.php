<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiTest extends TestCase
{
    const API_URI = 'api/v1/test';

    /**
     * Testing successful get request to external API. 
     * 
     * @return void
     */
    public function test_making_get_request_to_external_api()
    {
        $response = $this->get(self::API_URI . '/success');
        $response->assertStatus(200);
    }

    /**
     * Testing if IBGE api returns 27 states on request
     * 
     * @return void
     */
    public function test_the_number_of_states_returned_by_external_api()
    {
        $response = $this->get(self::API_URI . '/states');
        $this->assertEquals(27, count($response->original));
    }

    /**
     * Testing wrong get request to external API.
     * 
     * @return void
     */
    public function test_making_wrong_get_request_to_external_api()
    {
        $response = $this->get(self::API_URI . '/error');
        $response->assertStatus(500);
    }
}

