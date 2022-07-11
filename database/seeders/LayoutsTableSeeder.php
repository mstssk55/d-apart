<?php

namespace Database\Seeders;
use App\Models\Layout;

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
        $layout = new Layout([
            'name' => '１LDK',
            ]);
        $layout->save();

    }
}
