<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Roles;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $user = User::create([

        	'name' => 'Encoderslab',
        	'email' => 'encoderslab@gmail.com',
        	'password' => bcrypt('EncodersLab@2019')

        ]);

        DB::table('roles')->insert([
        	'role' => 'SuperAdmin'
        ]);

        DB::table('roles')->insert([
        	'role' => 'Admin'
        ]);

        DB::table('roles')->insert([
        	'role' => 'User'
        ]);


        DB::table('role_user')->insert([
        		'user_id' => $user->id,
        		'role_id' => 1
        ]);


    }
}
