<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Term;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $terms = [
            ['term' => 'First'],
            ['term' => 'Second'],
            ['term' => 'Third'],
        ];
    
        Term::insert($terms);
    }
}
