<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Api 
{
    /**
     * Request to IBGE Api the all brazilian states
     * 
     * @return array
     */
    public static function getStates()
    {   
        $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');

        return json_decode($response->body());
    }

    public static function getRequest()
    {
        return Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
    }

    public static function getErrorRequest()
    {
        return Http::get('https://servicodados.gov.br/api/v1/localidades/estados');
    }
}