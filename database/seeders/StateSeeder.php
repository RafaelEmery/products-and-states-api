<?php

namespace Database\Seeders;

use App\Models\State;
use App\Services\Api as StatesApi;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::truncate();

        $states = StatesApi::getStates();

        foreach($states as $state) {            
            State::create([
                'name' => $state->nome,
                'uf' => $state->sigla
            ]);
        }
    }
}
