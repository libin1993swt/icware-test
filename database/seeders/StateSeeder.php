<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            ['country_id' => 1, 'name' => 'Kerala'],
            ['country_id' => 1, 'name' => 'TamilNadu']
        ];
    
        State::insert($states);
    }
}
