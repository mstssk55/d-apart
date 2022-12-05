<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new \App\Models\User([
            'name' => '佐々木将人',
            'email' => 'test@test.com',
            'password' => Hash::make('testtest'),
            ]);
        $user->save();
        $user = new \App\Models\User([
            'name' => '佐藤',
            'email' => 'test1@test.com',
            'password' => Hash::make('testtest'),
            ]);
        $user->save();

        $user = new \App\Models\User([
            'name' => '田村',
            'email' => 'tes2@test.com',
            'password' => Hash::make('testtest'),
            ]);
        $user->save();
    }
}
