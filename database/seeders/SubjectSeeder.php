<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            ['name' => 'Maths'],
            ['name' => 'Science'],
            ['name' => 'Computer'],
        ];
    
        Subject::insert($subjects);
    }
}
