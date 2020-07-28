<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Ivan Putra Eriansya',
            'email' => 'putra.ivan90@gmail.com',
            'username' => 'mivanputra',
            'password' => 'test1234'
        ]);;

        User::create([
            'name' => 'Van',
            'email' => 'eriansha.van@gmail.com',
            'username' => 'vann',
            'password' => 'vann1234'
        ]);;
    }
}
