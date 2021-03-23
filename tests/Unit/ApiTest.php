<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * Testing request status to an external IGBE api.
     * 
     * @return void
     */
    public function test_making_get_request_to_external_api()
    {
        $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
        $response->getStatusCode();
    }
}
