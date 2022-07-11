<?php

namespace Database\Seeders;
use App\Models\Construction;

use Illuminate\Database\Seeder;

class ConstructionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $construction = new Construction([
            'name' => '鉄筋コンクリート造',
            ]);
        $construction->save();
        $construction = new Construction([
            'name' => '木造',
            ]);
        $construction->save();
        $construction = new Construction([
            'name' => '鉄骨コンクリート蔵',
            ]);
        $construction->save();
    }
}
