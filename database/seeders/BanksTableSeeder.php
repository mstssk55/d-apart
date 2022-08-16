<?php

namespace Database\Seeders;
use App\Models\Bank;

use Illuminate\Database\Seeder;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $bank = new Bank([
            'name' => '北洋銀行',
            'ratio' => 1.5,
            ]);
        $bank->save();
        $bank = new Bank([
            'name' => '北海道銀行',
            'ratio' => 1.3,
            ]);
        $bank->save();


    }
}
