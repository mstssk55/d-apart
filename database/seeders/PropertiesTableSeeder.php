<?php

namespace Database\Seeders;
use App\Models\Property;

use Illuminate\Database\Seeder;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $property = new Property([
            'name' => 'test',
            'user_id' => 1,
            ]);
        $property->save();

    }
}
