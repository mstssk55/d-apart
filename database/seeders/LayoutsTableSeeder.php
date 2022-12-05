<?php

namespace Database\Seeders;
use App\Models\layout;

use Illuminate\Database\Seeder;

class LayoutsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $layout = new layout([
            'name' => '１LDK',
            ]);
        $layout->save();

    }
}
