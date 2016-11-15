<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ],[
            'name' => 'User One',
            'email' => 'one@example.com',
            'password' => bcrypt('password'),
        ],[
            'name' => 'User Two',
            'email' => 'two@example.com',
            'password' => bcrypt('password'),
        ]]);

        $admin = User::find(1);
        $admin->permissions()->sync([1]);
        $admin->save();

        $one = User::find(2);
        $one->permissions()->sync([2,3]);
        $one->save();

        $two = User::find(3);
        $two->permissions()->sync([2]);
        $two->save();
    }
}
