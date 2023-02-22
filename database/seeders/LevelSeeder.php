<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //---------------------------
        //-----------Level-----------
        //---------------------------
        Level::create([
            "name" => "Beginner",
        ]);

        Level::create([
            "name" => "Intermediate",
        ]);

        Level::create([
            "name" => "Expert",
        ]);
    }
}
