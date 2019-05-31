<?php

use App\User;
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
        $user = User::where('email', 'admin@techub.ge')->first();

        if(!$user){
            User::create([
                'name' => 'admin',
                'email' => 'admin@techub.ge',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]);
        };
    }
}
