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
        $response = $this->get(self::API_URI . '/success-request');
        $response->assertStatus(200);
    }

    /**
     * Testing wrong get request to external API.
     * 
     * @return void
     */
    public function test_making_wrong_get_request_to_external_api()
    {
        $response = $this->get(self::API_URI . '/error-request');
        $response->assertStatus(500);
    }
}

