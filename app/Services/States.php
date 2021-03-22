<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class States 
{
    /**
     * Request to IBGE Api the all brazilian states
     * 
     * @return array
     */
    public static function getStates()
    {   
        $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
        $states = json_decode($response->body());

        return $states;
    }
}